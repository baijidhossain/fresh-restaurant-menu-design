
<x-guest-layout>
  <div class="container">

    <div class="row justify-content-center">

      <div class="col-lg-4 col-md-8 col-sm-12 ">

        <div class="form-card">

          <div class="form-card-header">

            <x-authentication-card-logo />

            <div class="form-card-title">Login</div>

          </div>

          <div class="form-card-body">

            <x-validation-errors class="mb-4 mb-2000" />

            @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
              {{ session('status') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">

              @csrf

              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com"
                  autocomplete="off">
                <label for="floatingInput">Email address</label>
              </div>

              <div class="form-floating mb-3 d-flex">
                <input type="password" class="form-control form-card-input" name="password" id="password"
                  placeholder="Password" autocomplete="off">

                <label for="floatingPassword">Password</label>

                <span class="input-group-text custom-input-group-text toggle-password" data-target="#password">
                  <i class="ri-eye-off-line"></i>
                </span>
              </div>

              <div class="d-flex justify-content-between mb-5">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="remember_me" id="remember_me" name="remember">
                  <label class="form-check-label" for="remember_me">Remember</label>
                </div>

                @if (Route::has('password.forget'))

                <p><a href="{{ route('password.forget') }}" class="text-dark"> {{ __('Forgot your password?') }}</a></p>
                @endif

              </div>

              <div class="mb-5 text-center">
                <button type="submit" class="btn custom-btn1">Login</button>
              </div>

              <div class="text-center">
                Don’t have an account?
                <a class="text-dark" href="javascript:void(0)"> Sign Up </a>
              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>
</x-guest-layout>