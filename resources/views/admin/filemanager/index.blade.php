@extends('admin.layouts.app')

@section('content')

<div class="py-12 px-12 flex flex-wrap">

  <!-- Directories Section -->
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Directories</h2>

    <x-partials.card>
      <ul class="list-none">
        {{-- {{ basename($dir) === $directory_type ? 'bg-gray-100 text-primary' : '' }} --}}
        <li class="py-2 px-3 rounded ">
          <a href="{{ route('filemanager.index','logos') }}">
            <i
              class="fa-sharp fa-solid    {{request()->is('admin/filemanager/logos*') ? 'fa-folder-open' : 'fa-folder'}}  text-warning text-xl mr-2"></i>
            <span class="text-primary">Logos</span>
          </a>
        </li>

        <li class="py-2 px-3 rounded ">
          <a href="{{ route('filemanager.index','banners') }}">
            <i
              class="fa-sharp fa-solid  {{request()->is('admin/filemanager/banners*') ? 'fa-folder-open' : 'fa-folder'}}  text-warning text-xl mr-2"></i>
            <span class="text-primary">Banners</span>
          </a>
        </li>

        <li class="py-2 px-3 rounded ">
          <a href="{{ route('filemanager.index','products') }}">
            <i
              class="fa-sharp fa-solid  {{request()->is('admin/filemanager/products*') ? 'fa-folder-open' : 'fa-folder'}}  text-warning text-xl mr-2"></i>
            <span class="text-primary">Products</span>
          </a>
        </li>

      </ul>
    </x-partials.card>
  </div>

  <!-- Files Section -->
  <div class="w-full md:w-3/4 px-3">
    <div class="flex flex-wrap items-center mb-3">

      @php
      // Input string, e.g., 'Products/burger'
      $string = $directory_type ?? "";

      // Convert the string into an array using '/' as the delimiter
      $breadcrumbs = explode('/', $string);
      @endphp

      <!-- Display Breadcrumbs -->
      <nav aria-label="Breadcrumb" class="flex-1">
        <ol class="list-reset flex text-gray-700">
          @foreach ($breadcrumbs as $index => $breadcrumb)
          @if ($index < count($breadcrumbs) - 1) <!-- Breadcrumb link for all but the last item -->
            <li>
              <a href="{{ route('filemanager.index', ['directory' => implode('/', array_slice($breadcrumbs, 0, $index + 1))]) }}"
                class="text-blue-600 hover:text-blue-700">
                {{ ucfirst($breadcrumb) }}
              </a>
              <span class="mx-1">/</span>
            </li>
            @else
            <!-- Last breadcrumb item, no link -->
            <li class="text-gray-500">{{ ucfirst($breadcrumb) }}</li>
            @endif
            @endforeach
        </ol>
      </nav>

      <!-- Upload Button and File Input -->
      <div class="flex-shrink-0">
        {{-- <button id="uploadButton" class="rounded bg-primary hover:bg-opacity-90 text-white px-6 py-2 flex items-center">
          <i class="mr-1 fa-duotone fa-circle-plus"></i> Upload
        </button>
        <input type="file" id="fileInput" multiple name="files[]" class="hidden" /> --}}

        <button id="showModalButton"
          class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Upload
        </button>
      </div>

    </div>

    <x-partials.card>
      <div>
        @if ($directory_type == "products")
        <div class="flex flex-end justify-end">
          <button
            data-modal-url="{{ route('filemanager.modal.content', ['action' => 'new-folder', 'oldFolderName' => '']) }}"
            class="rounded  hover:bg-opacity-90 text-blue-600  py-2 mx-2">
            <i class="mr-1 fa-duotone fa-circle-plus text-warning"></i> New Folder
          </button>
        </div>

        @endif

        <!-- Product Categories -->

        @if ($directories)
        <div class="flex flex-wrap justify-start mb-5">
          @forelse ($directories as $dir)
          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-gray-100 px-3 py-4 rounded hover:bg-gray-200 transition relative group overflow-hidden">
              <!-- Added 'group' and 'overflow-hidden' classes -->
              <a href="{{ route('filemanager.index', $dir) }}" class="nav-link flex items-center text-gray-800">
                <i class="fa-sharp fa-solid fa-folder text-warning text-xl mr-2"></i>
                <span class="text-primary">{{ ucfirst(basename($dir))  }}</span>
              </a>

              <div
                class="absolute top-2 right-1 transform translate-x-full opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-transform transition-opacity duration-300">
                <div class="flex flex-wrap justify-start gap-3">

                  <button
                    data-modal-url="{{ route('filemanager.modal.content', ['action' => 'rename-folder', 'oldFolderName' => basename($dir)]) }}"
                    class="text-blue-600">
                    <i class="fa-duotone fa-pen-to-square"></i>
                  </button>

                  <!-- Example button to delete a folder -->
                  <form class="mb-0" action="{{ route('filemanager.delete-folder', ['folder' => basename($dir) ]) }}"
                    method="POST" onsubmit="return confirm('Are you sure you want to delete this folder?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class=" text-red-600">
                      <i class="fa-duotone  fa-trash-can "></i>
                    </button>
                  </form>

                </div>

              </div>
            </div>
          </div>
          @empty
          <!-- Handle empty state if needed -->
          @endforelse
        </div>
        @endif

        <!-- Product Images -->
        <div class="flex flex-wrap justify-start">
          @forelse($files as $file)
          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div
              class="relative bg-white rounded-lg shadow-md overflow-hidden hover:bg-gray-200 transition cursor-pointer group">
              <img src="{{ \Storage::url($file) }}" alt="" class="w-full h-32 object-contain">
              <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                {{-- <button data-delete-file="{{ $file }}" class="delete_file text-orange-600">
                <i class="fa-solid fa-trash"></i>
                </button> --}}

                <!-- Example button to delete a folder -->
                <form class="mb-0" action="{{ route('filemanager.delete-file') }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this file?');">
                  @csrf
                  <input type="text" hidden name="filepath" value="{{ $file }}">
                  @method('DELETE')
                  <button type="submit" class=" text-red-600">
                    <i class="fa-duotone  fa-trash-can "></i>
                  </button>
                </form>

              </div>
            </div>
          </div>
          @empty
          <p class="text-center w-full">No files found.</p>
          @endforelse
        </div>

      </div>
    </x-partials.card>
  </div>

