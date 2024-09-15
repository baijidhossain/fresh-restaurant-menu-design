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

  .list-group-item{
    font-weight: 500;
    font-size: 15px;
  }

  .list-group-item.active {
    z-index: 2;
    color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.1) !important;
    border-color: #0d6efd !important;
}

  .list-group-item+.list-group-item.active {
    margin-top: 0;
    border-top-width: 0;
    color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.1) !important;
}

  @media only screen and (max-width: 400px) {
    .list-group-item {
      font-size: 11px !important;
      padding: 10px 5px 10px 14px !important;
    }

  }

  /*image drop  */

  .browse-btn {
    bottom: 0;
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
    object-fit: cover;
  }

  .modal-image-preview .image-preview {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  /* Container for the image */
  .thumbnail {
    position: relative;
    display: inline-block;
    /* Adjust as needed */
    cursor: pointer;
    margin-bottom: 16px;
  }

  /* Style the image */
  .thumbnail img {
    display: block;
    /* Remove any space below the image */
    width: 100%;
    /* Ensure the image covers the container */
    height: auto;
    /* Maintain aspect ratio */
  }

  /* Pseudo-element after */
  .thumbnail::after {
    content: '';
    /* Required for pseudo-element */
    position: absolute;
    top: 50%;
    /* Center vertically */
    left: 50%;
    /* Center horizontally */
    transform: translate(-50%, -50%);
    /* Center the pseudo-element */
    width: 100%;
    /* Cover the full width */
    height: 100%;
    /* Cover the full height */
    background-color: rgb(255 255 255 / 20%);
    /* Background color with transparency */
    opacity: 0;
    /* Start with invisible pseudo-element */
    z-index: 2;
    /* Ensure it is above the before pseudo-element */
  }

  .thumbnail:hover::after {
    opacity: 1;
    /* Make the after pseudo-element visible on hover */
  }

  .close-insert {
    cursor: pointer;
  }

  .selected-theme {
    border: 0.17rem solid #007bff !important;
    padding: {{  $action=='banner_modal'? '5px 15px': '2px' }};
  }

  .selected-alert {
    transition: 0.25s ease;
    z-index: 2;
    top: 100%;
  }

  .opacity-1 {
    top: 88%;
  }
</style>

@csrf

@if($action == "banner_modal")

  <div class="modal-header border-0">
    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>

  <div class="modal-body px-0 pb-0 overflow-hidden" style="height: 580px;">

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

    <div class="tab-content " id="myTabContent">

      <div class="tab-pane fade align-content-center text-center" id="upload-tab-pane" role="tabpanel"
        aria-labelledby="upload-tab" tabindex="0">

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
          <button class="btn done-button text-primary " data-bs-dismiss="modal">Done</button>
        </div>
      </div>

      <div class="tab-pane fade show active" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0">

        <div class="row">

          <div class="col-6 col-sm-4">
            <div class="list-group mt-3">
              <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5  active"
                data-catalog="all">Restaurant Background</button>
            </div>
          </div>

          <div class="col-6 col-sm-8">

            <div class="overflow-y-scroll pe-3 text-center theme mt-3" id="drop-area-banner" style="height: 500px;">

              <div class="row">

                @if(!empty($allFiles))
                @foreach($allFiles as $file)
                <div class="col-12">
                  <div class="thumbnail">
                    <img src="{{ Storage::url($file) }}" alt="Image">
                  </div>
                </div>
                @endforeach
                @else
                <p>No images found in the directory.</p>
                @endif

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

    <div
      class=" alert alert-primary selected-alert align-items-center border-0 d-flex justify-content-between position-absolute rounded-0 text-end w-100 shadow-sm"
      role="alert">
      <p class="m-0"><i class="ri-close-line me-2 close-insert"></i> 1 Selected</p>
      <button class="btn btn-primary px-4 rounded-1 theme-insert ">Insert</button>
    </div>
  </div>

@endif

@if($action == "logo_modal")

  <div class="modal-header border-0">
    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>

  <div class="modal-body px-0 pb-0 overflow-hidden" style="height: 580px;">

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

    <div class="tab-content " id="myTabContent">

      <div class="tab-pane fade align-content-center text-center" id="upload-tab-pane" role="tabpanel"
        aria-labelledby="upload-tab" tabindex="0">

        <div class="mb-3">

          <div class="modal-preview-container">
            <div class="modal-drop-area">
              <img class="image-placeholder" src="{{ \Storage::url('default/upload_background.png') }}"
                alt="Image Preview" style="object-fit: contain;">

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
          <button class="btn done-button text-primary " data-bs-dismiss="modal">Done</button>
        </div>
      </div>

      <div class="tab-pane fade show active" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0">

        <div class="row">

          <div class="col-5 col-sm-4">
            <div class="list-group mt-3">
              <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5  active"
                data-catalog="all">Restaurant Logo</button>
            </div>
          </div>

          <div class="col-7 col-sm-8">

            <div class="overflow-y-scroll pe-3 text-center theme mt-3" id="drop-area-banner" style="height: 500px;">

              <div class="row">

                @if(!empty($allFiles))
                @foreach($allFiles as $file)
                <div class="col-6 col-sm-4 col-lg-3">
                  <div class="thumbnail">
                    <img src="{{ Storage::url($file) }}" alt="Image">
                  </div>
                </div>
                @endforeach
                @else
                <p>No images found in the directory.</p>
                @endif

              </div>

            </div>
          </div>

        </div>

      </div>

    </div>

    <div
      class=" alert alert-primary selected-alert align-items-center border-0 d-flex justify-content-between position-absolute rounded-0 text-end w-100 shadow-sm"
      role="alert">
      <p class="m-0"><i class="ri-close-line me-2 close-insert"></i> 1 Selected</p>
      <button class="btn btn-primary px-4 rounded-1 theme-insert">Insert</button>
    </div>

  </div>

@endif

@if($action == "item_modal")

  <div class="modal-header border-0">
    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
    <button type="button" class="btn-close back-to-previeus-modal"></button>
  </div>

  <div class="modal-body px-0 pb-0 overflow-hidden" style="height: 580px;">

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

    <div class="tab-content " id="myTabContent">

      <div class="tab-pane fade align-content-center text-center" id="upload-tab-pane" role="tabpanel"
        aria-labelledby="upload-tab" tabindex="0">

        <div class="mb-3">

          <div class="modal-preview-container">
            <div class="modal-drop-area">

              <img class="image-placeholder" src="{{ \Storage::url('default/upload_background.png') }}"
                alt="Image Preview" style="object-fit: contain;">

              <div class="browse-section">
                <button class="btn btn-primary browse-btn">Browse</button>
                <p class="mb-0 mt-2" style="font-weight: 500; font-size: 18px; color: #999999;"> or drag a file here
                </p>
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

      <div class="tab-pane fade show active" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0">

        <div class="row">

          <div class="col-5 col-sm-4">
            <div class="list-group mt-3">
              <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5 getItem active"
                data-directory="filemanager/products">All</button>

              @forelse ($directories as $directory)

              <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5 getItem"
                data-catalog="{{ $directory }}">{{ ucfirst(basename($directory)) }}</button>

              @empty
              <button class="list-group-item list-group-item-action border-0 rounded-0 rounded-end-5">No Catalog
                Found</button>
              @endforelse

            </div>
          </div>

          <div class="col-7 col-sm-8">

            <div class="overflow-y-scroll pe-3 text-center theme mt-3" id="drop-area-banner" style="height: 500px;">

              <div class="row">

                @if(!empty($allFiles))
                @foreach($allFiles as $file)
                <div class="col-6 col-sm-4 col-lg-3">
                  <div class="thumbnail">
                    <img src="{{ Storage::url($file) }}" alt="Image">
                  </div>
                </div>
                @endforeach
                @else
                <p>No images found in the directory.</p>
                @endif

              </div>

            </div>
          </div>

        </div>

      </div>

    </div>

    <div
      class=" alert alert-primary selected-alert align-items-center border-0 d-flex justify-content-between position-absolute rounded-0 text-end w-100 shadow-sm"
      role="alert">
      <p class="m-0"><i class="ri-close-line me-2 close-insert"></i> 1 Selected</p>
      <button class="btn btn-primary px-4 rounded-1 theme-insert back-to-previeus-modal">Insert</button>
    </div>

  </div>

@endif

<script>
  $(document).ready(function() {
    // Default values
    var updateImagePreview = "";
    var updateImageInput = "";
    // Set image preview and input based on action
    @if($action == "item_modal")
    updateImagePreview = $(".parent-of-input-and-preview-image-tag .item-image-preview");
    updateImageInput = $('.parent-of-input-and-preview-image-tag .item-image-input');
    @elseif($action == "logo_modal")
    updateImagePreview = $(".parent-of-input-and-preview-image-tag .logo-image-preview");
    updateImageInput = $('.parent-of-input-and-preview-image-tag .logo-image-input');
    @else
    updateImagePreview = $(".parent-of-input-and-preview-image-tag .banner-image-preview");
    updateImageInput = $('.parent-of-input-and-preview-image-tag .banner-image-input');
    @endif

    // Handle back button to show previous modal
    $(".back-to-previeus-modal").click(function() {
      $("#dynamicmodal").modal("show");
      $("#dynamicmodal .modal-dialog").addClass("modal-lg");
      $("#fileManagerModal").modal("hide");
    });

    // Fetch items based on catalog
    $(document).on('click', '.getItem', async function() {
      var directory = $(this).data('directory');

      $(document).on('click', '.getItem', async function() {
    // Get the directory value from the data attribute
    var directory = $(this).data('directory');
    
    try {
        // Make an AJAX GET request to fetch data based on the directory
        let response = await $.ajax({
            url: '{{ route('your.route.name') }}', // Replace with your route URL
            type: 'GET',
            data: {
                directory: directory
            },
            success: function(response) {
                // Handle the successful response here
                $(".theme").html(response);
                // You can update the DOM or show a message based on the response
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error('An error occurred:', error);
            }
        });
    } catch (error) {
        console.error('An error occurred:', error);
    }
});


      $(".getItem").removeClass("active");
      $(this).addClass("active");
      var url = '{{ route("account.filemanager.getitem", ":catalog") }}'.replace(':catalog',encodeURIComponent(catalog));
      try {
        $(".theme").html(
          `<div class="spinner-border text-danger mt-4" role="status"><span class="visually-hidden">Loading...</span></div>`
        );
        const response = await $.ajax({
          url: url,
          method: 'GET',
          dataType: 'html'
        });
        $(".theme").html(response);
      } catch (error) {
        console.error('Error occurred: ', error);
        $(".theme").html('<p>An error occurred while fetching the data. Please try again.</p>');
      }
    });

    // Handle thumbnail click
    $(document).on('click', '.thumbnail', function() {
      // Get the src attribute from the img inside the clicked .thumbnail
      var imgSrc = $(this).find('img').attr('src');
      if (imgSrc) {
        // Construct the theme URL
        var themeUrl = "{{ url('/') }}/" + imgSrc;
        // Update the data-theme-url attribute and show the alert
        $(".theme-insert").attr('data-theme-url', themeUrl).parents(".alert").removeClass('d-none');
        // Remove the selected-theme class from all thumbnails
        $('.thumbnail').removeClass("selected-theme");
        $('.selected-alert').addClass("opacity-1");
        // Add the selected-theme class to the clicked thumbnail
        $(this).addClass("selected-theme");
      } else {
        console.error('No "src" attribute found on the clicked thumbnail.');
      }
    });

    // Handle theme-insert click
    $(".theme-insert").click(async function() {
      var fileUrl = $(this).data('theme-url');
      try {
        const blob = await $.ajax({
          url: fileUrl,
          method: 'GET',
          xhrFields: {
            responseType: 'blob'
          }
        });
        if (blob.type.startsWith('image/')) {
          var fileName = generateRandomFileName(blob.type.split('/')[1]);
          var fileObjectUrl = URL.createObjectURL(blob);
          var file = new File([blob], fileName, {
            type: blob.type
          });
          var dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          updateImageInput[0].files = dataTransfer.files;
          updateImagePreview.attr('src', fileObjectUrl).show();
          $("#fileManagerModal").modal("hide");
        } else {
          $('#file-preview').html('<p>Unsupported file type.</p>');
        }
      } catch (error) {
        alert('Failed to fetch file.');
        console.error('Error occurred: ', error);
      }
    });

    // Handle close insert
    $(document).on('click', '.close-insert', function() {
      // Reset the 'theme-url' data attribute on '.theme-insert' within the closest '.alert'
      $(this).closest('.alert').find(".theme-insert").data('theme-url', "");
      // Remove the 'selected-theme' class from all '.thumbnail' elements
      $('.selected-alert').removeClass("opacity-1");
      $('.thumbnail').removeClass('selected-theme')
    });

    // Generate a random file name
    function generateRandomFileName(extension) {
      var timestamp = new Date().getTime();
      return 'file_' + timestamp + '.' + extension;
    }

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
    }).on('dragleave drop', '.modal-drop-area', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).removeClass('dragging');
      if (e.type === 'drop') {
        handleFile(e.originalEvent.dataTransfer.files[0]);
      }
    });

    // Handle file selection and preview
    function handleFile(file) {
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.action-buttons').removeClass('d-none');
        $('.modal-preview-container').find('.browse-section').addClass('d-none');
        $('.modal-preview-container').find('.image-placeholder').attr('src', e.target.result).show().addClass(
          "active");
        $(document).off('click', '.done-button').on('click', '.done-button', function() {
          updateImagePreview.attr('src', e.target.result).show();
          var dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          updateImageInput[0].files = dataTransfer.files;
          console.log(updateImageInput[0].files);
        });
      };
      reader.readAsDataURL(file);
    }
    // Clear button action
    $(document).on('click', '.clear-button', function() {
      $('.modal-preview-container').find('.image-placeholder')
        .attr('src', "{{ \Storage::url('default/upload_background.png') }}")
        .show().removeClass("active");
      $('.modal-preview-container').find('.browse-section').removeClass('d-none');
      $('.modal-preview-container').find('.file-input-product').val('');
      $('.action-buttons').addClass('d-none');
    });


    $(document).on('click','#upload-tab',function(){
      $('.close-insert').click()
    })

  });
</script>