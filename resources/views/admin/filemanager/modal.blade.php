<style>
  .nav-tabs .nav-link:focus,
  .nav-tabs .nav-link:hover {
    isolation: isolate;
    border-color: #ffffff00;
  }

  .nav-item button {
    font-weight: 600;
    font-size: 16px;
    padding: 10px 0px;
    margin: 0 14px;
  }

  .nav-tabs .nav-link.active {
    border-bottom: 3px solid #0d6efd !important;
    color: #0d6efd !important;
  }

  .nav-link {
    color: #5f6368 !important;
  }

  .list-group-item.active {
    z-index: 2;
    color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
  }

  @media only screen and (max-width: 400px) {
    .list-group-item {
      font-size: 11px !important;
      padding: 10px 5px 10px 14px !important;
    }

  }


  /*image drop  */
  .modal-upload-area {
    border: none;
    padding: 20px;
    text-align: center;
    position: relative;
    cursor: pointer;
    height: 220px;
    background-color: transparent;

  }

  .drop-area.dragover {
    border-color: #007bff;
    background-color: #e9f7ff;
  }

  .browse-btn {
    bottom: 0;
  }

  .preview-image {
    width: 35%;
  }

  .image-preview {
    width: 35%;
  }

  .modal-preview-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 96%;
  }

  .action-buttons {
    position: absolute;
    top: 90%;
    left: 80%;
    transform: translate(-50%, -50%);
    width: 45%;
  }

  .clear-button {
    font-weight: 600 !important;
    color: #6c757d !important;
  }

  .done-button {
    font-weight: 600 !important;
  }

  .image-placeholder {
    width: 50% !important;
  }

  .image-placeholder.active {
    width: 100% !important;
    max-height: 120px !important;
    min-height: 100px !important;
    object-fit: cover !important;
  }

  .modal-image-preview .image-preview {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .thumbnail {
    cursor: pointer;
    transition: all 0.1s;
  }

  .thumbnail:hover {
    border: 2px solid #0d6efd;
    padding: 2px;
  }

  .close-insert {
    cursor: pointer;

  }

  .selected-theme {
    border: 3px solid #007bff !important;
    padding: 8px !important;
  }

  .theme>div:last-child {
    margin-bottom: 20px;
    /* Adjust the value to your needs */
  }

  .list-group-item:first-child {
    margin-top: 10px;
  }
</style>

@csrf

{{-- @if ($modal_type == "logo_modal" || $modal_type == "banner_modal")

<div class="modal-header border-0">
  <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body px-0 pb-0">

  <ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme-tab-pane" type="button"
        role="tab" aria-controls="theme-tab-pane" aria-selected="true">Themes</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-tab-pane" type="button"
        role="tab" aria-controls="upload-tab-pane" aria-selected="false">Upload</button>
    </li>

  </ul>

  <div class="tab-content " id="myTabContent" style="height: 480px;">

    <div class="tab-pane fade align-content-center text-center" id="upload-tab-pane" role="tabpanel"
      aria-labelledby="upload-tab" tabindex="0" style="height: 480px;">

      <div class="mb-3">

        <div class="modal-upload-area" style="height: 480px;">

          <div class="modal-preview-container">

            <input type="file" hidden>

            <div class="modal-image-preview">

              <img class="image-placeholder" src="{{ \Storage::url('default/upload_background.png')  }}"
                alt="Image Preview">

            </div>

            <div class="browse-section">
              <button class="btn btn-primary browse-btn">Browse</button>
              <p class="mb-0 mt-2" style="font-weight: 500; font-size: 18px; color: #999999;"> or drag a file here </p>
            </div>

          </div>

          <div class="text-end modal-action-buttons d-none">

            <button class="btn clear-button">Clear</button>
            <button class="btn done-button text-primary back-to-previeus-modal">Done</button>

          </div>

        </div>

      </div>

    </div>

    <div class="tab-pane fade show active" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0"
      style="height: 480px;">

      <div class="row">
        <div class="col-6 col-sm-4">

          @if ($modal_type === "banner_modal")
          <div class="list-group mt-3">
            <a href="#"
              class="list-group-item list-group-item-action active border-0 rounded-0 rounded-end-5">Restaurant
              Banner</a>
          </div>
          @else
          <div class="list-group mt-3">
            <a href="#"
              class="list-group-item list-group-item-action active border-0 rounded-0 rounded-end-5">Restaurant
              Logo</a>
          </div>
          @endif

        </div>

        <div class="col-6 col-sm-8">

          <div class="theme  overflow-y-scroll pe-3" id="drop-area-banner" style="height: 480px;">
            @if(!empty($allFiles))
            @foreach($allFiles as $file)
            <div class="mt-3 text-center">
              <img class="thumbnail" src="{{ Storage::url($file) }}" alt="Image" style="max-width: 100%; height: auto;">
            </div>
            @endforeach
            @else
            <p>No images found in the directory.</p>
            @endif
          </div>

        </div>
      </div>

      <div
        class="d-none alert alert-primary align-items-center border-0 d-flex justify-content-between position-absolute rounded-0 text-end w-100 shadow-sm"
        role="alert" style="bottom: -3%;">
        <p class="m-0"><i class="ri-close-line me-2 close-insert"></i> 1 Selected</p>
        <button class="btn btn-primary px-4 rounded-1 theme-insert">Insert</button>
      </div>

    </div>

  </div>

</div>

<script>
  $(document).ready(function() {
    // Add classes to the modal on load
    $(".modal-dialog").addClass("modal-dialog-centered modal-lg");
    $(".modal").addClass("overflow-hidden");
    $(".modal-content").addClass("rounded-0");
    // Function to handle file preview and setup
    function setupDropArea() {
      $('.modal-upload-area').each(function() {
        var $dropArea = $(this);
        var modalType = '{{ $modal_type }}'; // Ensure correct modal type is passed
        // Define file input, form section, and preview class based on modal type
        var settings = modalType === "banner_modal" ? {
          $fileInput: $('.input_banner'),
          $formSection: $(".banner_section"),
          previewClass: 'preview_banner',
          inputClass: 'input_banner'
        } : {
          $fileInput: $('.input_logo'),
          $formSection: $(".logo_section"),
          previewClass: 'preview_logo',
          inputClass: 'input_logo'
        };
        var $preview = $dropArea.find('.image-preview');
        var $icon = $dropArea.find('.browse-btn');
        // Function to handle file validation and preview
        function handleFile(files) {
          if (files.length === 0) return;
          var file = files[0];
          var validTypes = ['image/jpeg', 'image/png', 'image/jpg']; // Allowed file types
          // Validate if the file is an image (jpg, jpeg, or png)
          if (!validTypes.includes(file.type)) {
            alert('Please select an image file (jpg, jpeg, png).');
            settings.$fileInput.val(''); // Reset the file input
            return;
          }
          // Validate file size
          if (file.size > 1 * 1024 * 1024) { // 1 MB limit
            alert('File size exceeds the maximum limit of 1 MB.');
            settings.$fileInput.val(''); // Reset the file input
            $preview.hide();
            return;
          }
          // Read and preview the image using FileReader
          var reader = new FileReader();
          reader.onload = function(e) {
            var imageUrl = e.target.result;
            // Create new image preview element
            var $newPreview = $('<img>', {
              class: 'image-preview',
              src: imageUrl,
              alt: 'Image Preview'
            });
            // Update modal preview
            $(".modal-image-preview").html($newPreview);
            $(".browse-section").hide();
            $(".modal-action-buttons").removeClass("d-none");
            // On 'Done' button click, update form section
            $(".done-button").click(function() {
              $preview.attr('src', imageUrl).show();
              settings.$formSection.find(`.${settings.previewClass}`).attr('src', imageUrl).show();
              settings.$formSection.find(`.${settings.inputClass}`).val(imageUrl);
            });
          };
          reader.readAsDataURL(file);
        }
        // Drag and drop handling
        $dropArea.on('dragover', function(event) {
          event.preventDefault();
          $dropArea.addClass('dragover');
        }).on('dragleave', function() {
          $dropArea.removeClass('dragover');
        }).on('drop', function(event) {
          event.preventDefault();
          $dropArea.removeClass('dragover');
          var files = event.originalEvent.dataTransfer.files;
          handleFile(files);
          settings.$fileInput[0].files = files; // Update the input's files
        });
        // File input change handler
        settings.$fileInput.on('change', function() {
          var files = settings.$fileInput[0].files;
          handleFile(files);
        });
        // Trigger file input when upload icon is clicked
        $(document).on('click', '.browse-btn', function() {
          settings.$fileInput.click();
        });
      });
    }
    // Initialize drop area setup
    setupDropArea();
    $(".modal-action-buttons .clear-button").click(function() {
      $(".modal-preview-container").html(`
          <div class="modal-image-preview">
                    <img class="preview-image" src="https://menu.gocards.com.bd/storage/default/upload_background.png" alt="Image Preview">
                      <img class="image-preview" src="" alt="Image Preview" style="display: none">
                    </div>
                    <div class="browse-section">
                      <button class="btn btn-primary browse-btn">Browse</button>
                      <p class="mb-0 mt-2" style="font-weight: 500; font-size: 18px; color: #999999;"> or drag a file here </p>
                    </div>`)
      $(".browse-section").show()
      $(".modal-action-buttons").addClass("d-none")
    })
  });
</script>

<script>
  $(document).ready(function() {
    // Handle thumbnail click
    $('.thumbnail').click(function() {
      // Get the src attribute of the clicked thumbnail
      var imgSrc = $(this).attr('src');
      if (imgSrc) {
        // Construct the full theme URL using Laravel's URL helper
        var themeUrl = "{{ url('/') }}/" + imgSrc;
        // Set the new data attribute on the theme-insert element
        $(".theme-insert").attr('data-theme-url', themeUrl);
        $(".theme-insert").parents(".alert").removeClass('d-none');
        $('.thumbnail').removeClass("selected-theme")
        $(this).addClass("selected-theme")
      } else {
        console.error('No "src" attribute found on the clicked thumbnail.');
      }
    });
    // Handle theme-insert click
    $(".theme-insert").click(function() {
      var themeUrl = $(this).data('theme-url');
      var fileUrl = themeUrl;
      var modalType = '{{ $modal_type }}';
      var inputSelector = modalType === "banner_modal" ? '.input_banner' : '.input_logo';
      var previewSelector = modalType === "banner_modal" ? '.preview_banner' : '.preview_logo';
      console.log('File URL: ', fileUrl);
      $.ajax({
        url: fileUrl,
        method: 'GET',
        xhrFields: {
          responseType: 'blob'
        },
        success: function(blob) {
          if (blob.type.startsWith('image/')) {
            var fileExtension = blob.type.split('/')[1];
            var fileName = generateRandomFileName(fileExtension);
            var fileObjectUrl = URL.createObjectURL(blob);
            $('#file-preview').html('<img src="' + fileObjectUrl + '" alt="File Preview">');
            var file = new File([blob], fileName, {
              type: blob.type
            });
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            $(inputSelector)[0].files = dataTransfer.files;
            $(previewSelector).attr('src', fileObjectUrl).show();
            $("#fileManagerModal").modal("hide");
          } else {
            $('#file-preview').html('<p>File type is not supported for preview.</p>');
          }
        },
        error: function() {
          alert('Failed to fetch file.');
        }
      });
    });
    $(".close-insert").click(function() {
      $('.thumbnail').removeClass("selected-theme")
      $(this).parents(".alert").addClass("d-none");
    });
    // Generate a random file name
    function generateRandomFileName(extension) {
      var timestamp = new Date().getTime();
      return 'file_' + timestamp + '.' + extension;
    }
  });
</script>

@endif --}}

@if($action == "item_modal")

<div class="modal-header border-0">
  <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
  <button type="button" class="btn-close back-to-previeus-modal"></button>
</div>

<div class="modal-body px-0 pb-0">

  <ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme-tab-pane" type="button"
        role="tab" aria-controls="theme-tab-pane" aria-selected="true">Photos</button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-tab-pane" type="button"
        role="tab" aria-controls="upload-tab-pane" aria-selected="false">Upload</button>
    </li>

  </ul>

  <div class="tab-content " id="myTabContent" style="height: 480px;">

    <div class="tab-pane fade align-content-center text-center" id="upload-tab-pane" role="tabpanel"
      aria-labelledby="upload-tab" tabindex="0" style="height: 480px;">

      <div class="mb-3">

        <div class="modal-preview-container">
          <div class="modal-drop-area">
            <img class="image-placeholder" src="{{ \Storage::url('default/upload_background.png') }}"
              alt="Image Preview">

            <div class="browse-section">
              <button class="btn btn-primary browse-btn">Browse</button>
              <p class="mb-0 mt-2" style="font-weight: 500; font-size: 18px; color: #999999;"> or drag a file here </p>
            </div>

            <input type="file" class="file-input-product" accept="image/*" name="product" hidden>

          </div>
        </div>

      </div>

      <div class="action-buttons d-none">
        <button class="btn clear-button">Clear</button>
        <button class="btn done-button text-primary back-to-previeus-modal">Done</button>
      </div>
    </div>

    <div class="tab-pane fade show active" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0"
      style="height: 480px;">

      <div class="row">

        <div class="col-4 col-sm-4">
          <div class="list-group ">
            <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5 getItem active"
            data-catalog="all">All</button>

            @forelse ($fileManagerCatalog as $item)

            <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5 getItem"
              data-catalog="{{ $item->catalog }}">{{ ucfirst($item->catalog) }}</button>

            @empty
            <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5">No Catalog
              Found</button>
            @endforelse
          </div>
        </div>

        <div class="col-8 col-sm-8">

          <div class="overflow-y-scroll pe-3 text-center theme mt-2" id="drop-area-banner" style="height: 470px;">

            <div class="row">

              @if(!empty($allFiles))
              @foreach($allFiles as $file)
              <div class="col-6 col-sm-4">
                <img class="thumbnail rounded-2 my-2" src="{{ Storage::url($file) }}" alt="Image"
                  style="max-width: 100%; height: auto;">
              </div>
              @endforeach
              @else
              <p>No images found in the directory.</p>
              @endif

            </div>

          </div>
        </div>

      </div>

      <div
        class="d-none alert alert-primary align-items-center border-0 d-flex justify-content-between position-absolute rounded-0 text-end w-100 shadow-sm"
        role="alert" style="bottom: -3%;">

        <p class="m-0"><i class="ri-close-line me-2 close-insert"></i> 1 Selected</p>
        <button class="btn btn-primary px-4 rounded-1 theme-insert back-to-previeus-modal">Insert</button>
      </div>

    </div>

  </div>

</div>

<script>
  $(".back-to-previeus-modal").click(() => {
    $("#dynamicmodal").modal("show");
    $("#fileManagerModal").modal("hide");
  });
</script>

<script>
  $(document).ready(function() {
    // Function to fetch items based on catalog
    $(document).on('click', '.getItem', function() {
      var catalog = $(this).data('catalog'); // Get the catalog value from data attribute
      $(".getItem").removeClass("active")
      $(this).addClass("active")
      var url = '{{ route("account.filemanager.getitem", ":catalog") }}';
      url = url.replace(':catalog', encodeURIComponent(catalog)); // Dynamically set the catalog in the URL
      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'html',
        beforeSend: function() {
          // Show a loading spinner before sending the request
          $(".theme").html(`<div class="spinner-border text-danger mt-4" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>`);
        },
        success: function(response) {
          $(".theme").html(response); // Update the theme container with the response
        },
        error: function(xhr, status, error) {
          console.error('Error occurred: ', error);
        }
      });
    });
    
  });
