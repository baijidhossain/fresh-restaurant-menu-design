<x-guest-layout>
  <div class="container">

    <div class="row justify-content-center">

      <div class="col-lg-4 col-md-8 col-sm-12 ">

        <div class="form-card">

          <div class="form-card-header">
            <div class="authentication-card-logo">
              <x-authentication-card-logo />
            </div>

            <div class="form-card-title">Registration</div>

          </div>

          <div class="signup-body">

            <form method="POST" action="{{ route('register', $code) }}">
              @csrf

              <div class="check-required-fields font-size-14 mb-4  text-center text-danger d-none"></div>
              <div class="restaurant_user">

                <div class="form-floating mb-3">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="phone-number"
                    name="name" value="{{ old('name') }}" placeholder="Name">
                  <label for="phone-number">Name*</label>
                  @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email') }}" placeholder="Email">
                  <label for="email">Email*</label>
                  @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                    value="{{ old('phone') }}" placeholder="Phone Number" maxlength="15">
                  <label for="phone">Phone Number*</label>
                  @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class=" mb-3 ">
                  <div class="form-floating d-flex">
                    <input type="password" class="form-control signup-input @error('password') is-invalid @enderror"
                      id="new-password" name="password" placeholder="New Password" minlength="8">
                    <label for="new-password">New Password*</label>

                    <span class="input-group-text custom-input-group-text toggle-password" data-target="#new-password">
                      <i class="ri-eye-off-line"></i>
                    </span>
                  </div>

                  @error('password')
                  <div class="text-danger font-size-14 mt-1">{{ $message }}</div>
                  @enderror

                  <div class="text-danger font-size-14 mt-1 d-none check-new-and-confirm-password">The password field
                    confirmation does not match.</div>
                </div>

                <div class="mb-5 ">

                  <div class="form-floating d-flex">

                    <input type="password"
                      class="form-control signup-input @error('password_confirmation') is-invalid @enderror"
                      id="confirm-password" name="password_confirmation" placeholder="Confirm Password" minlength="8">
                    <label for="confirm-password">Confirm Password*</label>
                    <span class="input-group-text custom-input-group-text toggle-password"
                      data-target="#confirm-password">
                      <i class="ri-eye-off-line"></i>
                    </span>

                  </div>

                  @error('password_confirmation')
                  <div class="text-danger font-size-14 mt-1">{{ $message }}</div>
                  @enderror

                </div>

              </div>

              <div class="restaurant_info d-none">

                <div class="form-floating mb-3">
                  <input type="text" class="form-control @error('restaurant_name') is-invalid @enderror"
                    id="restaurant_name" name="restaurant_name" value="{{ old('restaurant_name') }}"
                    placeholder="Restaurant Name">
                  <label for="restaurant_name">Restaurant Name*</label>
                  @error('restaurant_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-3">
                  <input type="number" class="form-control @error('restaurant_phone') is-invalid @enderror"
                    id="restaurant_phone" name="restaurant_phone" value="{{ old('restaurant_phone') }}"
                    placeholder="Restaurant Phone">
                  <label for="restaurant_phone">Restaurant Phone*</label>
                  @error('restaurant_phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-5">
                  <input type="text" class="form-control @error('restaurant_address') is-invalid @enderror"
                    id="restaurant_address" name="restaurant_address" value="{{ old('restaurant_address') }}"
                    placeholder="Restaurant Address">
                  <label for="restaurant_address">Restaurant Address*</label>
                  @error('restaurant_address')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

              </div>

              <div class="mb-5 text-center">

                <div class="d-flex gap-5 justify-content-between register-previous d-none">
                  <button type="button" class="btn btn-outline-secondary mb-2 previous">Previous</button>
                  <button type="submit" class="btn custom-btn1 mb-2 ">Register</button>
                </div>

                <button type="button" class="btn custom-btn1 next mb-2">{{ __('Next') }}</button>
              </div>

            </form>
            <div class="text-center">

              Already have an account?

              <a class="text-dark txt2" href="{{ route('login') }}"> Login </a>

            </div>

          </div>

        </div>

      </div>

    </div>
  </div>

  @push('scripts')

  <script>
    $(document).ready(function() {
      $(".next, .previous").click(function() {
        // Gather form values
        let newPassword = $("#new-password").val();
        let confirmPassword = $("#confirm-password").val();
        let name = $("#phone-number").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        
        // Reset error messages
        $(".check-new-and-confirm-password, .check-required-fields").addClass("d-none");
  
        // Validate required fields
        if (!name || !email || !phone) {
          showError(".check-required-fields", "Fill all the required fields");
          return;
        }
  
        // Validate password fields
        if (!newPassword || !confirmPassword) {
          showError(".check-new-and-confirm-password", "Password fields cannot be empty");
          return;
        }
  
        // Validate minimum password length
        if (newPassword.length < 8) {
          showError(".check-new-and-confirm-password", "Password must be at least 8 characters long");
          return;
        }
  
        // Validate password match
        if (newPassword !== confirmPassword) {
          showError(".check-new-and-confirm-password", "Passwords do not match");
          return;
        }
  
        // If all validations pass, proceed with form changes
        $(".restaurant_user, .restaurant_info, .register-previous, .next, .authentication-card-logo")
          .toggleClass("d-none");
        let newTitle = $(".form-card-title").text() === "Restaurant Setup" ? "Registration" : "Restaurant Setup";
        $(".form-card-title").text(newTitle);
        $(".form-card").css("min-height", newTitle === "Restaurant Setup" ? "490px" : "530px");
      });
  
      function showError(selector, message) {
        $(selector).text(message).removeClass("d-none");
        setTimeout(function() {
          $(selector).addClass("d-none");
        }, 5000); // 5000 milliseconds = 5 seconds
      }
    });
  </script>
  

  @endpush
</x-guest-layout>