
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>@yield('meta_title', config('app.name'))</title>
  
  <meta charset="utf-8">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/x-icon" href="{{ asset('storage/favicon.png') }}">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>


  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />


      <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link rel="stylesheet" href="{{ asset("public/assets/frontend/css/style.css") }}">


  @stack('css')

</head>

<body class="">

    {{ $slot }}

  @include('layouts.footer')

  {{-- Dynamic Modal --}}
  <div class="modal fade" id="dynamicmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="dynamicmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

      </div>
    </div>
  </div>


  {{-- File Manager Modal--}}
  <div class="modal fade" id="fileManagerModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-2"
    aria-labelledby="fileManagerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded-0">

      </div>
    </div>
  </div>


  <div class="modal fade" id="deletealert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletealertLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content text-center">
              <div class="modal-body">
                  <div class="text-center">
                      <div class="icon-container d-flex justify-content-center align-items-center">
                          <div class="icon-background">
                              <i class="ri-alert-fill text-danger"></i>
                          </div>
                      </div>
                  </div>
                  <h3 class="mt-2" style="font-size: 20px; font-weight: 700;">Are You Sure?</h3>
                  <p class="mb-0" style="font-size: 15px;">This action will delete your information.</p>
                  <p class="mb-0" style="font-size: 15px;">You won't be able to revert this!</p>
              </div>
              <div class="modal-footer border-0 justify-content-center delete-modal-footer" style="padding: 0px 0px 20px 0px;">
                  <!-- Dynamic content inserted here -->
              </div>
          </div>
      </div>
  </div>

  <!-- Dynamic Modal -->
  <div class="modal fade" id="dynamic-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center dynamic-modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon-container d-flex justify-content-center align-items-center">
              <div class="icon-background">
                <i id="dynamic-modal-icon"></i>
              </div>
            </div>
          </div>
          <h3 id="dynamic-modal-title" class="mt-2" style="font-size: 20px; font-weight: 700;">Title</h3>
          <p id="dynamic-modal-message" class="mb-0" style="font-size: 15px;">Message</p>
        </div>
        <div class="modal-footer border-0 justify-content-center" style="padding: 0px 0px 20px 0px;">
          <button type="button" class="bg-dark-subtle btn text-bg-info" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <!-- Include Notyf JavaScript from CDN -->
   <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

   {{-- <link rel="stylesheet" href="{{ asset("public/assets/frontend/js/script.js") }}">
   --}}
      <!-- Initialize Notyf and handle notifications -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var notyf = new Notyf({
          dismissible: true,
          duration: 4000,
          position: {
            x: 'right',
            y: 'top',
          },
        });

        // Show success notification if present
        @if(session()->has('success'))
        notyf.success(@json(session('success')));
        @endif

        // Show error notification if present
        @if(session()->has('error'))
        notyf.error(@json(session('error')));
        @endif

        // Show first error notification if there are validation errors
        @if($errors->any())
        notyf.error(@json($errors->first()));
        @endif
      });
    </script>

@stack('scripts')

@stack('modals')

</body>

</html>