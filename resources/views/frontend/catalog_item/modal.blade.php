@if ($action == "add")

<form action="{{ route('account.catalog.item.store') }}" method="POST" enctype="multipart/form-data"
  onsubmit="return validateForm()">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>

  </div>

  <div class="modal-body">
    <div class="mb-3">
      <label for="catalog_id" class="form-label required-star">Catalog Name <span
          class="required-indicator">*</span></label>
      <select id="catalog_id" name="catalog_id" class="form-control" required>
        <option value="" selected disabled>Select a catalog</option>
        @foreach($catalogs as $catalog)
        <option value="{{ $catalog->id }}" {{ old('catalog_id') == $catalog->id ? 'selected' : '' }}>
          {{ $catalog->name }}
        </option>
        @endforeach
      </select>
      @error('catalog_id')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="mb-3">
          <label for="name" class="form-label required-star"> Item Name <span
              class="required-indicator">*</span></label>
          <input type="text" class="form-control" id="name" name="name" maxlength="100" placeholder="Ex: Pizza"
            value="{{ old('name') }}" required>
          @error('name')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="row">

          <div class="col-6">
            <div class="form-group mb-3">
              <label for="price" class="form-label required-star">Item Price <span
                  class="required-indicator">*</span></label>
              <input type="number" class="form-control" id="price" name="price" placeholder="Ex: 1000"
                value="{{ old('price') }}" required>
              @error('price')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="col-6">
            <div class="form-group mb-3">
              <label for="offer_price" class="form-label"> Offer Price </label>
              <input type="number" class="form-control" id="offer_price" name="offer_price" placeholder="Ex: 10.00"
                value="{{ old('offer_price') }}">
              @error('offer_price')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

        </div>

      </div>

      <div class="col-md-4">
        <div class="mb-3">
          <label for="file-input-product" class="form-label required-star"> Product Image <span
              class="required-indicator">*</span> </label>

          <a href="{{ route("account.filemanager.files",'item_modal') }}" data-bs-toggle="modal" class="parent-of-input-and-preview-image-tag" data-bs-target="#fileManagerModal">

            <div class="drop-area" id="drop-area-product">

              <input type="file" class="file-input-product" accept="image/*" name="product" hidden>
              <img class="preview-product" src="#" alt="Product Preview"
                style="display: {{ old('product') ? 'block' : 'none' }}; max-width: 100%;">
              <i class="ri-upload-2-line upload_icon"></i>

            </div>

          </a>

          @error('product')
          <p class="text-red-600 text-sm mt-1">{{ $message }} </p>
          @enderror
          <p class="text-red-600 text-sm mt-1 text-danger font-size-11 image-validate"> </p>
        </div>
      </div>

    </div>

    <div class="mb-3">
      <label for="description" class="form-label required-star">Description <span class="required-indicator">*</span>
      </label>
      <small>(Max 150 char)</small>
      <textarea class="form-control" id="description" name="description" rows="2" placeholder="Ex: Description..."
        required>{{ old('description') }}</textarea>
      @error('description')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="row">
      <div class="col-6">

        <div class="mb-3">
          <label for="status" class="form-label required-star">Status <span class="required-indicator">*</span></label>
          <select class="form-select" aria-label="status" name="status" required id="status">
            <option selected value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish</option>
            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Disable</option>
          </select>
          @error('status')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

      </div>

      <div class="col-6">
        <div class="form-group mb-3">
          <label for="display_order" class="form-label">Display Order </label>
          <input type="number" class="form-control" id="display_order" name="display_order" placeholder="Ex: 1"
            value="{{ old('display_order') }}">
          @error('display_order')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="custom_field" class="form-label">Available Time</label>
          <input type="text" class="form-control" id="custom_field" name="custom_field"
            placeholder="Ex: Available ( 10:00 am - 10:00 pm )" value="{{ old('custom_field') }}">
          @error('custom_field')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label for="popular" class="form-label required-star"> Popular <span
              class="required-indicator">*</span></label>
          <select class="form-select" aria-label="popular" name="popular" required id="popular">
            <option value="1" {{ old('popular') == '1' ? 'selected' : '' }}>Yes</option>
            <option selected value="0" {{ old('popular') == '0' ? 'selected' : '' }}>No</option>
          </select>
          @error('popular')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer catalog-footer">
    <button type="button" class="btn btn-outline-primary  float-end px-3 btn-cancel"
      data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary  float-end px-3 btn-save">Save</button>
  </div>
</form>

@endif

@if ($action == "edit")

