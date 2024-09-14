<x-frontend-layout>

    @push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
      <style>
        body{
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        }

        input[type="search"]::-webkit-search-cancel-button {
          -webkit-appearance: none;
          appearance: none;
        }

        .modal-lg,
        .modal-xl {
          --bs-modal-width: 75%;
        }

        .item-description {
          max-width: 500px !important;
        }

        .line-clamp2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        }

        .offer-price {
        top: 80% !important;
        }

      </style>

<style>

  .slick-slide {
      transition: transform 0.1s ease;
  }
</style>
      
    @endpush
    @section('meta_title', $restaurant->name)


  <header>

    <div class="container-fluid" style="
          background: linear-gradient(360deg, rgb(0 0 0), rgb(255 255 255 / 60%)), rgb(7 7 7 / 60%) url('{{ $restaurant->banner ? \Storage::url("restaurant/banners/".$restaurant->banner) : \Storage::url('default/restaurant-bannr-pleaceholder.jpg') }}');
          background-blend-mode: overlay;
          background-position: center;
          background-size: cover;">

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12 col-xxl-10">
            <div class="banner-container">

              <div class="overlay">

                <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route("profile",$restaurant_user->slug) }}">
                          <div class="logo-container">
                            <img src="{{ $restaurant->logo ? \Storage::url("restaurant/logos/".$restaurant->logo) : \Storage::url('default/restaurant-logo-pleaceholder.png') }}" class="logo" alt="logo">
                          </div>
                        </a>
                 
                        @if(auth()->guard('frontend')->user())
                     
                        <div>
                          <button type="button" class="btn  dropdown-btn border-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-logout-box-r-line"></i>
                          </button>
      
                          <ul class="dropdown-menu dropdown-menu-end">
      
                            <li><a class="dropdown-item" href="{{ route("profile",$restaurant_user->slug) }}"> <i class="ri-home-5-line"></i> Home</a>
                            </li>
                         
                            <li>
                              <a class="dropdown-item" href="{{ route("account.update") }}">
                                <i class="ri-store-2-line"></i> Edit Restaurant
                              </a>
                            </li>
      
                            <li>
                             
                              <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">  <i class="ri-logout-box-r-line"></i> Logout</button>
                            </form>
                            
                            </li>
                         
                          </ul>
      
                        </div>

                        @else

                        <a href="{{ route("login") }}" class=" text-white text-decoration-none"> <i class="ri-login-box-line"></i> <span class="fw-bold"> Login </span> </a>

                        @endif

                </div>

                <div class="overlay-content">
                  <div class="d-flex gap-2">
                  <h4 class="mb-1 banner-title">{{ $restaurant->name ?? "" }} </h4>
                  @if (auth()->guard('frontend')->user())
                  <a class="text-white" href="{{ route("account.update") }}"> <i class="ri-edit-2-fill"></i> </a>
                  @endif
                </div>


                  <p class="banner-text mb-0">
                    <p class="banner-text mb-0 line-clamp-3">
                      {{ \Illuminate\Support\Str::limit($restaurant->address,150,".") }}
                    </p>

                  </p>
                </div>

                <ul class="d-flex gap-2 list-unstyled banner-container-contact px-0">

                  @if ($restaurant->start_time && $restaurant->end_time)
                  <li class="border-end list-group-item pe-2 opening-time">
                    <i class="ri-time-line"></i>
                    {{ \Carbon\Carbon::parse($restaurant->start_time)->format('h:i a') }} -
                    {{ \Carbon\Carbon::parse($restaurant->end_time)->format('h:i a') }}
                  </li>
                  @endif

                  @if ($restaurant->phone )
                  <li class="list-group-item border-end pe-2 "><i class="ri-phone-line"></i> <a href="tel:01775051601"
                      class="text-dark text-decoration-none text-white"> {{ $restaurant->phone ?? "" }}</a>
                  </li>

                  @endif

                  <li class="list-group-item"> <a href="{{ route('contact',$restaurant_user->slug) }}"
                      class="text-white text-decoration-none"><i class="ri-contacts-line"></i> Save Contact</a>
                  </li>

                </ul>

              </div>

            </div>
          </div>
        </div>
      </div>

    </div>

  </header>
 

  <div class="container mt-xl-2" style="flex-grow: 1;">

    <div class="row justify-content-center">

      <div class="col-lg-8 col-md-10 col-sm-12 col-xxl-10">

        <div class="card border-0 rounded-0 border-bottom-0">

          <div class="card-body p-0 _card-body">

            <div class="mt-1">

              <div class="sticky-search">
                <form action="" method="GET">
                  <div class="input-group rounded shadow-sm">
                    <!-- Search Button -->
                    <span class="input-group-append search-back">
                      <button class="border border-end-0 btn rounded-end-0 search_button pe-0 bg-light" type="submit">
                        <i class="ri-menu-search-line"></i>
                      </button>
                    </span>
                    <!-- Search Input -->
                    <input class="border border-start-0 form-control search-for-focus bg-light"  readonly type="search"
                      name="search" value="{{ request('search') }}" placeholder="Search">
                  </div>
                </form>


                <div class="nav mt-2  catalog-slider" id="nav-tab" role="tablist">

                  <button data-catalog="popular" style="width: auto;" class="btn  m-2  text-nowrap getitems menu_active menu_category_button active" >Popular</button>
                
                  <button data-catalog="offer" style="width: auto;" class="btn  m-2  text-nowrap getitems menu_active menu_category_button" >Offer</button>
              
                  @forelse ($catalogs as $catalog)
                  
                  <button data-catalog="{{ $catalog->id }}" style="width: auto;" class="btn  m-2  text-nowrap getitems menu_active menu_category_button"> {{ $catalog->name }} </button>
             
                  @empty

                  @endforelse

                </div>

              </div>

              <div class="catalog-wise-product ">

                <div class="menu_items">
                </div>

              </div>

              {{-- @endif --}}

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

