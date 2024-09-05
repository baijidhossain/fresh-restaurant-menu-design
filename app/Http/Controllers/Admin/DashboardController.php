<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {

    $users = \App\Models\User::count();

    $codes = \App\Models\Code::count();

    $availableCodes = \App\Models\Code::where('has_card', '!=', 1)->count();

    $restaurant_user = \App\Models\RestaurantUser::count();


    return view('admin.index', compact('users', 'codes', 'availableCodes', 'restaurant_user'));
  }
}