</div>

<!-- Modal Structure -->
<div id="dynamicmodal"
  class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center transition-opacity duration-300 opacity-0">
  <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
    <!-- Close Button -->
    <button onclick="toggleModal(false)" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
    <!-- Modal Content -->
    <div id="modal-content">
      <!-- Dynamic content will be loaded here -->
    </div>
  </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
  .img_list {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    padding: 5px;
    border: 2px dashed gainsboro;
  }

  .img_list.dragover {
    background: #f0f0f0;
    cursor: move;
  }

  .img_label {
    height: 100px;
    width: 60px;
    background: #8a8d91;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin: 0;
    border-radius: 5px;
  }

  span.delete-image {
    width: 20px;
    height: 20px;
    line-height: 17px;
    text-align: center;
    border-radius: 50%;
    color: #ff3838;
    font-size: 2rem;
    position: absolute;
    top: 0px;
    right: 0px;
    cursor: pointer;
    font-size: 18px;

  }

  .img_holder {
    position: relative;
  }
</style>

<!-- Button to trigger the modal -->
{{-- <button id="showModalButton" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
  Show File Upload Modal
</button> --}}

<!-- Modal HTML -->
<div id="fileUploadModal"
  class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex  items-center justify-center transition-opacity duration-300 opacity-0"
  style="z-index: 10000;">
  <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full relative">
    <!-- Close Button -->

    <div class="flex p-5">

      <button id="close-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>

      <!-- Modal Header -->
      <div class="">
        <h3 class="text-xl font-semibold text-gray-900">Upload Your File</h3>
      </div>

    </div>

    <!-- Modal Content -->
    <form method="POST" action="{{ route('filemanager.upload') }}" enctype="multipart/form-data" id="add_item_form"
      class="w-full mb-0">
      <input type="text" name="directory" hidden value="{{ $directory_type ?? "" }}">
      @csrf
      <div id="modal-content" class="flex flex-col items-center justify-center space-y-6">

        <div class="img_list px-5 mx-4">
          <label class="img_label" for="Image">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <input name="images[]" type="file" multiple accept="image/*" class="hidden" id="Image">
          </label>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="flex gap-4 justify-end p-5">
        <button id="closeModalButton"
          class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
          Cancel
        </button>

        <button type="submit"
          class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <i class="fa fa-check-square-o"></i> Upload
        </button>
      </div>
    </form>

  </div>
