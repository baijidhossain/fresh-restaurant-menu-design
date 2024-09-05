{{-- <x-guest-layout>

    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.forget') }}" class="space-y-6">
@csrf

<div class="text-center">

  <div class="bg-[#10b981] rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
    <i class="fa-sharp fa-solid fa-lock text-white text-3xl"></i>
  </div>

  <h2 class="text-2xl font-bold mb-2">Forget Password</h2>

</div>

<div>
  <x-label for="phone" value="Enter your phone" />
  <x-input id="phone" class="block mt-1 w-full" type="phone" name="phone" :value="old('email')" required autofocus
    autocomplete="phone" />
</div>

<button id="submit" type="submit"
  class="w-full bg-[#10b981] text-white py-3 rounded-lg font-semibold mb-4 hover:bg-[#1f8865] transition duration-300">
  Reset Password
</button>

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

          <form method="POST" action="{{ route('password.forget') }}">
           @csrf
            <div class="form-card-header mb-5">

              <x-authentication-card-logo />

              <div class="form-card-title ">Forgot Password</div>
            </div>

            <div class="form-card-body">

              <div class="form-floating mb-5">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                <label for="phone" class="form-card-input-label">Phone Number</label>
              </div>

              <div class="text-center">
                <button type="submit" class="btn custom-btn1">Continue</button>
              </div>

            </div>

          </form>

        </div>

      </div>

    </div>
  </div>

</x-guest-layout>