</script>

<script>
  $(document).ready(function() {
    // Handle thumbnail click
    $(document).on('click', '.thumbnail', function() {
      // Get the src attribute of the clicked thumbnail
      var imgSrc = $(this).attr('src');
      if (imgSrc) {
        // Construct the full theme URL using Laravel's URL helper
        var themeUrl = "{{ url('/') }}" + imgSrc;
        // Set the new data attribute on the theme-insert element
        $(".theme-insert").attr('data-theme-url', themeUrl);
        $(".theme-insert").parents(".alert").removeClass('d-none');
        $('.thumbnail').removeClass("selected-theme")
        $(this).addClass("selected-theme")
      } else {
        console.error('No "src" attribute found on the clicked thumbnail.');
      }
    });
    // Handle theme-insert click button and file set to file-input-product and product image preview
    $(".theme-insert").click(function() {
      var fileUrl = $(this).data('theme-url');
      $.ajax({
        url: fileUrl,
        method: 'GET',
        xhrFields: {
          responseType: 'blob'
        },
        success: function(blob) {
          if (blob.type.startsWith('image/')) {
            var fileName = Math.random().toString(36).substr(2, 9) + '.' + blob.type.split('/')[1];
            var fileObjectUrl = URL.createObjectURL(blob);
            var file = new File([blob], fileName, {
              type: blob.type
            });
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            $(".parent-of-input-and-preview-image-tag .file-input-product")[0].files = dataTransfer.files;
            $(".parent-of-input-and-preview-image-tag .preview-product").attr('src', fileObjectUrl)
              .show();
            $("#fileManagerModal").modal("hide");
          } else {
            $('#file-preview').html('<p>Unsupported file type.</p>');
          }
        },
        error: function() {
          alert('Failed to fetch file.');
        }
      });
    });
    // Function to generate a random file name
    function generateRandomFileName(extension) {
      var randomString = Math.random().toString(36).substr(2, 9); // Generate random string
      return randomString + '.' + extension; // Concatenate with the file extension
    }
    // close insert button
    $(".close-insert").click(function() {
      $('.thumbnail').removeClass("selected-theme")
      $(this).parents(".alert").addClass("d-none");
    });
    // Generate a random file name
    function generateRandomFileName(extension) {
      var timestamp = new Date().getTime();
      return 'file_' + timestamp + '.' + extension;
    }
  });
