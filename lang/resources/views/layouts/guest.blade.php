

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>Restaurant form-card</title>
  
  <meta charset="utf-8">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">


    <style>
      textarea::placeholder {
        color: #999;
        font-size: 13px;
      }
  
      input::placeholder {
        color: #999;
        font-size: 13px;
      }
  
      body {
        font-family: "Raleway", system-ui;
        font-optical-sizing: auto;
      }
  
      /* table */
      .edit-page tbody,
      td,
      tfoot,
      th,
      thead,
      tr {
        border-color: inherit;
        border-style: solid;
        border-width: 0;
        font-size: 14px;
      }
  
      .edit-page table thead tr th {
        font-size: 14px;
        font-weight: 600;
        color: #444;
      }
  
      ._card {
        --spacing: 1.5rem 1.5rem;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0);
        border-radius: .3rem;
        border-top: 3px solid rgba(0, 0, 0, 0);
        box-shadow: 0 .76rem 1.52rem rgba(18, 38, 63, .03);
        display: flex;
        flex-direction: column;
        font-size: .875rem;
        margin-bottom: 1.5rem;
        position: relative;
        width: 100%;
        word-wrap: break-word;
      }
  
      ._card .card-header {
        align-items: center;
        border-bottom: 1.5px solid;
        border-color: #e6ebf1;
        color: #444;
        display: flex;
        font-size: 1.125rem;
        margin-bottom: 0;
        min-height: 2.9rem;
        padding: .5rem 1.5rem;
        position: relative;
        background-color: white;
      }
  
      ._card .card-body {
        flex: 1 1 auto;
        margin: 0;
        padding: 0.5rem;
        position: relative;
      }
  
      ._card .card-title {
        font-size: 15px;
        font-weight: 600;
        line-height: 1.2;
        text-transform: capitalize;
        margin-bottom: 0;
      }
  
      .card-options {
        align-self: center;
        color: #9aa0ac;
        display: flex;
        margin-left: auto;
  
      }
  
      .menu-banner {
        width: 100%;
        height: 160px;
        position: relative;
      }
  
      .item-image-box {
        width: 70px;
        height: 70px;
        position: relative;
      }
  
      .menu-item-image {
        width: 90px;
        height: 90px;
      }
  
      .offer-badge {
        position: absolute;
        background-color: #ffc107;
        padding: 0px 6px;
        border-radius: 4px;
        font-weight: 600;
        color: white;
        font-size: 13px;
        top: 6%;
        left: 33%;
      }
  
      .offer-price {
        color: #6c757d;
        font-size: 13px;
        font-weight: 600;
        text-decoration: line-through;
        position: absolute;
        top: 70%;
        left: 3%;
      }
  
      .custom-accordion-item {
        margin-bottom: 20px;
      }
  
      .custom-accordion-button {
        font-size: 16px;
        font-weight: 600;
        background-color: #f8f9fa;
        color: #282828;
        padding: 1.1rem .5rem;
        border-bottom: .0625rem solid rgba(231, 234, 243, .7);
        margin-bottom: 17px;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
        box-shadow: 0 6px 12px rgba(140, 152, 164, .075);
        border-bottom: .0625rem solid rgba(231, 234, 243, .7);
  
      }
  
      .custom-accordion-button:focus {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0) !important;
        background-color: #f8f9fa;
        padding: 1rem .5rem;
        margin-bottom: 17px;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
      }
  
      .custom-accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        padding: 1rem .5rem;
        margin-bottom: 17px;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
      }
  
      .custom-accordion-item:last-of-type>.accordion-header .accordion-button.collapsed {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
  
      .form-control:focus {
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border-color: #dee2e6;
        outline: 0;
        box-shadow: 0 0 0 0rem rgba(13, 110, 253, .25);
      }
  
      .form-select:focus {
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border-color: #dee2e6;
        outline: 0;
        box-shadow: 0 0 0 0rem rgba(13, 110, 253, .25);
      }
  
      .search-input-group {
        box-shadow: 5px 5px 5px 5px;
      }
  
      .search-input::placeholder {
        font-size: 14px;
      }
  
      /* Banner */
      .banner-container {
        position: relative;
        width: 100%;
        min-height: 220px;
        overflow: hidden;
      }
  
      .banner-container .logo {
        width: 40px;
        height: 40px;
      }
  
      .banner-container .restaurant-banner {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
      }
  
      .banner-container-contact {
        margin-top: 25px;
        color: white;
        padding: 0px 14px;
        font-size: 14px;
        font-weight: 500;
      }
  
      .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background: linear-gradient(10deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3)); */
        color: white;
        text-align: left;
        padding: 10px 2px;
      }
  
      .overlay-content {
        max-width: 325px;
        margin-top: 35px;
      }
  
      /* Menu category */
      .btn-check:checked+.btn,
      .btn.active,
      .btn.show,
      .btn:first-child:active,
      :not(.btn-check)+.btn:active {
        color: var(--bs-btn-active-color);
        background-color: var(--bs-btn-active-bg);
        border-color: #fff;
      }
  
      /* List item styling */
      .list-item {
        border-bottom: 1px solid #ddd;
        /* Border between list items */
        padding: 1rem;
        /* Padding around content */
        transition: background-color 0.3s ease;
        /* Smooth background color transition */
      }
  
      .list-item:last-child {
        border-bottom: none;
        /* Remove border from the last item */
      }
  
      .list-item-content {
        display: flex;
        align-items: center;
        gap: 1rem;
      }
  
      .item-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        /* Maintain aspect ratio */
        border-radius: 0.5rem;
        /* Rounded corners for image */
        border: 1px solid #ddd;
        /* Border around image */
      }
  
      .item-details {
        flex: 1;
        /* Allow this container to grow and fill space */
      }
  
      .item-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 0;
        color: #333;
      }
  
      .item-description {
        font-size: 14px;
        margin-bottom: 0.1rem;
        color: #666;
        line-height: normal;
      }
  
      .item-tags {
        font-size: 14px;
        margin-bottom: 0.5rem;
        font-weight: 700;
        margin-bottom: 0;
      }
  
      .item-price {
        font-size: 16px;
        font-weight: bold;
        color: tomato;
        position: relative;
        margin-bottom: 12px;
        margin-left: 12px;
      }
  
      .text_tomato {
        color: tomato !important;
      }
  
      .list-item:hover {
        background-color: #f9f9f9;
        /* Light background on hover */
        cursor: pointer;
        /* Indicate that the item is clickable */
      }
  
      .nav-tabs .nav-link.active {
        border-bottom: 2px solid #007bff00 !important;
      }
  
      .nav-tabs .nav-item.show .nav-link,
      .nav-tabs .nav-link.active {
        color: #555;
        background-color: #007bff00;
        border-color: #007bff00;
      }
  
      .active.menu_active {
        background-color: tomato !important;
        color: white !important;
      }
  
      .banner-text {
        font-weight: normal;
        font-size: 14px;
      }
  
      .banner-title {
        font-weight: 700;
      }
  
  
      .menu_category_button {
        font-weight: 600;
        font-size: 15px;
        padding-top: 9px;
        padding-bottom: 9px;
        border: 1.5px solid tomato;
      }
  
      .menu_category_button:hover {
        background-color: tomato !important;
        color: white !important;
      }
  
      .save_btn {
        background-color: tomato;
        color: #fff;
      }
  
      .contact_me_btn {
        background-color: tomato;
        color: #fff;
      }
  
      .sticky-search {
        position: sticky;
        top: 0;
        z-index: 990;
        background-color: white;
      }
  
      .sticky-search .input-group,
      .sticky-search .search_button {
        height: 40px;
      }
  
      .dropdown-btn {
        font-weight: 400;
        font-size: 20px;
        padding: 0;
        color: white;
      }
  
      .menu-item-list {
        margin-bottom: 0;
      }
  
      /* Footer */
      .footer {
        background-color: #f8f9fa;
        text-align: center;
        padding: 15px;
        font-size: 13px;
        border-left: 1px solid #dddddd;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
      }
  
      .slick-prev,
      .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1000;
  
        border: none;
        color: white;
        padding: 5px;
        cursor: pointer;
        font-size: 12px;
        /* Adjust icon size */
        border-radius: 50%;
        /* Round arrow buttons */
        width: 30px;
        /* Set width to 20px */
        height: 30px;
        /* Set height to 20px */
      }
  
      .slick-prev:hover,
      .slick-next:hover {
        background-color: rgba(0, 0, 0, 0.8);
        /* Darken on hover */
      }
  
      .slick-prev {
        left: 10px;
        /* Adjust positioning */
      }
  
      .slick-next {
        right: 10px;
        /* Adjust positioning */
      }
  
      .slick-prev i,
      .slick-next i {
        font-size: 10px;
        /* Adjust icon size to fit the button */
      }
  
      .slick-prev:hover,
      .slick-prev:focus,
      .slick-next:hover,
      .slick-next:focus {
        color: transparent;
        outline: none;
        background: #dc3545;
      }
  
      .slick-prev:before,
      .slick-next:before {
        font-family: 'slick';
        font-size: 16px;
        background: rgb(0 0 0 / 0%);
        line-height: 1;
        opacity: 1;
        color: #dee2e6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }
  
      .slick-prev:hover,
      .slick-prev:focus,
      .slick-next:hover,
      .slick-next:focus {
        color: transparent;
        outline: none;
        background: #dc354600;
      }
  
      /* Extra Design */
  
      .custom-add-btn {
        width: 56px;
        padding: 1px;
        border-radius: 4px;
        background-color: #198754;
        color: white;
        font-size: 14px;
        font-weight: 600;
      }
  
      .custom-add-btn:hover,
      .custom-add-btn:focus {
        width: 56px !important;
        padding: 1px !important;
        border-radius: 4px !important;
        background-color: #198754 !important;
        color: white !important;
        font-size: 14px !important;
      }
  
      .custom-form-label {
        font-weight: 600 !important;
      }
  
      .product-image {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 3px;
      }
  
      .action-btn {
        padding: 3px 4px;
        border-radius: 3px;
      }
  
      .custom-text-decoration {
        text-decoration: underline;
        text-underline-offset: 2px;
        line-height: -0.5;
        text-decoration-thickness: 0.1rem;
      }
  
      .input-group-text {
        cursor: pointer;
      }
  
      .btn-tomato {
        background-color: tomato !important;
        color: white !important;
        border-color: tomato !important;
      }
  
      .font-size-10 {
        font-size: 10px !important;
      }
  
      .font-size-11 {
        font-size: 11px !important;
      }
  
      .font-size-12 {
        font-size: 12px !important;
      }
  
      .font-size-13 {
        font-size: 13px !important;
      }
  
      .font-size-14 {
        font-size: 14px !important;
      }
  
      .font-size-15 {
        font-size: 15px !important;
      }
  
      /* Custom Form Card Design */
      .form-card {
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0);
        border-radius: .3rem;
        border-top: 3px solid rgba(0, 0, 0, 0);
        box-shadow: 0 .76rem 1.52rem rgba(18, 38, 63, .03);
        display: flex;
        flex-direction: column;
        position: relative;
        width: 100%;
        word-wrap: break-word;
        padding: 20px 15px;
        min-height: 530px;
        justify-content: space-between;
      }
  
      .form-card-header {
        text-align: center;
      }
  
      .form-card-title {
        display: block;
        font-family: Raleway;
        font-size: 25px;
        color: #333;
        line-height: 1.2;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
      }
  
      .form-floating .form-card-input {
        border-right: 0;
        border-top-right-radius: unset;
        border-bottom-right-radius: unset;
      }
  
      .custom-btn1 {
        width: 100%;
        background-color: rgb(250, 74, 42);
        color: white;
        font-weight: 700;
        padding: 10px;
      }
  
      .custom-btn1:hover,
      .custom-btn1:active {
        background-color: tomato !important;
        color: white !important;
        font-weight: 700 !important;
        padding: 10px !important;
      }
  
      .custom-input-group-text {
        border-radius: unset;
        background: transparent;
        border-left: 0;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
      }
  
      .form-floating .signup-input {
        border-right: 0;
        border-top-right-radius: unset;
        border-bottom-right-radius: unset;
      }
  
      .form-floating .new-password-input {
        border-right: 0;
        border-top-right-radius: unset;
        border-bottom-right-radius: unset;
      }
  
      .form-floating .verify-phone-input {
        border-right: 0;
        border-top-right-radius: unset;
        border-bottom-right-radius: unset;
      }
  
      .custom-input-group-text {
        border-radius: unset;
        background: transparent;
        border-left: 0;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
      }
  
      .code-verify-input {
        line-height: 2.1rem;
        font-weight: 600;
        color: #495057;
        font-size: 15px;
      }
  
  
      /* Edit Page */
  
      .accordion-button::after {
        display: none;
      }
  
      .accordion-button.collapsed .ri-arrow-down-s-line {
        transform: rotate(0deg);
        transition: transform 0.3s ease;
      }
  
      .accordion-button:not(.collapsed) .ri-arrow-down-s-line {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
      }
  
      .table>:not(caption)>*>* {
        border-color: #e8e8e8 !important;
      }
  
      .drop-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        width: 100%;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 1em;
        color: #aaa;
        background-color: #f9f9f9;
        position: relative;
        transition: border-color 0.3s, background-color 0.3s;
        overflow: hidden;
      }
  
      .drop-area#drop-area-product {
        height: 114px !important;
      }
  
      .drop-area.dragover {
        border-color: #4a90e2;
        background-color: #e1f5fe;
      }
  
      #preview-logo {
        max-width: 100%;
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
  
      #preview-banner {
        max-width: 100%;
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
  
      #file-input-logo,
      #file-input-banner {
        display: none;
      }
  
      .upload_icon {
        font-size: 15px;
        color: #ccc;
        cursor: pointer;
        position: absolute;
        bottom: 10px;
        right: 10px;
        cursor: pointer;
      }
  
      @media only screen and (max-width: 600px) {
  
        .banner-container-contact {
          font-size: 12px;
        }
      }
  
      @media only screen and (max-width: 400px) {
  
        .banner-container-contact {
          font-size: 11px;
        }
      }
  
      @media only screen and (max-width: 320px) {
  
        .banner-container-contact {
          font-size: 9px;
        }
      }
    </style>

  @stack('css')

</head>

<body class="vh-100 d-flex align-items-center justify-content-center">

  {{ $slot }}

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Password Toggle------------------------------------------------
    $('.toggle-password').on('click', function() {
      
      var target = $(this).data('target');
      var input = $(target);
      var icon = $(this).find('i');
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
      } else {
        input.attr('type', 'password');
        icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
      }
    });
  </script>

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

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
</body>

</html>