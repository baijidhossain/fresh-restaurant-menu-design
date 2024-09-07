<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
  function index() {}

  function files()
  {

    $allFiles = Storage::allFiles('public/filemanager');

    $modal_title = "File Manager";
    $action = "files";

    return view('admin.filemanager.modal', compact('action', 'modal_title', 'allFiles'));
  }
}
