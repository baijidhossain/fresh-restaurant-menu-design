{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">

            @csrf


            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

</x-guest-layout> --}}




<x-guest-layout>

  @push('css')
  <style>
    .form-card {
      min-height: 350px;
    }
  </style>
  @endpush

  <div class="container">

    <div class="row justify-content-center">

      <div class="col-lg-4 col-md-8 col-sm-12 ">

        <div class="form-card">

          <form method="POST" action="{{ route('password.update') }}">
           @csrf
            <div class="form-card-header mb-5">

              <x-authentication-card-logo />

              <div class="form-card-title">Set New Password</div>
            </div>

            <div class="form-card-body">

              <div class="form-floating mb-3 d-flex">
                <input type="password" class="form-control new-password-input" id="new-password" placeholder="New Password" name="new_password">
                <label for="new-password"> New Password</label>
                <span class="input-group-text custom-input-group-text toggle-password" data-target="#new-password"> <i class="ri-eye-off-line"></i></span>
              </div>
    
              <div class="form-floating mb-5 d-flex">
                <input type="password" class="form-control new-password-input" id="confirm-password" name="new_password_confirmation" placeholder="Confirm Password">
                <label for="confirm-password">Confirm Password</label>
                <span class="input-group-text custom-input-group-text toggle-password" data-target="#confirm-password"> <i class="ri-eye-off-line"></i></span>
              </div>
    
              <div class="text-center">
                <button  type="submit" class="btn custom-btn1"> Reset Password</button>
              </div>

            </div>

          </form>

        </div>

      </div>

    </div>
  </div>

</x-guest-layout>




{{-- <div class="container">

  <div class="row justify-content-center">

    <div class="col-lg-4 col-md-8 col-sm-12 ">

      <ul class="d-flex gap-3 justify-content-center">
        <li><a href="login.html">login</a></li>
        <li><a href="new-password.html">Sign Up</a></li>
        <li><a href="forgot-password.html">Forgot Password</a></li>
        <li><a href="verify-code.html">verify code</a></li>
        <li><a href="new-password.html">New Password</a></li>
      </ul>

      <div class="form-card">

        <div class="form-card-header">
          <img src="/img/logo.svg" alt="logo" width="50" height="50" title="logo" class="mb-3">
          <div class="form-card-title">Set New Password</div>
        </div>

        <div class="new-password-body">

          <div class="form-floating mb-3 d-flex">
            <input type="password" class="form-control new-password-input" id="new-password" placeholder="New Password">
            <label for="new-password"> New Password</label>
            <span class="input-group-text custom-input-group-text toggle-password" data-target="#new-password"> <i class="ri-eye-off-line"></i></span>
          </div>

          <div class="form-floating mb-5 d-flex">
            <input type="password" class="form-control new-password-input" id="confirm-password" placeholder="Confirm Password">
            <label for="confirm-password">Confirm Password</label>
            <span class="input-group-text custom-input-group-text toggle-password" data-target="#confirm-password"> <i class="ri-eye-off-line"></i></span>
          </div>

          <div class="text-center">
            <a href="new-password.html" class="btn custom-btn1"> Reset Password</a>
          </div>

        </div>

      </div>

    </div>

  </div>
</div> --}}