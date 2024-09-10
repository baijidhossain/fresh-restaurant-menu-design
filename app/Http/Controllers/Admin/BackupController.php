<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Console\Commands\BackupSystem;

use League\Flysystem\FilesystemException;

class BackupController extends Controller
{
  private $ftpDisk;

  public function __construct()
  {
    $this->ftpDisk = Storage::disk('ftp');
  }

  public function index()
  {
    try {
      // Attempt to list files in the root directory
      $this->ftpDisk->listContents('');
    } catch (FilesystemException $e) {
      // If an exception is thrown, the connection failed
      throw new \Exception('Failed to connect to FTP server: ' . $e->getMessage());
    }

    $databaseBackups = $this->getBackups('database');
    $codebaseBackups = $this->getBackups('codebase');

    return view('admin.backups.index', compact('databaseBackups', 'codebaseBackups'));
  }

  public function download($type, $filename)
  {
    $path = "{$type}/{$filename}";

    if (!$this->ftpDisk->exists($path)) {
      return back()->with('error', 'Backup file not found.');
    }

    return response()->stream(
      function () use ($path) {
        $stream = $this->ftpDisk->readStream($path);
        fpassthru($stream);
        fclose($stream);
      },
      200,
      [
        'Content-Type' => $this->ftpDisk->mimeType($path),
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
      ]
    );
  }

  public function delete($type, $filename)
  {
    $path = "{$type}/{$filename}";

    if ($this->ftpDisk->exists($path)) {
      $this->ftpDisk->delete($path);
      return back()->with('success', 'Backup deleted successfully.');
    }

    return back()->with('error', 'Backup file not found.');
  }

  public function create(Request $request)
  {
    $type = $request->input('type');

    if (!in_array($type, ['database', 'codebase'])) {
      return back()->with('error', 'Invalid backup type.');
    }

    $backupSystem = new BackupSystem();

    if ($type === 'database') {

      $backupSystem->backupDatabase();
    } else {

      $backupSystem->backupCodebase();
    }

    return back()->with('success', ucfirst($type) . ' backup created successfully.');
  }

  private function getBackups($type)
  {

    return collect($this->ftpDisk->files($type))
      ->map(function ($file) {
        return [
          'name' => basename($file),
          'size' => $this->ftpDisk->size($file),
          'last_modified' => $this->ftpDisk->lastModified($file),
        ];
      })
      ->sortByDesc('last_modified')
      ->values();
  }
}
