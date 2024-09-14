@extends('admin.layouts.app')

@section('content')

<div class="py-12 flex flex-wrap">

  <!-- Directories Section -->
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Directories</h2>

    <x-partials.card>
      <ul class="list-none">
        @forelse($directories as $dir)
        <li class="py-2 px-3 rounded {{ basename($dir) === $directory_type ? 'bg-gray-100 text-primary' : '' }}">
          <a href="{{ route('filemanager.index', str_replace('filemanager/', '', $dir)) }}">
            <i class="fa-sharp fa-solid {{ basename($dir) === $directory_type ? 'fa-folder-open' : 'fa-folder' }} text-warning text-xl mr-2"></i>
            <span class="text-primary">{{ ucfirst(basename($dir)) }}</span>
          </a>
        </li>
        @empty
        <li>No directories found.</li>
        @endforelse
      </ul>
    </x-partials.card>
  </div>

  <!-- Files Section -->
  <div class="w-full md:w-3/4 px-3">
    <div class="flex flex-wrap justify-between items-center mb-3">
      <div class="w-full md:w-1/2">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ ucfirst($directory_type) }}
        </h2>
      </div>
    
      <div class="w-full md:w-1/2 text-right">
        <button id="uploadButton" class="rounded bg-primary hover:bg-opacity-90 text-white px-6 py-2">
          <i class="mr-1 fa-duotone fa-circle-plus"></i> Upload
        </button>
        <input type="file" id="fileInput" class="hidden" />
       
      </div>
    </div>
    
    <x-partials.card>
      <div>
        <!-- Product Categories -->
        <div class="flex flex-wrap justify-start">
          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2 ">
            <div class="bg-gray-100 px-3 py-4 rounded  hover:bg-gray-200 transition">
              <a href="{{ route('filemanager.index','products/burger') }}" class="nav-link flex items-center text-gray-800">
                <i class=" fa-sharp fa-solid fa-folder text-warning text-xl mr-2"></i>
                <span class="text-primary">Burger</span>
              </a>
            </div>
          </div>

          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-gray-100 px-3 py-4 rounded  hover:bg-gray-200 transition">
              <a href="{{ route('filemanager.index','products/pizza') }}" class="nav-link flex items-center text-gray-800">
                <i class="fa-sharp fa-solid fa-folder text-warning text-xl mr-2"></i>
                <span class="text-primary">Pizza</span>
              </a>
            </div>
          </div>

          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-gray-100 px-3 py-4 rounded  hover:bg-gray-200 transition">
              <a href="{{ route('filemanager.index','products/sandwich') }}" class="nav-link flex items-center text-gray-800">
                <i class="fa-sharp fa-solid fa-folder text-warning text-xl mr-2"></i>
                <span class="text-primary">Sandwich</span>
              </a>
            </div>
          </div>

          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-gray-100 px-3 py-4 rounded  hover:bg-gray-200 transition">
              <a href="{{ route('filemanager.index','products/chicken') }}" class="nav-link flex items-center text-gray-800">
                <i class="fa-sharp fa-solid fa-folder text-warning text-xl mr-2"></i>
                <span class="text-primary">Chicken</span>
              </a>
            </div>
          </div>
          <!-- Repeat similar <li> elements for other categories -->
        </div>

        <!-- Product Images -->
        <div class="flex flex-wrap justify-start">
          @forelse($files as $file)
          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="relative bg-white rounded-lg shadow-md overflow-hidden hover:bg-gray-200 transition cursor-pointer group">
              <img src="{{ \Storage::url($file) }}" alt="" class="w-full h-32 object-contain">
              <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button data-delete-directory="{{ $file }}" class="delete_directory text-orange-600">
                    <i class="fa-solid fa-trash"></i>
                </button>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Show file input when the upload button is clicked
    $('#uploadButton').on('click', function() {
      $('#fileInput').click(); // Trigger file input click
    });

    // Handle file input change
    $('#fileInput').on('change', function() {
      let fileInput = $(this)[0];
      let file = fileInput.files[0];
      if (file) {
        let formData = new FormData();
        formData.append('file', file);
        formData.append('directory', '{{ $directory_type }}'); // Corrected to be inside quotes

        $.ajax({
          url: '{{ route('filemanager.upload') }}',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          success: function(response) {
            $('#responseMessage').html('<p>File uploaded successfully!</p>');
            window.location.reload(); // Reload the page to reflect new files
          },
          error: function(xhr, status, error) {
            $('#responseMessage').html('<p>An error occurred: ' + error + '</p>');
          }
        });
      }
    });
  });



  $(document).ready(function() {
    // Handle delete directory/file action
    $('.delete_directory').on('click', function(e) {
        e.preventDefault();
        
        // Get the file path from the button's data attribute
        let filePath = $(this).data('delete-directory');
        
        // Confirm deletion
        if (confirm('Are you sure you want to delete this file?')) {
            $.ajax({
                url: '{{ route("filemanager.delete") }}',  // Ensure the POST route is defined in your web.php
                type: 'POST',  // Use POST request
                data: {
                    _token: '{{ csrf_token() }}',
                    file: filePath
                },
                success: function(response) {
                    $('#responseMessage').html('<p class="text-green-500">File deleted successfully!</p>');
                    window.location.reload();  // Reload the page to refresh the file list
                },
                error: function(xhr, status, error) {
                    $('#responseMessage').html('<p class="text-red-500">An error occurred: ' + error + '</p>');
                }
            });
        }
    });
});


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