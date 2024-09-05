<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RestaurantUser;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use App\Models\Code;
use App\Models\Otp;
use Illuminate\Contracts\Session\Session;
use sms_net_bd\SMS;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
  public function showLoginForm()
  {
    //return if user is already logged in

    if (Auth::guard('frontend')->check()) {
      return redirect()->route('profile', Auth::guard('frontend')->user()->slug);
    }

    return view('login');
  }

  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('frontend')->attempt($credentials)) {
      return redirect()->route('profile', Auth::guard('frontend')->user()->slug);
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }

  public function showRegistrationForm($code)
  {
    //check code exists
    $find = Code::where(['code' => $code])->firstOrFail();

    //check  code has contact
    if ($find->contact) {
      abort(404);
    }

    //return if user is already logged in
    if (Auth::guard('frontend')->check()) {
      return redirect()->route('profile', Auth::guard('frontend')->user()->slug);
    }

    return view('register', ['code' => $code]);
  }

  public function forgetForm(Request $request)
  {
    return view('forget-password');
  }


  public function forgetAction(Request $request)
  {
    return $this->forgotLogic($request);
  }

  private function forgotLogic($request)
  {

    $this->validate($request, [
      'phone' => 'required',
    ]);

    $restaurant_user = RestaurantUser::where(['phone' => $request->phone])->first();

    if (!$restaurant_user) {
      return redirect()->back()->withErrors(['phone' => 'The phone number you entered is not registered.']);
    }

    $otp = Otp::where('restaurant_user_id', $restaurant_user->id)
      ->orderBy('created_at', 'desc')->first();

    $now = now()->format('Y-m-d H:i:s');

    if ($otp && $otp->expires_at < $now || !$otp) {

      $code = rand(1000, 9999);

      Otp::create([
        'restaurant_user_id' => $restaurant_user->id,
        'phone' => $restaurant_user->phone,
        'token' => $code,
        'expires_at' => now()->addMinutes(5)->format('Y-m-d H:i:s'),
      ]);

      //send sms

      $sms = new SMS();

      try {

        $sms->sendSMS(
          "Your verification code is: " . $code . " - From GoCards",
          $restaurant_user->phone
        );
      } catch (\Exception $e) {
        Log::error($e->getMessage());
      }
    }

    //set session
    $request->session()->put('restaurant_user', $restaurant_user->id);

    $resend = route('otp.resend', ['action' => 'reset']);

    return view('verify-phone', ['phone' => $request->phone, 'route' => route('password.reset'), 'resend' => $resend]);
  }

  public function resetPasswordForm(Request $request)
  {

    $this->validate($request, [
      'code' => 'required',
    ]);

    $code = '';

    foreach ($request->code as $key => $value) {
      $code .= $value;
    }

    $restaurant_user = RestaurantUser::where(['id' => $request->session()->get('restaurant_user')])->first();


    $otp = Otp::where(['restaurant_user_id' => $restaurant_user->id, 'token' => $code])->orderBy('created_at', 'desc')->first();

    return view('reset-password', ['phone' => $request->phone]);
    if ($otp && $otp->expires_at > now()) {

      Otp::where(['restaurant_user_id' => $restaurant_user->id])->delete();

      $restaurant_user = RestaurantUser::where(['id' => $restaurant_user->id])->first();

      //update is_verified
      $restaurant_user->update(['is_verified' => true]);

      return view('reset-password', ['phone' => $request->phone]);
    } else {

      return back()->withErrors(['phone' => 'The OTP you entered is invalid.']);
    }
  }

  public function resetPassword(Request $request)
  {
    // Validate the new password with confirmation
    $validatedData = $request->validate([
      'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Get the restaurant user ID from the session
    $restaurant_user_id = $request->session()->get('restaurant_user');

    // Forget the session data
    $request->session()->forget('restaurant_user');

    // Retrieve the restaurant user by ID
    $restaurant_user = RestaurantUser::find($restaurant_user_id);

    if (!$restaurant_user) {
      return redirect()->route('password.forget')->withErrors("User not found.");
    }

    // Update the user's password with the hashed new password
    $restaurant_user->update([
      'password' => Hash::make($request->new_password),
    ]);

    // Redirect to the login page with a success message
    return redirect()->route('login')->with('success', "Password reset successfully.");
  }

  public function verifyPhoneForm(Request $request)
  {

    $user =  Auth::guard('frontend')->user();

    $otp = Otp::where('restaurant_user_id', $user->id)
      ->orderBy('created_at', 'desc')->first();

    $now = now()->format('Y-m-d H:i:s');

    if ($otp && $otp->expires_at < $now || !$otp) {

      $code = rand(1000, 9999);

      Otp::create([
        'restaurant_user_id' => $user->id,
        'phone' => $user->phone,
        'token' => $code,
        'expires_at' => now()->addMinutes(5)->format('Y-m-d H:i:s'),
      ]);

      $sms = new SMS();

      try {

        $sms->sendSMS(
          "Your verification code is: " . $code . " - From GoCards",
          $user->phone
        );
      } catch (\Exception $e) {
        Log::info($e->getMessage());
      }
    }

    $resend = route('otp.resend', ['action' => 'verify']);

    return view('verify-phone', ['phone' => $user->phone, 'route' => route('phone.verify'), 'resend' => $resend]);
  }

  public function resendOtp(Request $request)
  {
    if ($request->action == 'verify') {
      //reload page
      return redirect()->back();
    } else if ($request->action == 'reset') {

      $restaurant_user = $request->session()->get('restaurant_user');

      $restaurant_user = RestaurantUser::where(['id' => $restaurant_user])->first();

      //add key to request
      $request = $request->merge(['phone' => $restaurant_user->phone]);

      return $this->forgotLogic($request);
    } else {

      abort(404);
    }
  }

  public function verifyPhone(Request $request)
  {

    $this->validate($request, [
      'code' => 'required',
    ]);

    $code = '';

    foreach ($request->code as $key => $value) {
      $code .= $value;
    }

    $otp = Otp::where(['restaurant_user_id' => Auth::guard('frontend')->user()->id, 'token' => $code])
      ->orderBy('created_at', 'desc')->first();

    if ($otp && $otp->expires_at > now()) {

      Otp::where(['restaurant_user_id' => Auth::guard('frontend')->user()->id])->delete();

      Auth::guard('frontend')->user()->update(['is_verified' => true]);

      return redirect()->route('profile', Auth::guard('frontend')->user()->slug)->withSuccess("Phone number verified successfully.");
    } else {

      return redirect()->back()->withErrors(['phone' => 'The OTP you entered is invalid.']);
    }
  }

  public function register(Request $request)
  {
    // Find the code based on the provided code in the request
    $code = Code::where('code', $request->code)->firstOrFail();

    // Validate the request data
    $this->validate($request, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:restaurant_users',
      'phone' => 'required|unique:restaurant_users',
      'password' => 'required|min:6|confirmed',
      'restaurant_name' => 'required|max:40',
      'restaurant_phone' => 'required|max:20',
      'restaurant_address' => 'required|max:150',
    ]);

    // Create the restaurant user
    $restaurant_user = RestaurantUser::create([
      'slug' => RestaurantUser::generateSlug($request->restaurant_name),
      'name' => $request->name,
      'phone' => $request->phone,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'code_id' => $code->id,
      'is_verified' => false,
    ]);

    // Get the last inserted ID
    $lastInsertId = $restaurant_user->id;

    // Create the restaurant associated with the restaurant user
    $restaurant = Restaurant::create([
      'restaurant_user_id' => $lastInsertId,
      'name' => $request->restaurant_name,
      'phone' => $request->restaurant_phone,
      'address' => $request->restaurant_address,
    ]);

    // Log in the newly registered user
    Auth::guard('frontend')->login($restaurant_user);

    // Redirect to the profile page
    return redirect()->route('profile', $restaurant_user->slug);
  }

  public function logout()
  {
    Auth::guard('frontend')->logout();
    return redirect('/login');
  }
}
