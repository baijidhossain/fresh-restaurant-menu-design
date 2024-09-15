<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileManagerController extends Controller
{

  public function index($directory = "products")
  {

    // Set the directory type or default to "logos"
    $directory_type = $directory ?? "logos";

    // Get files from the specified directory within 'filemanager'
    $directories = Storage::disk('public')->allDirectories("filemanager/" . $directory);

    // Remove "/filemanager/" from the path
    $directories = array_map(function ($dir) {
      return str_replace("filemanager/", "", $dir);
    }, $directories);


    $files = Storage::disk('public')->files("filemanager/" . $directory);

    // Return the view with directories, files, and the current directory type
    return view('admin.filemanager.index', compact('directories', 'files', 'directory_type'));
  }

  public function getFiles($directory = "")
  {
    // Retrieve files from the specified directory on the 'public' disk
    $files = Storage::disk('public')->files($directory);

    return view('admin.filemanager.index', compact('files', 'directory'));
  }

  function files($modal_type = "")
  {

    if (empty($modal_type) || !in_array($modal_type, ["banner_modal", "logo_modal", "item_modal"])) {
      return back();
    }

    $modal_title = "File Manager";
    $fileManagerCatalog = "";
    $action = "";

    if ($modal_type === "banner_modal") {

      $action = "banner_modal";

      $modal_title = "Select Header Background";

      $allFiles = Storage::allFiles('public/filemanager/banners');
    } elseif ($modal_type === "logo_modal") {
      $action = "logo_modal";
      $modal_title = "Select Logo";
      $allFiles = Storage::allFiles('public/filemanager/logos');
    } elseif ($modal_type === "item_modal") {

      $directories = Storage::disk('public')->directories('filemanager/products');

      $files = Storage::disk('public')->allFiles('filemanager/products');
      $allFiles = array_map(function ($file) {
        return str_replace("/storage/", "", Storage::url($file));
      }, $files);

      $action = "item_modal";

      $modal_title = "Select Item Image";

      return view('admin.filemanager.modal', compact(
        'action',
        'modal_title',
        'allFiles',
        'modal_type',
        'directories'
      ));
    }

    return view('admin.filemanager.modal', compact(
      'action',
      'modal_title',
      'allFiles',
      'modal_type',
      'fileManagerCatalog'
    ));
  }

  // File upload
  public function upload(Request $request)
  {
    // Check if more than 50 files are being uploaded
    if ($request->hasFile('images') && count($request->file('images')) > 50) {
      return back()->with('error', 'Cannot upload more than 50 files.');
    }

    // Validate the file upload request
    $validated = $request->validate([
      'images.*' => 'required|file|mimes:jpeg,png,jpg|max:500', // Adjust validation rules as needed
      'directory' => 'required|string',
    ]);

    $uploadedFiles = $request->file('images');
    $directory = 'filemanager/' . $request->directory;

    $successFiles = [];
    $errors = [];

    foreach ($uploadedFiles as $index => $file) {
      if (!$file->isValid()) {
        $errors[$index] = 'Invalid file or file too large.';
        continue;
      }

      try {
        $newFileName = 'goCards_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Process and save the image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        if ($image->width() > 1200 || $image->height() > 720) {
          $image->resize(1200, 720, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
        }

        $path = $directory . '/' . $newFileName;
        Storage::disk('public')->put($path, (string) $image->encode());

        // Track the successfully uploaded file
        $successFiles[] = $path;
      } catch (\Exception $e) {
        Log::error('File upload error: ' . $e->getMessage());
        $errors[$index] = 'Failed to process the image.';
      }
    }

    if (!empty($errors)) {
      // Remove all successfully uploaded files
      foreach ($successFiles as $filePath) {
        if (Storage::disk('public')->exists($filePath)) {
          Storage::disk('public')->delete($filePath);
        }
      }

      $errorMessages = implode(', ', array_values($errors));
      $message = "Upload failed. The following errors occurred: $errorMessages. All uploaded files have been removed.";
      $alertStatus = "error";
    } else {
      $message = 'All files uploaded successfully.';
      $alertStatus = "success";
    }

    return back()->with($alertStatus, $message);
  }

  public function createFolder(Request $request)
  {

    // Validate the request
    $request->validate([
      'name' => 'required|string|max:20', // Validation rule
    ]);

    // Get the folder name from the validated input
    $folderName = $request->input('name'); // Ensure consistency

    // Define the path where the folder will be created
    $path = "filemanager/products/" . $folderName;

    // Create the folder if it doesn't already exist
    if (Storage::disk('public')->exists($path)) {
      return back()->with('error', 'Folder already exists');
    }

    Storage::disk('public')->makeDirectory($path);

    return back()->with('success', 'New folder created successfully');
  }

  public function renameFolder(Request $request)
  {
    // Validate the request
    $request->validate([
      'old_name' => 'required|string',
      'new_name' => 'required|string',
    ]);

    // Get the old and new folder names
    $oldFolderName = $request->input('old_name');
    $newFolderName = $request->input('new_name');

    // Define the old and new folder paths
    $oldPath = "filemanager/products/" . $oldFolderName;
    $newPath = "filemanager/products/" . $newFolderName;

    // Check if the old folder exists
    if (!Storage::disk('public')->exists($oldPath)) {
      return back()->with('error', 'Old folder does not exist');
    }

    // Check if the new folder already exists
    if (Storage::disk('public')->exists($newPath)) {
      return back()->with('error', 'New folder name already exists');
    }

    // Rename the folder
    Storage::disk('public')->move($oldPath, $newPath);

    return back()->with('success', 'Folder renamed successfully');
  }

  public function deleteFolder(Request $request, $folder)
  {
    // Define the path to the folder to be deleted
    $path = "filemanager/products/" . $folder;

    // Check if the folder exists
    if (!Storage::disk('public')->exists($path)) {
      return back()->with('error', 'Folder does not exist');
    }

    // Delete the folder
    Storage::disk('public')->deleteDirectory($path);

    return back()->with('success', 'Folder deleted successfully');
  }

  public function deleteFile(Request $request)
  {
    // Define the path to the file to be deleted
    $path = $request->filepath;

    // Check if the file exists
    if (!Storage::disk('public')->exists($path)) {
      return back()->with('error', 'File does not exist');
    }

    // Delete the file
    Storage::disk('public')->delete($path);

    return back()->with('success', 'File deleted successfully');
  }

  public function showModalContent($action = "", $oldFolderName = "")
  {


    if ($action == "rename-folder") {
      $modal_title = "Rename Folder";
      $action = "rename-folder";
    } else {
      $modal_title = "New Folder";
      $action = "new-folder";
    }

    return view('admin.filemanager.modal', compact('modal_title', 'action', 'oldFolderName'));
  }
}
