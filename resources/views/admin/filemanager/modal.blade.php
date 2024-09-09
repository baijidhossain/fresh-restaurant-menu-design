@if ($action == "files")

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


    /* #upload-tab-pane {
      height: 230px !important;
    } */
  }


  /*image drop  */
  .modal-drop-area {
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

  .upload-icon {
    bottom: 0;
  }

  .preview-image {
    width: 35%;
  }

  .image-preview {
    width: 35%;
  }

  .modal-image-preview-area {
    position: absolute;
    top: 43%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 96%;
  }

  .action-buttons {
    position: absolute;
    top: 90%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
  }

  .clear-button {
    font-weight: 600 !important;
    color: #6c757d !important;
  }

  .done-button {
    font-weight: 600 !important;
  }

  .modal-image-preview .image-pleaceholder {
    width: 35%;
  }

  .modal-image-preview .image-preview {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .thumbnail {
    cursor: pointer;
  }

  .close-insert{
    cursor: pointer;
  }

  .selected-theme{
    border: 3px solid #007bff !important;
    padding: 8px !important;
  }
  .theme > div:last-child {
  margin-bottom: 20px; /* Adjust the value to your needs */
}


</style>

@csrf

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

        <div class="modal-drop-area" style="height: 480px;">

          <div class="modal-image-preview-area">

            <div class="modal-image-preview">

              <img class="image-pleaceholder" src="{{ \Storage::url('default/upload_background.png')  }}"
                alt="Image Preview">
              {{-- <img class="image-preview" src="" alt="Image Preview" style="display: none"> --}}

            </div>

            <div class="browse-container">
              <button class="btn btn-primary upload-icon">Browse</button>
              <p class="mb-0 mt-2" style="font-weight: 500; font-size: 18px; color: #999999;"> or drag a file here </p>
            </div>

          </div>

          <div class="text-end action-buttons d-none">

            <button class="btn clear-button">Clear</button>
            <button class="btn done-button text-primary" data-bs-dismiss="modal" aria-label="Close">Done</button>

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

  
      <div class="d-none alert alert-primary align-items-center border-0 d-flex justify-content-between position-absolute rounded-0 text-end w-100 shadow-sm" role="alert" style="bottom: -3%;">

        <p class="m-0"><i class="ri-close-line me-2 close-insert" ></i> 1 Selected</p> 
         <button class="btn btn-primary px-4 rounded-1 theme-insert">Insert</button>
       </div>

    </div>

  </div>

</div>

@endif

<script>

$(document).ready(function() {

  // Add classes to the modal on load
  $(".modal-dialog").addClass("modal-dialog-centered modal-lg");

  $(".modal").addClass("overflow-hidden");

  $(".modal-content").addClass("rounded-0");

  // Function to handle file preview and setup
  function setupDropArea() {
    $('.modal-drop-area').each(function() {
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
      var $icon = $dropArea.find('.upload-icon');

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
          $(".browse-container").hide();
          $(".action-buttons").removeClass("d-none");

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
      $icon.on('click', function() {
        settings.$fileInput.click();
      });
    });
  }

  // Initialize drop area setup
  setupDropArea();
});

</script>


{{-- <script>
  $(document).ready(function() {
    function generateRandomFileName(extension) {
      return Math.random().toString(36).substring(2, 15) + '.' + extension;
    }

    $('.thumbnail').click(function() {
    // Make sure the thumbnail is an image or has an 'src' attribute
    var imgSrc = $(this).attr('src');

    if (imgSrc) {
    // Construct the full theme URL using Laravel's URL helper
    var themeUrl = "{{ url('/') }}/" + imgSrc;

    // Set the new data attribute on the theme-insert element
    $(".theme-insert").attr('data-theme-url', themeUrl); // OR
 
    console.log('Theme URL set: ', themeUrl);
    } else {
    console.error('No "src" attribute found on the clicked thumbnail.');
    }
    });



    $(".theme-insert").click(function() {
      var fileUrl = "{{ url('/') }}" + $(this).data('theme-url');
      var modalType = '{{ $modal_type }}';
      var inputSelector = modalType === "banner_modal" ? '.input_banner' : '.input_logo';
      var previewSelector = modalType === "banner_modal" ? '.preview_banner' : '.preview_logo';

      console.log(fileUrl)

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
            $("#dynamicmodal").modal("hide")
          } else {
            $('#file-preview').html('<p>File type is not supported for preview.</p>');
          }
        },
        error: function() {
          alert('Failed to fetch file.');
        }
      });
    })


    
    $(".action-buttons .clear-button").click(function() {
      $(".modal-image-preview-area").html(`
          <div class="modal-image-preview">
                    <img class="preview-image" src="https://menu.gocards.com.bd/storage/default/upload_background.png" alt="Image Preview">
                      <img class="image-preview" src="" alt="Image Preview" style="display: none">
                    </div>
                    <div class="browse-container">
                      <button class="btn btn-primary upload-icon">Browse</button>
                      <p class="mb-0 mt-2" style="font-weight: 500; font-size: 18px; color: #999999;"> or drag a file here </p>
                    </div>`)
      $(".browse-container").show()
      $(".action-buttons").addClass("d-none")
    })

  });
</script> --}}


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
    var fileUrl =  themeUrl;
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

          $(".header-container")[0].style.setProperty(
          "background",
          `linear-gradient(360deg, rgb(0, 0, 0), rgba(255, 255, 255, 0.6)), rgba(7, 7, 7, 0.6) url(${fileObjectUrl})`,
          "important"
          );
          $(".header-container")[0].style.setProperty("background-blend-mode", "overlay", "important");
          $(".header-container")[0].style.setProperty("background-position", "center", "important");
          $(".header-container")[0].style.setProperty("background-size", "cover", "important");

          $("#dynamicmodal").modal("hide");
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