<!-- Button trigger modal -->


<!-- Search Input -->


<!-- Modal -->
<div class="modal fade" id="searchmodal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content" style="background-color: rgba(240, 255, 255, 0)">
      <div class="bg-white border-0 justify-content-center modal-header">

        <div class="input-group rounded w-100">
          <span class="border-0 input-group-append me-3 search-back">
              <button data-bs-dismiss="modal" aria-label="Close"
                  class="bg-white border border-0 border-end-0 btn pe-0 py-2 rounded-end-0 search_button" type="submit">
                  <i class="ri-arrow-left-line"></i>
              </button>
          </span>
          <input class="bg-light border border-0 form-control py-2 rounded search-input " id="autoFocusInput" type="search" 
              name="search" value="" placeholder="Search" autofocus>
      
          <span class="border-0 input-group-append me-3 search-close">
              <!-- Loading spinner or close button will be dynamically inserted here -->
          </span>
      </div>
      
      </div>

      <div class="modal-body">
        <!-- Search results will be shown here -->
        <div class="search-product">
       
        </div>
      </div>

      <script>
         $('.search-input').trigger('focus');
      </script>

    </div>
  </div>
</div>


  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <!-- Slick Slider JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Initialize Slick Slider -->
<script>
  $(document).ready(function() {
    $('.catalog-slider').slick({
      infinite: true,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 3000,
      prevArrow: '<button type="button" class="slick-prev">‹</button>',
      nextArrow: '<button type="button" class="slick-next">›</button>',
      variableWidth: true,
      responsive: [{
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 3
          }
        },

        {
          breakpoint: 576,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        }
      ]
    });
  });
</script>

