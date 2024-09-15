<?php

namespace App\Http\Controllers;

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
  public function index($directory = "logos")
  {


    // Get directories from the 'public' disk (storage/app/public)
    $directories = Storage::disk('public')->directories('filemanager'); // Specify the path if needed

    // Set the directory type or default to "logos"
    $directory_type = $directory ?? "logos";

    // Get files from the specified directory within 'filemanager'
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

  function modal($modal_type = "")
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

      $allFiles = Storage::disk('public')->allFiles('filemanager/products');

      $action = "item_modal";

      $modal_title = "Select Item Image";

      return view('frontend.filemanager.modal', compact(
        'action',
        'modal_title',
        'allFiles',
        'modal_type',
        'directories'
      ));
    }

    return view('frontend.filemanager.modal', compact(
      'action',
      'modal_title',
      'allFiles',
      'modal_type',
      'fileManagerCatalog'
    ));
  }

  public function getItem(Request $request)
  {

    $directory = $request->directory;

    $allFiles = Storage::disk('public')->Files($directory);

    return view('frontend.catalog_item.items', compact('allFiles'));
  }

  // public function upload(Request $request)
  // {
  //   // Validate the file upload request
  //   $request->validate([
  //     'file' => 'required|file|mimes:jpeg,png,jpg|max:2048', // Adjust validation rules as needed
  //     'directory' => 'required',
  //   ]);

  //   // Handle the file upload
  //   $newFileName = $this->handleFileUpload($request, 'file', 'filemanager/' . $request->directory);

  //   return back()->with('success', 'File uploaded successfully.');
  // }

  public function delete(Request $request)
  {
    $file = $request->input('file');

    if (Storage::disk('public')->exists($file)) {
      Storage::disk('public')->delete($file);
      return response()->json(['success' => 'File deleted successfully']);
    }

    return response()->json(['error' => 'File not found'], 404);
  }

  private function handleFileUpload($request, $fileKey, $storagePath)
  {
    // Check if the request contains the file
    if ($request->hasFile($fileKey)) {
      // Get the uploaded file
      $file = $request->file($fileKey);
      $newFileName = 'goCards_' . $fileKey . '_' . time() . '.' . $file->getClientOriginalExtension();

      // Create an image manager instance and read the uploaded file
      $manager = new ImageManager(new Driver());
      $image = $manager->read($file->getRealPath());

      // Resize the image if necessary
      if ($image->width() > 1200 || $image->height() > 720) {
        $image->coverDown(1200, 720);
      }

      // Save the processed image
      $originalImagePath = $storagePath . '/' . $newFileName;
      Storage::disk('public')->put($originalImagePath, (string) $image->encode());

      // Return the new file name
      return $newFileName;
    }

    // Return null or some default value if no file is uploaded
    return null;
  }
}