<form action="{{ route('account.catalog.item.update', $catalog_item->id) }}" method="POST"
  enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <!-- This is to spoof the PUT method -->

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">
    <div class="mb-3">
      <label for="catalog_id" class="form-label required-star">Catalog Name <span
          class="required-indicator">*</span></label>
      <select id="catalog_id" name="catalog_id" class="form-control">
        <option value="" selected disabled>Select a catalog</option>
        @foreach($catalogs as $catalog)
        <option value="{{ $catalog->id }}" {{ $catalog_item->catalog_id == $catalog->id ? 'selected' : '' }}>
          {{ $catalog->name }}
        </option>
        @endforeach
      </select>
      @error('catalog_id')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="mb-3">
          <label for="name" class="form-label required-star">Item Name <span class="required-indicator">*</span>
          </label>
          <input type="text" class="form-control" id="name" name="name" maxlength="100" placeholder="Ex: Pizza"
            value="{{ old('name', $catalog_item->name) }}">
          @error('name')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-3">
              <label for="price" class="form-label required-star">Item Price <span
                  class="required-indicator">*</span></label>
              <input type="number" class="form-control" id="price" name="price" placeholder="Ex: 1000"
                value="{{ old('price', $catalog_item->price) }}">
              @error('price')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="col-6">
            <div class="form-group mb-3">
              <label for="offer_price" class="form-label">Offer Price </label>
              <input type="number" class="form-control" id="offer_price" name="offer_price" placeholder="Ex: 10.00"
                value="{{ old('offer_price', $catalog_item->offer_price) }}">
              @error('offer_price')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="mb-3">
          <label for="file-input-product" class="form-label form-label required-star">Product Image <span
              class="required-indicator">*</span></label>
          <div class="drop-area" id="drop-area-product">

            <input type="file" class="file-input-product" accept="image/*" name="product" hidden>

            <img  class="preview-product" src="{{ $catalog_item->image ? \Storage::url($catalog_item->image ) : '' }}"
              alt="Product Preview" style="display: {{ $catalog_item->image ? 'block' : 'none' }}; max-width: 100%;">
            <i class="ri-upload-2-line upload_icon" id="icon-product"></i>
          </div>
          @error('product')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          
          @enderror
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label required-star">Description <span
          class="required-indicator">*</span></label>
      <small>(Max 150 char)</small>
      <textarea class="form-control" id="description" name="description" rows="2" placeholder="Ex: Description..."
        required>{{ old('description', $catalog_item->description) }}</textarea>
      @error('description')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="row">
      <div class="col-6">
        <div class="mb-3">
          <label for="status" class="form-label required-star">Status <span class="required-indicator">*</span></label>
          <select class="form-select" aria-label="status" name="status" id="status">
            <option value="">-Select-</option>
            <option value="1" {{ old('status', $catalog_item->status) == '1' ? 'selected' : '' }}>Publish</option>
            <option value="0" {{ old('status', $catalog_item->status) == '0' ? 'selected' : '' }}>Disable</option>
          </select>
          @error('status')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="col-6">
        <div class="form-group mb-3">
          <label for="display_order" class="form-label">Display Order </label>
          <input type="number" class="form-control" id="display_order" name="display_order" placeholder="Ex: 1"
            value="{{ old('display_order', $catalog_item->display_order) }}">
          @error('display_order')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="custom_field" class="form-label ">Availabel Time </label>
          <input type="text" class="form-control" id="custom_field" name="custom_field"
            placeholder="Ex: Available ( 10:00 am - 10:00 pm )"
            value="{{ old('custom_field', $catalog_item->custom_field) }}">
          @error('custom_field')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label for="popular" class="form-label required-star">Popular <span
              class="required-indicator">*</span></label>
          <select class="form-select" aria-label="popular" name="popular" id="popular">
            <option value="">-Select-</option>
            <option value="1" {{ old('popular', $catalog_item->popular) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('popular', $catalog_item->popular) == '0' ? 'selected' : '' }}>No</option>
          </select>
          @error('popular')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
          <p class="text-red-600 text-sm mt-1 text-danger font-size-11 image-validate"></p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer catalog-footer">
    <button type="button" class="btn btn-outline-primary  float-end px-3 btn-cancel"
      data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary  float-end px-3 btn-save">Update</button>
  </div>
</form>

@endif

{{-- <script>
  // Image preview and drag & drop handling
  function setupDropArea(dropAreaId, fileInputId, previewId, iconId, maxSize) {
    var $dropArea = $('#' + dropAreaId);
    var $fileInput = $('#' + fileInputId);
    var $preview = $('#' + previewId);
    var $icon = $('#' + iconId);

    function handleFile(files) {
      if (files.length > 0) {
        var file = files[0];
        // Calculate file size in MB
        var fileSizeMB = (file.size / 1024 / 1024).toFixed(2); // Size in MB with two decimal points
        var maxSizeMB = (maxSize / 1024 / 1024).toFixed(2); // Max size in MB
        // Check file size
        if (file.size > maxSize) {
          AlertModal('warning', 'Warning', "File size exceeds the maximum limit of " + maxSizeMB +
            " MB. Your file size is " + fileSizeMB + " MB.");
          $fileInput.val(''); // Clear the file input
          $preview.hide(); // Hide the preview if the size is exceeded
          return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
          $preview.attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
      }
    }
    $dropArea.on('dragover', function(event) {
      event.preventDefault();
      $(this).addClass('dragover');
    });
    $dropArea.on('dragleave', function() {
      $(this).removeClass('dragover');
    });
    $dropArea.on('drop', function(event) {
      event.preventDefault();
      $(this).removeClass('dragover');
      var files = event.originalEvent.dataTransfer.files;
      handleFile(files);
      $fileInput[0].files = files; // Update the hidden file input with the dropped files
    });
    $fileInput.on('change', function() {
      var files = $(this)[0].files;
      handleFile(files);
    });
    // Make the icon trigger the file input click event
    $icon.on('click', function() {
      $fileInput.click();
    });
  }
  // Initialize drop areas with size limits
  $(document).ready(function() {
    setupDropArea('drop-area-product', 'file-input-product', 'preview-product', 'icon-product', 1 * 1024 *
      1024); // 1 MB for product as well
  });
</script> --}}

<script>
  function validateForm() {
    const imageInput = $(".file-input-product").val();
    if (!imageInput) {
      $(".image-validate").text("Please upload an image.");
      // Apply CSS with !important
      $(".drop-area#drop-area-product")[0].style.setProperty("height", "100px", "important");
      // Clear the message after 3 seconds
      setTimeout(function() {
        $(".image-validate").text("")
        $(".drop-area#drop-area-product")[0].style.setProperty("height", "120px", "important");
      }, 3000);
      return false; // Prevent form submission
    }
    return true; // Form is valid
  }
</script>