<script>
  $(document).ready(function() {

    // Event listener for clearing the search input
    $(document).on("click", ".search-input-empty", function() {
      $('.search-input').val(""); // Clear the input value
      $(this).remove(); // Remove the close button
      $('.modal-content').css('background-color', 'transparent'); // Set background color to transparent
      $(".search-product").html(''); // Clear the search results
    });


    $('.search-for-focus').on('focus', function() {
      // Scroll the page to 400px and then show the modal
      $('html, body').animate({
        scrollTop: 1000
      }, 'fast', function() {
        $("#searchmodal").modal("show"); // Show the modal after scrolling
        $('.search-input').trigger('focus');
        $("header").addClass("d-none")
      });
    })

    // Event listener for the search input
    $('.search-input').on('focus keyup', function() {
      let query = $(this).val(); // Get the value of the search input
      // If the query is empty, clear the close button, set background color, and clear results
      if (query == "") {
        $(".search-close").html(''); // Clear the close button and spinner when input is empty
        $('.modal-content').css('background-color', 'transparent'); // Set background to transparent
        $(".search-product").html(''); // Clear search results when query is empty
      }
      // Make the AJAX request if there's a query
      if (query !== "") {
        // Get the pathname from the current URL
        let pathname = window.location.pathname;
        // Remove the leading slash
        let pathnameWithoutSlash = pathname.startsWith('/') ? pathname.slice(1) : pathname;
        $.ajax({
          url: "{{ route('search') }}", // URL for the search request
          method: 'GET', // HTTP method
          data: {
            query: query, // Query parameter
            slug: pathnameWithoutSlash // Additional parameter
          },
          beforeSend: function() {
            // Show a loading spinner before sending the request
            $(".search-close").html(`
                        <button class="bg-light border border-0 btn py-2 rounded-end-0 search-input-empty" type="button">
                            <i class="ri-loader-4-line"></i> <!-- Loading icon -->
                        </button>
                    `);
            $(".search-product").html(`<ul class="menu-item-list list-unstyled">
              <li class="list-item list-group-item text-center px-0 my-3">   
                <div class="spinner-border text-danger text-center " role="status"><span class="visually-hidden">Loading...</span></div>
              </li>
           </ul>`);
          },
          success: function(data) {
            $(".search-product").html(data); // Populate search results with returned data
            // Set modal background color based on whether there is a query
            if (query !== "") {
              $('.modal-content').css('background-color', 'white');
            } else {
              $('.modal-content').css('background-color', 'transparent');
              $(".search-product").html(''); // Clear results if query is empty
            }
          },
          error: function() {
            $(".search-product").html('<div>An error occurred</div>'); // Show error message
          },
          complete: function() {
            // Show the close button after the request is complete
            $(".search-close").html(`
                        <button class="bg-light border border-0 btn py-2 rounded-end-0 search-input-empty" type="button">
                            <i class="ri-close-circle-line"></i> <!-- Close icon -->
                        </button>
                    `);
          }
        });
      }
    });

    // Handle scrolling when the modal is hidden
    $('#searchmodal').on('hidden.bs.modal', function() {
      $('html, body').scrollTop(0); // Scroll back to the top (0px) when the modal is hidden
      $("header").removeClass("d-none")
    });

    $('[data-fancybox="gallery"]').fancybox({
      loop: true, // Enables looping through images in the gallery
      buttons: [
        "zoom",
        "close"
      ],
      animationEffect: "zoom-in-out",
      transitionEffect: "slide",
    })

  });

  $(".getitems").click(function() {
    $(".getitems").removeClass("active");
    $(this).toggleClass("active");
    var catalog = $(this).data("catalog");
    getItems(catalog);
  });

  // Load popular items on page load
  getItems("popular");

  function getItems(catalog = "popular") {
    let pathname = window.location.pathname;
    let pathnameWithoutSlash = pathname.startsWith('/') ? pathname.slice(1) : pathname;
    $.ajax({
      url: "{{ route('items.get') }}",
      method: 'GET',
      data: {
        catalog: catalog,
        slug: pathnameWithoutSlash
      },
      beforeSend: function() {
        $(".menu_items").html(
          `<ul class="menu-item-list list-unstyled">
              <li class="list-item list-group-item text-center px-0 my-3">   
                <div class="spinner-border text-danger text-center " role="status"><span class="visually-hidden">Loading...</span></div>
              </li>
           </ul>`
        );
      },
      success: function(response) {
        // Assuming response is HTML
        $(".menu_items").html(response);
      },
      error: function(xhr) {
        const errorMessage = xhr.responseText || 'An error occurred. Please try again.';
        console.error(errorMessage);
        $(".menu_items").html(`<p class="text-center">${errorMessage}</p>`);
      },
      complete: function() {
        // Optionally hide a loading indicator if needed
      }
    });
  }

</script>

  @endpush
</x-frontend-layout>