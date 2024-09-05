<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupSystem extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Run backup system, upload to FTP, clean local storage, and maintain latest 5 backups on FTP';

    private $ftpDisk;

    public function __construct()
    {
        parent::__construct();
        $this->ftpDisk = Storage::disk('ftp');
    }

    public function handle()
    {
        $this->backupDatabase();
        $this->backupCodebase();
    }

    public function backupDatabase()
    {
        $filename = 'database_backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/database/' . $filename);

        // Ensure the backup directory exists
        File::makeDirectory(dirname($path), 0755, true, true);

        // Get database configuration
        $host = env('DB_HOST', 'localhost');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $database = env('DB_DATABASE', 'gocards');

        // Create database dump
        exec("mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$path}");

        \Log::info('Database backup completed: ' . $filename);

        // Upload to FTP
        if ($this->uploadToFtp($path, 'database/' . $filename)) {
            $this->deleteLocalBackup($path);
            $this->maintainLatestBackups('database');
        }
    }

    public function backupCodebase()
    {
        // Only run on the first day of each month
        if (date('d') !== '01') {
            //return;
        }

        $filename = 'codebase_backup_' . date('Y-m-d_H-i-s') . '.zip';
        $path = storage_path('app/backups/codebase/' . $filename);

        // Ensure the backup directory exists
        File::makeDirectory(dirname($path), 0755, true, true);

        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(base_path()),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen(base_path()) + 1);

                    // Exclude some directories and files
                    if (!$this->shouldExclude($relativePath)) {
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }

            $zip->close();
            \Log::info('Codebase backup completed: ' . $filename);

            // Upload to FTP
            if ($this->uploadToFtp($path, 'codebase/' . $filename)) {
                $this->deleteLocalBackup($path);
                $this->maintainLatestBackups('codebase');
            }
        } else {
            \Log::error('Failed to create zip file');
        }
    }

    private function shouldExclude($path)
    {
        $excludeList = [
            'node_modules',
            'vendor',
            'storage/app/backups',
            '.git',
            '.env',
        ];

        foreach ($excludeList as $excluded) {
            if (strpos($path, $excluded) === 0) {
                return true;
            }
        }

        return false;
    }

    private function uploadToFtp($localPath, $remotePath)
    {
        try {
            $fileStream = fopen($localPath, 'r');

            // Upload the file
            if ($this->ftpDisk->put($remotePath, $fileStream)) {
                \Log::info("File uploaded successfully to FTP: $remotePath");
                fclose($fileStream);
                return true;
            } else {
                \Log::error("Failed to upload file to FTP: $remotePath");
                fclose($fileStream);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error("Error uploading to FTP: " . $e->getMessage());
            return false;
        }
    }

    private function deleteLocalBackup($path)
    {
        if (File::exists($path)) {
            File::delete($path);
            \Log::info("Local backup deleted: $path");
        } else {
            $this->warn("Local backup not found: $path");
        }
    }

    private function maintainLatestBackups($type)
    {
        $files = $this->ftpDisk->files($type);
        $backups = collect($files)->sort()->reverse()->values();

        if ($backups->count() > 5) {
            foreach ($backups->slice(5) as $oldBackup) {
                $this->ftpDisk->delete($oldBackup);
                \Log::info("Deleted old FTP backup: $oldBackup");
            }
        }
    }
}
