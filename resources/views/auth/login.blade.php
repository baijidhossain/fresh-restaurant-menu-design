{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4" x-data="{ showPassword: false }">
                <x-label for="password" value="{{ __('Password') }}" />
                <div class="relative">
                    <input id="password" name="password"  :type="showPassword ? 'text' : 'password'" id="password" class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none block mt-1 w-full" autocomplete="current-password" required>
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-gray-600">
                        <i x-show="!showPassword" class="far fa-eye"></i>
                        <i x-show="showPassword" class="far fa-eye-slash"></i>
                    </button>
                </div>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('admin.password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}


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

            <form action="{{ route('admin.login') }}" method="POST">

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
                  <input type="checkbox" class="form-check-input" id="remember_me"  name="remember">
                  <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                </div>

                @if (Route::has('password.forget'))

                <p><a href="{{ route('password.forget') }}" class="text-dark"> {{ __('Forgot your password?') }}</a></p>
                @endif

              </div>

              <div class="mb-5 text-center">
                <button type="submit" class="btn custom-btn1">{{ __('Log in') }}</button>
              </div>



            </form>

          </div>

        </div>

      </div>

    </div>

  </div>
</x-guest-layout>