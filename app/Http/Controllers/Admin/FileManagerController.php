<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileManagerController extends Controller
{
  function index() {}

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

      $fileManagerCatalog = DB::table('filemanagers')
        ->select('catalog', DB::raw('GROUP_CONCAT(id) as ids'), DB::raw('GROUP_CONCAT(name) as name'))
        ->groupBy('catalog')
        ->get();
      $allFiles = Storage::allFiles('public/filemanager/products');

      $action = "item_modal";

      $modal_title = "Select Item Image";
      $allFiles = Storage::allFiles('public/filemanager/products');
    }

    return view('admin.filemanager.modal', compact(
      'action',
      'modal_title',
      'allFiles',
      'modal_type',
      'fileManagerCatalog'
    ));
  }

  public function getitem($catalog = "")
  {

    // Build the query to get file manager records
    $fileManagerCatalogQuery = DB::table('filemanagers')->select('name');

    // Apply the catalog filter if it's not "all"
    if ($catalog !== "all") {
      $fileManagerCatalogQuery->where('catalog', $catalog);
    }

    // Execute the query and get the results
    $fileManagerCatalog = $fileManagerCatalogQuery->get();

    $catalogFiles = [];

    foreach ($fileManagerCatalog as $file) {
      $filePath = "public/filemanager/products/{$file->name}";

      if (Storage::exists($filePath)) {
        $catalogFiles[] = str_replace("/storage/", Storage::url($filePath), $filePath); // Replace "/storage/" with the URL
      }
    }

    return view('frontend.catalog_item.items', compact('catalogFiles'));
  }
}
