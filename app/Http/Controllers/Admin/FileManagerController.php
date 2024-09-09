<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
  function index() {}

  function files($modal_type = "")
  {

    if (empty($modal_type) || !in_array($modal_type, ["banner_modal", "logo_modal"])) {
      return back();
    }

    if ($modal_type === "banner_modal") {
      $allFiles = Storage::allFiles('public/filemanager/banners');
    } else {
      $allFiles = Storage::allFiles('public/filemanager/logos');
    }

    $modal_title = "Select Header";
    $action = "files";

    return view('admin.filemanager.modal', compact('action', 'modal_title', 'allFiles', 'modal_type'));
  }
}
