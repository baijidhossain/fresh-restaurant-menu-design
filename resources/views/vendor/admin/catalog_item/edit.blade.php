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

  #preview-product{
    position: absolute;
      width: 100%;
      height: 100%;
      object-fit: contain;
  }

  #file-input-logo,
  #file-input-banner,
  #file-input-product {
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
<div class="py-12">
  <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4"> Edit Catalog Item </h2>
    
    <x-partials.card>
      <x-slot name="title">
        <a href="{{ route('catalog.item.index') }}" class="mr-4"><i class="fad fa-arrow-left"></i></a>
      </x-slot>

      <form action="{{ route('catalog.item.update', $catalog_item->id) }}" method="POST" class="mt-8 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Specify the PUT method for updating -->

        <div class="flex flex-wrap">
          <!-- Catalog Name -->
          <div class="my-2 w-full">
            <label for="catalog_id" class="label font-medium text-gray-700 block mb-2">Catalog Name</label>
            <select id="catalog_id" name="catalog_id"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none">
              <option value="" disabled>Select a catalog</option>
              @foreach($catalogs as $catalog)
              <option value="{{ $catalog->id }}" {{ $catalog->id == $catalog_item->catalog_id ? 'selected' : '' }}>
                {{ $catalog->name }}</option>
              @endforeach
            </select>
            @error('catalog_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Menu Name -->
          <div class="my-2 w-full">
            <label for="name" class="block text-sm font-medium text-gray-700">Menu Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $catalog_item->name) }}"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
              required>
            @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Description -->
          <div class="my-2 w-full">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none">{{ old('description', $catalog_item->description) }}</textarea>
            @error('description')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Price -->
          <div class="my-2 w-full">
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" id="price" name="price" value="{{ old('price', $catalog_item->price) }}"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
              step="0.01" required>
            @error('price')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Offer Price -->
          <div class="my-2 w-full">
            <label for="offer_price" class="block text-sm font-medium text-gray-700">Offer Price</label>
            <input type="number" id="offer_price" name="offer_price"
              value="{{ old('offer_price', $catalog_item->offer_price) }}"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
              step="0.01">
            @error('offer_price')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Popular -->
          <div class="my-2 w-full">
            <label for="popular" class="block text-sm font-medium text-gray-700">Popular</label>
            <select id="popular" name="popular"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none">
              <option value="0" {{ old('popular', $catalog_item->popular) == 0 ? 'selected' : '' }}>No</option>
              <option value="1" {{ old('popular', $catalog_item->popular) == 1 ? 'selected' : '' }}>Yes</option>
            </select>
            @error('popular')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status -->
          <div class="my-2 w-full">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none">
              <option value="1" {{ old('status', $catalog_item->status) == 1 ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', $catalog_item->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Display Order -->
          <div class="my-2 w-full">
            <label for="display_order" class="block text-sm font-medium text-gray-700">Display Order</label>
            <input type="number" id="display_order" name="display_order"
              value="{{ old('display_order', $catalog_item->display_order) }}"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
              required>
            @error('display_order')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>





          <div class="my-2 w-1/2 pr-3">
            <label for="product" class="label font-medium text-gray-700 block mb-2">
                Image <small>(Size 1200 x 720px || Max: 1MB)</small>
            </label>
            <div class="drop-area" id="drop-area-product">
                <input type="file" id="file-input-product" name="product" accept="image/*" hidden="">
                <img id="preview-product" src="{{ $catalog_item->image ? Storage::url("restaurant/products/".$catalog_item->image) : '' }}" alt="Product Preview" >
                <i class="fa-solid fa-upload upload_icon" id="icon-product"></i>
            </div>
        </div>





        </div>

        <div class="mt-8 flex justify-end">
          <a href="{{ route('catalog.item.index') }}"
            class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Back to Index</a>
          <button type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
        </div>
      </form>
    

    </x-partials.card>

  </div>
</div>

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
@endsection
