@extends('admin.layouts.app')

@push('styles')
<style>
  .drop-area {
    border: 2px dashed #ccc;
    border-radius: 8px;
    width: 100%;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 1em;
    color: #aaa;
    background-color: #f9f9f9;
    position: relative;
    transition: border-color 0.3s, background-color 0.3s;
    overflow: hidden;
  }

  .drop-area#drop-area-product {
    height: 114px !important;
  }

  .drop-area.dragover {
    border-color: #4a90e2;
    background-color: #e1f5fe;
  }

  #preview-logo {
    max-width: 100%;
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  #preview-banner {
    max-width: 100%;
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  #file-input-logo,
  #file-input-banner {
    display: none;
  }

  .upload_icon {
    font-size: 15px;
    color: #ccc;
    cursor: pointer;
    position: absolute;
    bottom: 10px;
    right: 10px;
    cursor: pointer;
  }

  .text-red-600 {
    color: #e53e3e;
  }

  .text-sm {
    font-size: 0.875rem;
  }
</style>
@endpush

@section('content')

  <div class="py-12 px-12">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      New Restaurant
    </h2>

    <x-partials.card>
      <x-slot name="title">
        <a href="{{ route('restaurant.index') }}" class="mr-4"><i class="fad fa-arrow-left"></i></a>
      </x-slot>

      <form method="POST" action="{{ route('restaurant.store') }}" class="mt-4" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-wrap">

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="restaurant_user">Restaurant User</label>
          
            <select name="restaurant_user" id="restaurant_user"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('restaurant_user') border-red-500 @enderror">
              
              <option value="" {{ old('restaurant_user') == '' ? 'selected' : '' }}>-Select-</option>
          
              @foreach ($restaurant_users as $restaurant_user)
                <option value="{{ $restaurant_user->id }}" {{ old('restaurant_user') == $restaurant_user->id ? 'selected' : '' }}>
                  {{ $restaurant_user->name }}
                </option>
              @endforeach
            </select>
          
            @error('restaurant_user')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="name"> Name </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('name') border-red-500 @enderror" maxlength="255" placeholder="Name" required="required" autocomplete="off">
            @error('name')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="phone"> Phone </label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('phone') border-red-500 @enderror" maxlength="20" placeholder="Phone" autocomplete="off">
            @error('phone')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="address"> Address </label>
            <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('address') border-red-500 @enderror" maxlength="255" placeholder="Address" autocomplete="off">
            @error('address')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="start_time"> Start Time </label>
            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('start_time') border-red-500 @enderror" autocomplete="off">
            @error('start_time')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="end_time"> End Time </label>
            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('end_time') border-red-500 @enderror" autocomplete="off">
            @error('end_time')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-1/2 pr-3">
            <label for="logo" class="label font-medium text-gray-700 block mb-2"> Logo <small>(Size 150 x 150px || Max: 500kb)</small></label>
            <div class="drop-area" id="drop-area-logo">
              <input type="file" id="file-input-logo" name="logo" accept="image/*" hidden="">
              <img id="preview-logo" src="{{ old('logo') ? asset('storage/' . old('logo')) : '' }}" alt="Logo Preview" style="display: {{ old('logo') ? 'block' : 'none' }}; max-width: 100%;">
              <i class="fa-solid fa-upload upload_icon" id="icon-logo"></i>
            </div>
            @error('logo')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-1/2">
            <label for="banner" class="label font-medium text-gray-700 block mb-2"> Banner <small>(Size 850 x 470px || Max: 1mb)</small></label>
            <div class="drop-area" id="drop-area-banner">
              <input type="file" id="file-input-banner" name="banner" accept="image/*" hidden="">
              <img id="preview-banner" src="{{ old('banner') ? asset('storage/' . old('banner')) : '' }}" alt="Banner Preview" style="display: {{ old('banner') ? 'block' : 'none' }}; max-width: 100%;">
              <i class="fa-solid fa-upload upload_icon" id="icon-banner"></i>
            </div>
            @error('banner')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="mt-10">
          <a href="{{ route('restaurant.index') }}" class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
            <i class="fa-duotone fa-arrow-left"></i> Back to Index
          </a>
          <button type="submit" class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white float-right">
            <i class="mr-1 fa-duotone fa-floppy-disk"></i> Create
          </button>
        </div>
      </form>
      
    </x-partials.card>
  </div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  // Image preview and drag & drop handling
  function setupDropArea(dropAreaId, fileInputId, previewId, iconId) {
    var $dropArea = $('#' + dropAreaId);
    var $fileInput = $('#' + fileInputId);
    var $preview = $('#' + previewId);
    var $icon = $('#' + iconId);

    function handleFile(files) {
      if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
          $preview.attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
      }
    }

    $dropArea.on('dragover', function (event) {
      event.preventDefault();
      $(this).addClass('dragover');
    });

    $dropArea.on('dragleave', function () {
      $(this).removeClass('dragover');
    });

    $dropArea.on('drop', function (event) {
      event.preventDefault();
      $(this).removeClass('dragover');

      var files = event.originalEvent.dataTransfer.files;
      handleFile(files);
      $fileInput[0].files = files; // Update the hidden file input with the dropped files
    });

    $fileInput.on('change', function () {
      var files = $(this)[0].files;
      handleFile(files);
    });

    // Make the icon trigger the file input click event
    $icon.on('click', function () {
      $fileInput.click();
    });
  }

  // Initialize drop areas
  $(document).ready(function () {
    setupDropArea('drop-area-logo', 'file-input-logo', 'preview-logo', 'icon-logo');
    setupDropArea('drop-area-banner', 'file-input-banner', 'preview-banner', 'icon-banner');
    setupDropArea('drop-area-product', 'file-input-product', 'preview-product', 'icon-product');
  });
</script>
@endpush