</div>

<script>
  const inputHolders = {};
  $.each($('#add_item_form input[type=file]'), function(key, input) {
    let thisID = $(input).attr('id');
    inputHolders[thisID] = new DataTransfer();
    let img_holder = $(input).parents('.img_list');
    // Drag and Drop events
    img_holder.bind('dragleave dragover drop', function(event) {
      event.stopPropagation();
      event.preventDefault();
      if (event.type === 'drop') {
        $(input).prop('files', event.originalEvent.dataTransfer.files);
        $(input).trigger('change');
        $(this).removeClass('dragover');
      } else if (event.type === 'dragleave') {
        $(this).removeClass('dragover');
      } else {
        $(this).addClass('dragover');
      }
    });
    $(input).on('change', function(e) {
      $.each($(this).prop('files'), function(i, file) {
        let reader = new FileReader();
        reader.onload = function() {
          let img = `<div data-index="${img_holder.children('[data-index]').length}" class="img_holder border">
                      <img class="mb-0" style="width: 100px;height: 100px;object-fit: cover;" src="${URL.createObjectURL(new Blob([new Uint8Array(reader.result)], {type: file.type}))}" alt="">
                      <span class="delete-image"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                  </div>`;
          $(img).insertBefore(img_holder.find('.img_label'));
        };
        reader.readAsArrayBuffer(file);
        inputHolders[thisID].items.add(file);
      });
      if ($(this).prop('files').length) {
        $(this).prop('files', null);
      }
      $('.img_list').removeClass('add_style');
    });
    img_holder.on('click', '.delete-image', function(e) {
      let el = $(this);
      let remove_item = el.parents('.img_holder');
      let index = remove_item.data('index');
      let fileName = remove_item.data('file');
      if (index) {
        inputHolders[thisID].items.remove(index);
      } else if (img_holder.find(`#${thisID}_prev`).length) {
        let prev_items = img_holder.find(`#${thisID}_prev`);
        let fileNames = prev_items.val() ? prev_items.val().split(',') : [];
        fileNames.splice(fileNames.indexOf(fileName), 1);
        prev_items.val(fileNames);
      }
      remove_item.remove();
    });
  });

</script>

<script>
  $(document).ready(function() {
    $('#showModalButton').click(function() {
      $('#fileUploadModal').removeClass('hidden');
      setTimeout(function() {
        $('#fileUploadModal').removeClass('opacity-0').addClass('opacity-100');
      }, 1);
    });

    function closeModal() {
      $('#fileUploadModal').removeClass('opacity-100').addClass('opacity-0');
      setTimeout(function() {
        $('#fileUploadModal').addClass('hidden');
      }, 300);
    }
    $('#close-modal, #closeModalButton').click(closeModal);
  });
</script>

<script>
  $(document).ready(function() {
    $('#showModalButton').click(function() {
      $('#fileUploadModal').removeClass('hidden');
      setTimeout(function() {
        $('#fileUploadModal').removeClass('opacity-0').addClass('opacity-100');
      }, 1);
    });

    function closeModal() {
      $('#fileUploadModal').removeClass('opacity-100').addClass('opacity-0');
      setTimeout(function() {
        $('#fileUploadModal').addClass('hidden');
      }, 300);
    }
    $('#close-modal, #closeModalButton').click(closeModal);
  });
</script>

