<x-frontend-layout>

  @push('css')

  @endpush



  @section('meta_title', $restaurant->name)

  <header>

    <div class="container-fluid header-container" style="
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

                  <a href="{{ route("profile",auth()->guard('frontend')->user()->slug) }}">
                    <img
                      src="{{ $restaurant->logo ? \Storage::url("restaurant/logos/".$restaurant->logo ?? "") : \Storage::url('default/restaurant-logo-pleaceholder.png') }}"
                      class="logo" alt="logo">
                  </a>

                  <div>
                    <button type="button" class="btn  dropdown-btn border-0" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ri-logout-box-r-line"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                      <li>
                        <a class="dropdown-item" href="{{ route("profile",$restaurant_user->slug) }}"> <i
                            class="ri-home-5-line"></i> Home</a>
                      </li>

                      <li>
                        <a class="dropdown-item" href="{{ route("account.update") }}">
                          <i class="ri-store-2-line"></i> Edit Restaurant
                        </a>
                      </li>

                      <li>

                        <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit" class="dropdown-item"><i class="ri-logout-box-r-line"></i>
                            Logout</button>
                        </form>

                      </li>

                    </ul>

                  </div>

                </div>

                <div class="overlay-content">
                  <h4 class="mb-1 banner-title">{{ $restaurant->name ?? "" }}</h4>

                  <p class="banner-text mb-0">
                    <p class="banner-text mb-0 line-clamp-3">
                      {{ \Illuminate\Support\Str::limit($restaurant->address, 150,".") }}
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

                  @if ($restaurant->phone)
                  <li class="list-group-item border-end pe-2 "><i class="ri-phone-line"></i> <a href="tel:01775051601"
                      class="text-dark text-decoration-none text-white"> {{ $restaurant->phone }}</a>
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

  <section>

    <div class="container edit-page">

      <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-sm-12 col-xxl-10">

          <div class="card border-0 rounded-0">

            <div class="card-body p-0">

              <div class="mt-4">

                <div class="accordion border-0" id="accordionExample">

                  <div class="accordion-item custom-accordion-item border-0">

                    <h2 class="accordion-header" id="general-info">
                      <button class="accordion-button custom-accordion-button rounded-0 "
                        data-accordion-name="general-information" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="ri-store-line me-2"></i> General Information
                        <i class="ri-arrow-down-s-line ms-auto"></i>
                      </button>
                    </h2>

                    <div id="collapseOne" class="accordion-collapse border-0 collapse " aria-labelledby="general-info"
                      data-bs-parent="#accordionExample">
                      <div class="accordion-body p-0 border-0 ">
                        <div class="_card border-0">
                          <div class="card-body p-2">

                            <form class="general_information_form"
                              action="{{ route('account.restaurant.update',$restaurant->id) }}" method="post"
                              enctype="multipart/form-data">

                              @csrf

                              <div class="row justify-content-center">

                                <div class="col-6 col-md-4">

                                  <div class="mb-3 logo_section">

                                    <label for="banner" class="custom-form-label form-label text-nowrap"> Logo  </label>

                                    <div class="drop-area" id="drop-area-logo" style="width: 70px !important;">
                                      <a href="{{ route("account.filemanager.files",'logo_modal') }}"
                                        data-bs-toggle="modal" class="parent-of-input-and-preview-image-tag"
                                        data-bs-target="#fileManagerModal">
                                        <input type="file" class="logo-image-input" name="logo" accept="image/*" hidden>

                                        <img class="logo-image-preview"
                                          src="{{ $restaurant->logo ? \Storage::url("restaurant/logos/".$restaurant->logo) : \Storage::url('default/restaurant-logo-pleaceholder.png') }}"
                                          alt="Logo Preview" style=" max-width: 100%;">

                                        <i class="ri-upload-2-line upload_icon"></i>

                                      </a>
                                    </div>
                                    <small class="font-size-10 fw-medium"> (Size 150px x 150px || Max: 500kb) </small>
                                    @error('logo')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror

                                  </div>

                                </div>

                                <div class="col-6 col-md-4">

                                  <div class="mb-3 banner_section">
                                    <label for="banner" class="custom-form-label form-label text-nowrap">
                                      Banner 
                                    </label>

                                    <div class="drop-area" id="drop-area-banner">

                                      <a href="{{ route("account.filemanager.files",'banner_modal') }}"
                                        data-bs-toggle="modal" class="parent-of-input-and-preview-image-tag"
                                        data-bs-target="#fileManagerModal">
                                        <input type="file" class="banner-image-input" name="banner" accept="image/*"
                                          hidden>
                                        <img class="banner-image-preview"
                                          src="{{ $restaurant->banner ? \Storage::url("restaurant/banners/".$restaurant->banner) : \Storage::url('default/restaurant-banner-placeholder.jpg') }}"
                                          alt="Banner Preview" style="max-width: 100%;">

                                        <i class="ri-upload-2-line upload_icon"></i>
                                      </a>
                                    </div>
                                    <small class="font-size-10 fw-medium">(Size 850px x 470px || Max: 1mb)</small>
                                    @error('banner')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                  </div>

                                </div>

                              </div>

                              <div class="mb-3">

                                <label for="name" class="form-label custom-form-label required-star">
                                  Restaurant Name <span class="required-indicator">*</span>
                                </label>

                                <div class="form-group">
                                  <input type="text" class="form-control" id="name" name="name" maxlength="100"
                                    value="{{ $restaurant->name ?? "" }}" required>
                                </div>

                                @error('name')
                                <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                              </div>

                              <div class="mb-3">
                                <label for="phone" class="form-label custom-form-label required-star">Phone <span
                                    class="required-indicator">*</span></label>
                                <div class="form-group">
                                  <input type="text" class="form-control" id="phone" name="phone" maxlength="20"
                                    value="{{ $restaurant->phone ?? "" }}" required>
                                  @error('phone')
                                  <p class="text-danger mt-1"> {{ $message }} </p>
                                  @enderror
                                </div>
                              </div>

                              <div class="mb-3">
                                <label for="phone" class="form-label custom-form-label required-star"> Address <span
                                    class="required-indicator">*</span></label>
                                <div class="form-group">
                                  <input type="text" class="form-control" id="phone" name="address" maxlength="150"
                                    value="{{ $restaurant->address ?? "" }}" required>
                                </div>

                                @error('address')
                                <p class="text-danger mt-1">{{ $message ?? "" }}</p>
                                @enderror
                              </div>

                              <div class="row">

                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label for="start" class="form-label custom-form-label required-star">Start Time
                                      <span class="required-indicator">*</span></label>
                                    <div class="form-group">
                                      <input type="time" class="form-control" id="start" name="start_time"
                                        value="{{ $restaurant->start_time ? \Carbon\Carbon::parse($restaurant->start_time)->format('H:i') : '' }}"
                                        required>

                                    </div>

                                    @error('start_time')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror

                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label for="end" class="form-label custom-form-label required-star">End Time <span
                                        class="required-indicator">*</span></label>
                                    <div class="input-group">
                                      <input type="time" class="form-control" id="end" name="end_time"
                                        value="{{ $restaurant->start_time ? \Carbon\Carbon::parse($restaurant->end_time)->format('H:i') : '' }}"
                                        required>
                                    </div>
                                    @error('end_time')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                  </div>
                                </div>

                                <div class="col-md-12 text-end">
                                  <button type="submit" class="btn btn-primary  float-end px-3">Update</button>
                                </div>

                              </div>

                            </form>

                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="accordion-item  custom-accordion-item border-0">

                    <h2 class="accordion-header " id="catalog">
                      <button class="accordion-button custom-accordion-button  rounded-0 collapsed mb-0"
                        data-accordion-name="catalog-items" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="ri-article-line me-2"></i> Catalog Items
                        <i class="ri-arrow-down-s-line ms-auto"></i>
                      </button>
                    </h2>

                    <div id="collapseTwo" class="accordion-collapse border-0 collapse " aria-labelledby="catalog"
                      data-bs-parent="#accordionExample">
                      <div class="accordion-body p-0 border-0 ">
                        <div class="_card">
                          <div class="card-header p-2">

                            <h5 class="card-title">Catalog Lists </h5>

                            <div class="card-options">
                              <a href="{{ route("account.catalog.create") }}" data-bs-toggle="modal"
                                data-bs-target="#dynamicmodal" class="btn btn-primary  float-end px-3">
                                Add <i class="ri-add-line"></i>
                              </a>
                            </div>

                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table mb-2">

                                <thead>
                                  <tr>
                                    <th class="d-none d-md-table-cell" style="width: 50px;">SL </th>
                                    <th style="width: 500px;">Name</th>
                                    <th class="d-none d-md-table-cell" style="width: 100px;">Item Count</th>
                                    <th style="width: 30px;">Status</th>
                                    <th style="width: 30px;">Order</th>
                                    <th style="width: 30px;">Action</th>
                                  </tr>
                                </thead>

                                <tbody>

                                  @forelse ($catalogs as $catalog)

                                  <tr class="align-middle text-nowrap">

                                    <td class="d-none d-md-table-cell">{{ $catalog->serial_index }}</td>

                                    <td>{{ $catalog->name }}</td>

                                    <td class="d-none d-md-table-cell">{{ $catalog->item_count }}</td>

                                    <td>

                                      @if ( $catalog->status == 1 )

                                      <i class="ri-checkbox-circle-fill text-success "></i>

                                      @else

                                      <i class="ri-close-circle-fill text-danger"></i>

                                      @endif

                                    </td>

                                    <td>{{ $catalog->display_order }}</td>

                                    <td class="text-end">

                                      <a href="{{ route("account.catalog.edit",$catalog->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#dynamicmodal"
                                        class="btn btn-sm  shadow-sm text-decoration-none text-success font-size-14 me-2">
                                        <i class="ri-edit-box-line custom-text-decoration"></i>
                                      </a>
                                      <a href="javascript:runDelete('{{ route("account.catalog.delete",$catalog->id) }}')"
                                        class="btn btn-sm  shadow-sm text-danger text-decoration-none font-size-14">
                                        <i class="ri-delete-bin-6-line custom-text-decoration"></i>
                                      </a>

                                    </td>

                                  </tr>

                                  @empty

                                  <tr>
                                    <td colspan="10" class="text-center">No Data Found</td>
                                  </tr>

                                  @endforelse

                                </tbody>

                                @if ($catalogs->hasPages())
                                <tfoot>
                                  <tr>
                                    <td colspan="10" class="border-0">
                                      <div class="mt-2 ">
                                        {{ $catalogs->links('vendor.pagination.bootstrap-5') }}
                                      </div>
                                    </td>
                                  </tr>
                                </tfoot>
                                @endif

                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="accordion-item custom-accordion-item border-0">
                    <h2 class="accordion-header" id="product">
                      <button class="accordion-button custom-accordion-button collapsed mb-0"
                        data-accordion-name="product-items" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="ri-restaurant-2-line me-2"></i> Menu Items
                        <i class="ri-arrow-down-s-line ms-auto"></i>
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse " aria-labelledby="product"
                      data-bs-parent="#accordionExample">
                      <div class="accordion-body p-0 border-0 ">

                        <div class="_card">
                          <div class="card-header p-2">
                            <h5 class="card-title">Item Lists</h5>

                            <div class="card-options">
                              <a href="{{ route("account.catalog.item.create") }}" data-modal-size="modal-lg"
                                data-bs-toggle="modal" data-bs-target="#dynamicmodal"
                                class="btn btn-primary  float-end px-3">
                                Add <i class="ri-add-line"></i>
                              </a>
                            </div>

                          </div>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table mb-2">
                                <thead>
                                  <tr>
                                    <th class="d-none d-md-table-cell" style="width: 20px;">SL </th>
                                    <th style="width: 50px;">Image</th>
                                    <th style="width: 480px;">Name</th>
                                    <th class="d-none d-md-table-cell" style="width: 400px;">Catalog Name</th>
                                    <th style="width: 50px;">Order</th>
                                    <th style="width: 50px;">Status</th>
                                    <th style="width: 50px;">Action</th>
                                  </tr>
                                </thead>

                                <tbody>

                                  @forelse ($catalog_items as $item)
                                  <tr class="align-middle">
                                    <td class="d-none d-md-table-cell"> {{ $item->serial_index }}</td>

                                    <td>
                                      <img class="rounded border"
                                        src="{{ $item->image ? \Storage::url("restaurant/products/thumbnails/".$item->image ?? "") : \Storage::url('default/item-pleaceholder.png') }}"
                                        alt="{{ $item->name }} logo" style="width: 50px; height: auto;">
                                    </td>

                                    <td>{{ $item->name }}</td>

                                    <td class="d-none d-md-table-cell">{{ $item->catalog_name }}</td>
                                    <td>{{ $item->display_order }}</td>

                                    <td>

                                      @if ( $item->status == 1 )

                                      <i class="ri-checkbox-circle-fill text-success "></i>

                                      @else

                                      <i class="ri-close-circle-fill text-danger"></i>

                                      @endif

                                    </td>

                                    <td class="text-end text-nowrap">

                                      <a href="{{ route("account.catalog.item.edit",$item->id) }}"
                                        data-bs-toggle="modal" data-modal-size="modal-lg" data-bs-target="#dynamicmodal"
                                        class="btn btn-sm  shadow-sm text-decoration-none text-success font-size-11 me-2">
                                        <i class="ri-edit-box-line custom-text-decoration"></i>
                                      </a>
                                      <a href="javascript:runDelete('{{ route("account.catalog.item.delete",$item->id) }}')"
                                        class="btn btn-sm  shadow-sm text-danger text-decoration-none font-size-11">
                                        <i class="ri-delete-bin-6-line custom-text-decoration"></i>
                                      </a>

                                    </td>

                                  </tr>

                                  @empty
                                  <tr>
                                    <td colspan="10" class="text-center">No Data Found</td>
                                  </tr>
                                  @endforelse

                                </tbody>

                                @if ( $catalog_items->hasPages() )
                                <tfoot>
                                  <tr>
                                    <td colspan="9" class="border-0">
                                      <div class="mt-2 ">
                                        {{ $catalog_items->links('vendor.pagination.bootstrap-5') }}
                                      </div>
                                    </td>
                                  </tr>
                                </tfoot>
                                @endif

                              </table>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="accordion-item custom-accordion-item border-0">
                    <h2 class="accordion-header" id="security">
                      <button class="accordion-button custom-accordion-button collapsed mb-0"
                        data-accordion-name="security" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <i class="ri-user-line me-2"></i> User Information
                        <i class="ri-arrow-down-s-line ms-auto"></i>
                      </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse " aria-labelledby="security"
                      data-bs-parent="#accordionExample">
                      <div class="accordion-body p-0 border-0 ">
                        <div class="_card">

                          <div class="card-body ">
                            <form action="{{ route('account.password.change') }}" method="POST">
                              @csrf

                              <div class="row mt-3">

                                <div class="col-md-4">
                                  <div class="form-group mb-4">

                                    <label for="name" class="form-label">Name</label>

                                    <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                      id="name" name="name" placeholder="User Name"
                                      value="{{ $restaurant_user->name }}">

                                    @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group  mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                      id="email" name="email" placeholder="Email"
                                      value="{{ $restaurant_user->email  }}">

                                    @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="  mb-4">
                                    <label for="phone" class="form-label">Phone</label>

                                    <div class="input-group">
                                      <input type="text"
                                      class="form-control bg-body-secondary rounded  @error('phone') is-invalid @enderror"
                                      id="phone" name="phone" placeholder="Phone" value="{{ $restaurant_user->phone  }}"
                                      readonly>
                                   
                                      <span class="bg-transparent border-0 border-start-0 fs-5 input-group-text py-0 rounded-end-2 text-success">
                                        <i class="ri-checkbox-circle-fill"></i>
                                      </span>

                                    </div>
                                   

                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                  </div>
                                </div>

                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <!-- New Password Field -->
                                  <div class="input-group mb-4 ">
                                    <input type="new-password"
                                      class="form-control   @error('new_password') is-invalid @enderror"
                                      id="new-password" name="new_password" placeholder="New Password">
                                    <span
                                      class="input-group-text bg-transparent border-start-0 rounded-end-2 toggle-password"
                                      data-target="#new-password">
                                      <i class="ri-eye-off-line"></i>
                                    </span>
                                    @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                                <div class="col-md-6">

                                  <!-- Confirm Password Field -->
                                  <div class="input-group mb-4">

                                    <input type="password"
                                      class="form-control  @error('new_password_confirmation') is-invalid @enderror"
                                      id="confirm-password" name="new_password_confirmation"
                                      placeholder="Confirm Password">
                                    <span
                                      class="input-group-text bg-transparent border-start-0 rounded-end-2 toggle-password"
                                      data-target="#confirm-password">
                                      <i class="ri-eye-off-line"></i>
                                    </span>
                                    @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                              </div>

                              <button type="submit" class="btn btn-primary  float-end px-3">Update</button>

                            </form>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>

  @push('scripts')

  <!-- Slick Slider JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <!-- Initialize Slick Slider -->
  <script type="text/javascript">

    // Dynamic Modal
    $(document).on('click', '[data-bs-target="#dynamicmodal"]', function(e) {
      e.preventDefault();
      // Get the modal size type from data attribute
      var modalSize = $(this).data('modal-size');
      var $modalDialog = $("#dynamicmodal .modal-dialog");
      // Add the new size class if provided
      if (modalSize) {
        $modalDialog.addClass(modalSize);
      }
      // Get the URL from the href attribute
      var url = $(this).attr('href');
      // Perform the AJAX request
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html', // Expecting HTML response to populate the modal
        success: function(response) {
          // Populate the modal content
          $('#dynamicmodal .modal-content').html(response);
        },
        error: function() {
          // Handle errors (optional)
          alert('Failed to load content.');
        }
      });
    });

    // Fila Manager Modal
    $(document).on('click', '[data-bs-target="#fileManagerModal"]', function(e) {
      e.preventDefault();
      // Get the URL from the href attribute
      var url = $(this).attr('href');
      // Perform the AJAX request
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html', // Expecting HTML response to populate the modal
        success: function(response) {
          // Populate the modal content
          $('#fileManagerModal .modal-content').html(response);
        }
      });
    });

    // Dynamic modal size class remove
    $('#dynamicmodal').on('hidden.bs.modal', function() {
      $(this).find('.modal-dialog').removeClass('modal-xxl modal-xl modal-lg modal-sm');
    });

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
            // AlertModal(type,title,message)
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

    //Password Toggle 
    $(document).ready(function() {
      $('.toggle-password').on('click', function() {
        var target = $($(this).data('target'));
        var icon = $(this).find('i');
        if (target.attr('type') === 'password') {
          target.attr('type', 'text');
          icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
        } else {
          target.attr('type', 'password');
          icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
        }
      });
    });

    //Accordion always open after page loading 
    $(document).ready(function() {
      // Event listener for accordion buttons
      $('.custom-accordion-button').on('click', function() {
        // Get the custom value from the data-accordion-name attribute
        var accordion_name = $(this).data('accordion-name');
        // Add the custom value to localStorage
        localStorage.setItem('accordion_name', accordion_name);
      });
      // Check if the accordion_name exists in localStorage and expand the corresponding accordion item
      var storedAccordionName = localStorage.getItem('accordion_name');
      if (storedAccordionName) {
        // Find the accordion button with the stored accordion name
        var targetAccordion = $('.custom-accordion-button[data-accordion-name="' + storedAccordionName + '"]');
        // If the target accordion button exists, expand its parent accordion item
        if (targetAccordion.length) {
          targetAccordion.parents('.accordion-item').find('.accordion-collapse').addClass('show');
        }
      }
    });

    // Alert modal
    function AlertModal(type, title, message) {
      // Get the modal elements
      const modalTitle = $('#dynamic-modal-title');
      const modalMessage = $('#dynamic-modal-message');
      const iconElement = $('#dynamic-modal-icon');
      const modalContent = $('.dynamic-modal-content');
      const iconBackground = $(".icon-background");
      // Set the modal title and message
      modalTitle.text(title);
      modalMessage.text(message);
      // Reset modal classes and icon
      modalContent.attr('class', 'modal-content text-center dynamic-modal-content');
      iconElement.attr('class', '');
      // Set the icon and styling based on the type of modal
      switch (type) {
        case 'success':
          iconBackground.addClass('success');
          iconElement.addClass('ri-check-fill ');
          break;
        case 'info':
          iconBackground.addClass('info');
          iconElement.addClass('ri-information-fill');
          break;
        case 'error':
          iconBackground.addClass('error');
          iconElement.addClass('ri-alert-fill');
          break;
        case 'warning':
          iconBackground.addClass('warning');
          iconElement.addClass('ri-alert-fill');
          break;
        default:
          iconBackground.addClass('success');
          iconElement.addClass('ri-information-fill ');
          break;
      }
      // Initialize and show the modal
      const dynamicModal = new bootstrap.Modal($('#dynamic-modal')[0]);
      dynamicModal.show();
    }
    // Delete modal
    function runDelete(path = "") {
      // Create the delete button HTML
      var csrfToken = '{{ csrf_token() }}';
      var deleteBtnHtml = `
        <form action="${path}" method="POST">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="${csrfToken}">

          <button type="submit" class="btn close btn-danger">
            Delete
          </button>
        </form>
        <button type="button" class="btn btn-outline-danger" id="deletemodal-dismis" data-bs-dismiss="modal">No, keep
          it</button>
        `;
      // Insert the HTML into the modal footer
      $('.delete-modal-footer').html(deleteBtnHtml);
      // Show the modal
      var deleteModal = new bootstrap.Modal(document.getElementById('deletealert'));
      deleteModal.show();
    }

  </script>

  @endpush

  @push('modals')

  <!-- Modal -->

  @endpush

</x-frontend-layout>