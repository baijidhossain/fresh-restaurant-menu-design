<x-guest-layout>

  @push('css')

    <style>
      .form-card {
        min-height: 350px !important;
      }
    </style>

  @endpush

    {{-- <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ $route }}" class="space-y-6">
            @csrf

            <div class="text-center">
                <div class="bg-[#10b981] rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-sharp fa-solid fa-shield-keyhole text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Verify your code</h2>
                <p class="text-gray-600 mb-6">We have sent a code to your
                    phone<br>{{ $phone }}</p>
            </div>

            <div class="flex justify-between mb-6">
                @for ($i = 0; $i < 4; $i++)
                    <input type="text" id="code{{ $i }}" maxlength="1" name="code[{{ $i }}]"
                        class="w-20 h-14 border-2 rounded-lg text-center text-xl font-bold"
                        onkeydown="if (event.keyCode == 8 && this.value.length == 0) { this.previousElementSibling.focus(); }"
                        onkeyup="if (event.keyCode == 13) { document.getElementById('submit').click(); }"
                        oninput="if(this.value.length === 1) { document.getElementById('code{{ $i + 1 }}').focus(); } else { this.previousElementSibling.focus(); }"
                        required />
                @endfor
            </div>


            <button id="submit" type="submit"
                class="w-full bg-[#10b981] text-white py-3 rounded-lg font-semibold mb-4 hover:bg-[#1f8865] transition duration-300">
                Verify
            </button>

            <p class="text-center text-gray-600">
                Didn't receive code? <a href="{{ $resend }}" class="text-blue-500 font-semibold">Resend</a>
            </p>

        </form>

    </x-authentication-card> --}}


    <div class="container">

      <div class="row justify-content-center">

        <div class="col-lg-4 col-md-8 col-sm-12 ">

          <div class="form-card">

            <div class="form-card-header">

              <x-authentication-card-logo />
              <div class="form-card-title">Verify Code</div>
              <p class="mb-0">We Have Sent a Code to Your Phone</p>
              <p class="fw-bold mb-4 text-dark-emphasis"> {{ $phone }} </p>

            </div>

            <div class="form-card-body">

              <form method="POST" action="{{ $route }}">
                @csrf
                <div class="d-flex gap-4 justify-content-center mb-5">

                  @for ($i = 0; $i < 4; $i++) <input type="text" class="form-control code-verify-input text-center"
                    id="code{{ $i }}" maxlength="1" name="code[{{ $i }}]" tabindex="{{ $i + 1 }}" required>
                    @endfor
                </div>

                <div class="text-center">
                  <button type="submit" class="btn custom-btn1">Verify</button>
                </div>

                <p class="text-center mt-5">
                  Didn't receive code? <a href="{{ $resend }}" class="text-blue-500 font-semibold">Resend</a>
              </p>

              </form>

            </div>

          </div>

        </div>

      </div>
    </div>

    @push('scripts')
        
      <script>

        // Password Toggle------------------------------------------------
        $('.toggle-password').on('click', function () {
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


        // Code verify field indexing
        $(document).ready(function () {
          $('.code-verify-input').on('input', function () {
            if ($(this).val().length === 1) {
              const nextInput = $(this).next('.code-verify-input');
              if (nextInput.length) {
                nextInput.focus();
              } else {
                $(this).blur(); // Blur to hide the keyboard if no more inputs
              }
            }
          });

          $('.code-verify-input').on('keydown', function (e) {
            if ((e.key === "Backspace" || e.key === "Delete") && $(this).val() === '') {
              const prevInput = $(this).prev('.code-verify-input');
              if (prevInput.length) {
                prevInput.focus();
              }
            }
          });

          $('.code-verify-input').on('click', function () {
            $(this).select(); // Selects the text to make replacing easier
          });
        });


      </script>

    @endpush

</x-guest-layout>
