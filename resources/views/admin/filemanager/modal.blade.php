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
    .theme{
      height: 320px !important;
    }
    .tab-content{
      height: 320px !important;
    }
    #theme-tab-pane{
      height: 320px !important;
    }
    #upload-tab-pane{
      height: 230px !important;
    }
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
      <button class="btn btn-primary icon-banner">Browse</button>
      <p class="mt-2 m-0">or drag a file here </p>
    </div>

    <div class="tab-pane fade show active" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0"
      style="height: 480px;">

      <div class="row">
        <div class="col-6 col-sm-4">
          <div class="list-group mt-3">
            <a href="#"
              class="list-group-item list-group-item-action active border-0 rounded-0 rounded-end-5">Restaurant
              Banner</a>
          </div>
        </div>

        <div class="col-6 col-sm-8">

          <div class="theme  overflow-y-scroll pe-3" id="drop-area-banner" style="height: 480px;">
            @if(!empty($allFiles))
            @foreach($allFiles as $file)
            <div class="mt-3">
              <img class="thumbnail-banner" src="{{ Storage::url($file) }}" alt="Image"
                style="max-width: 100%; height: auto;" data-bs-dismiss="modal" aria-label="Close">
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

@endif

<script>
  // Image preview and drag & drop handling
  function setupDropArea(dropAreaId, fileInputId, previewId, iconId, maxSize) {
    var $dropArea = $('#' + dropAreaId);
    var $fileInput = $('#' + fileInputId);
    var $preview = $('#' + previewId);
    var $icon = $('.' + iconId);

    function handleFile(files) {
      if (files.length > 0) {
        var file = files[0];
        // Calculate file size in MB
        var fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
        var maxSizeMB = (maxSize / 1024 / 1024).toFixed(2);
        if (file.size > maxSize) {
          AlertModal('warning', 'Warning', "File size exceeds the maximum limit of " + maxSizeMB +
            " MB. Your file size is " + fileSizeMB + " MB.");
          $fileInput.val('');
          $preview.hide();
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
      $fileInput[0].files = files;
    });
    $fileInput.on('change', function() {
      var files = $(this)[0].files;
      handleFile(files);
      $("#dynamicmodal").modal('hide');
      $(".modal-dialog").removeClass("modal-dialog-centered  modal-lg")
      $(".modal").removeClass("overflow-hidden");
    });
    $icon.on('click', function() {
      $fileInput.click();
    });
  }
  $(document).ready(function() {
    setupDropArea('drop-area-banner', 'file-input-banner', 'preview-banner', 'icon-banner', 1 * 1024 *
      1024); // 1 MB
    $(".modal-dialog").addClass("modal-dialog-centered  modal-lg")
    $(".modal").addClass("overflow-hidden");
    $('.thumbnail-banner').on('click', function() {
      var imageUrl = $(this).attr('src');
      $('.preview_banner').attr('src', imageUrl);
      $('.existBannerPath').val(imageUrl);
    });
  });
</script>