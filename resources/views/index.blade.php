<x-frontend-layout>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="/">
        <x-application-logo />
      
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="{{ route("login") }}"> <i class="ri-login-box-line"></i>
            Login</a>
        </div>
      </div>
    </div>
  </nav>

  <section class="text-secondary min-vh-100 d-flex align-items-center">
    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <h1 class="d-flex justify-content-center align-items-center bg-gradient text-white fs-3 fw-bold">
            <!-- Apply specific width and height if needed -->
            <img src="{{ \Storage::url('gocards.svg') }}" alt="" width="350"  >
          </h1>

          <p class="mt-4 mx-auto fs-5">
            We are the leading provider of NFC business cards in Bangladesh. We offer high-quality NFC cards
            with your branding.
          </p>

          <div class="mt-4 d-flex justify-content-center gap-3">
            <a class="btn btn-primary rounded-pill px-4 py-2 fs-6 fw-medium" href="#">
              Get Started
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    .bg-gradient {
      background: linear-gradient(to right, #86efac, #3b82f6, #a855f7);
    }

    .min-vh-100 {
      min-height: 100vh;
    }
  </style>

</x-frontend-layout>