</script>

<script>
  $(document).ready(function() {

    // Handle file input change
    $(document).on('change', '.file-input-product', function() {
      handleFile(this.files[0]);
    });

    // Handle browse button click
    $(".browse-btn").click(function() {
      $(this).closest('.modal-preview-container').find('input[type="file"]').click();
    });

    // Handle drag and drop
    $(document).on('dragover', '.modal-drop-area', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).addClass('dragging');
    });

    $(document).on('dragleave', '.modal-drop-area', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).removeClass('dragging');
    });

    $(document).on('drop', '.modal-drop-area', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).removeClass('dragging');
      var file = e.originalEvent.dataTransfer.files[0];
      if (file) {
        handleFile(file);
      }
    });

    // Function to handle file selection and display preview
    function handleFile(file) {
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function(e) {
        // Update the modal preview
        $('.action-buttons').removeClass('d-none');
        $('.modal-preview-container').find('.browse-section').addClass('d-none');
        $('.modal-preview-container').find('.image-placeholder').attr('src', e.target.result).show().addClass(
          "active");
        // Handle done button click to update the file input and preview
        $(document).off('click', '.done-button').on('click', '.done-button', function() {
          $(".parent-of-input-and-preview-image-tag .preview-product").attr('src', e.target.result).show();
          // Create a new DataTransfer object
          var dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          // Update the file input
          $('.parent-of-input-and-preview-image-tag .file-input-product')[0].files = dataTransfer.files;
        });
      };
      reader.readAsDataURL(file);
    }
    // clear button action
    $(document).on('click', '.clear-button', function() {
      // Update the image placeholder to the default image
      $('.modal-preview-container').find('.image-placeholder').attr('src',
        "{{ \Storage::url('default/upload_background.png') }}").show().removeClass("active");
      // Show the browse section and hide the action buttons
      $('.modal-preview-container').find('.browse-section').removeClass('d-none');
      $('.action-buttons').addClass('d-none');
      // Clear the file input
      $('.modal-preview-container').find('.file-input-product').val('');
    });

  });
</script>

@endif