<!-- jQuery Script -->
<script>
  $(document).ready(function() {
    const $fileUploadModal = $('#fileUploadModal');
    const $showModalButton = $('#show-modal');
    const $closeModalButton = $('#close-modal');
    // Function to open the modal
    const openModal = () => {
      $fileUploadModal.removeClass('hidden').addClass('opacity-100');
    };
    // Function to close the modal
    const closeModal = () => {
      $fileUploadModal.removeClass('opacity-100').addClass('hidden');
    };
    // Event listener for the show modal button
    $showModalButton.on('click', openModal);
    // Event listener for the close button
    $closeModalButton.on('click', closeModal);
    // Optional: Close the modal when clicking outside of the content area
    $(window).on('click', function(event) {
      if ($(event.target).is($fileUploadModal)) {
        closeModal();
      }
    });
  });
</script>

<!-- jQuery Script -->

<script>
  // Function to toggle modal visibility
  function toggleModal(show) {
    const modal = $('#dynamicmodal');
    const content = $('#modal-content');
    if (show) {
      modal.removeClass('hidden opacity-0').addClass('opacity-100');
    } else {
      modal.removeClass('opacity-100').addClass('opacity-0');
      setTimeout(() => {
        modal.addClass('hidden');
        content.empty(); // Clear the content when hiding
      }, 300); // Matches the transition duration
    }
  }
  // Handle clicking on elements with data-modal-url attribute
  $(document).on('click', '[data-modal-url]', function(e) {
    e.preventDefault();
    // Get the URL from the data attribute
    var url = $(this).data('modal-url');
    // Perform the AJAX request
    $.ajax({
      url: url,
      type: 'GET',
      success: function(response) {
        // Populate the modal content
        $('#modal-content').html(response);
        // Show the modal
        toggleModal(true);
      },
      error: function() {
        // Handle errors (optional)
        alert('Failed to load content.');
      }
    });
  });
</script>

@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  // $(document).ready(function() {
  //   // Show file input when the upload button is clicked
  //   $('#uploadButton').on('click', function() {
  //     $('#fileInput').click(); // Trigger file input click
  //   });
  //   // Handle file input change
  //   $('#fileInput').on('change', function() {
  //     let fileInput = $(this)[0];
  //     let files = fileInput.files; // Get all selected files
  //     if (files.length > 0) {
  //       let formData = new FormData();
  //       // Append each file to the FormData object
  //       $.each(files, function(index, file) {
  //         formData.append('files[]', file); // Use 'files[]' to append multiple files
  //       });
  //       // Log FormData contents
  //       for (let pair of formData.entries()) {
  //         console.log(pair[0] + ', ' + pair[1].name); // Log key and file name
  //       }
  //       formData.append('directory', '{{ $directory_type }}'); // Append the directory
  //       $.ajax({
  //         url: '{{ route('filemanager.upload') }}',
  //         type: 'POST',
  //         data: formData,
  //         contentType: false,
  //         processData: false,
  //         headers: {
  //           'X-CSRF-TOKEN': '{{ csrf_token() }}'
  //         },
  //         success: function(response) {
  //           $('#responseMessage').html('<p>Files uploaded successfully!</p>');
  //           // Optionally reload the page or update the UI
  //           window.location.reload();
  //         },
  //         error: function(xhr, status, error) {
  //           $('#responseMessage').html('<p>An error occurred: ' + error + '</p>');
  //         }
  //       });
  //     } else {
  //       $('#responseMessage').html('<p>No files selected.</p>');
  //     }
  //   });
  // });
  $(document).ready(function() {
    // Get the current full URL
    var currentUrl = window.location.href;
    // Loop through each link with the class 'nav-link'
    $('.nav-link').each(function() {
      // Get the href attribute of the link
      var linkUrl = $(this).attr('href');
      // Check if the current full URL matches the link URL
      if (currentUrl === linkUrl) {
        // Change the icon class if the link is active
        $(this).find("i").addClass("fa-folder-open").removeClass("fa-folder");
        $(this).addClass('active'); // Optionally add an 'active' class to the link
      } else {
        // Optionally revert the icon class for non-active links
        $(this).find("i").addClass("fa-folder").removeClass("fa-folder-open");
        $(this).removeClass('active'); // Optionally remove the 'active' class from non-active links
      }
    });
  });
</script>

@endpush

@endsection