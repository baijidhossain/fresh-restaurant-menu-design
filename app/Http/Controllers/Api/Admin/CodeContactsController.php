<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ContactCollection;

class Coderestaurant_userController extends Controller
{
  public function index(Request $request, Code $code): ContactCollection
  {
    $this->authorize('view', $code);

    $search = $request->get('search', '');

    $restaurant_user = $code
      ->restaurant_user()
      ->search($search)
      ->latest()
      ->paginate();

    return new ContactCollection($restaurant_user);
  }

  public function store(Request $request, Code $code): ContactResource
  {
    $this->authorize('create', RestaurantUser::class);

    $validated = $request->validate([
      'name' => ['required', 'max:255', 'string'],
      'bio' => ['nullable', 'max:255', 'string'],
      'designation' => ['required', 'max:255', 'string'],
      'company' => ['nullable', 'max:255', 'string'],
      'phone' => ['required', 'max:255', 'string'],
      'address' => ['nullable', 'max:255', 'string'],
      'email' => ['required', 'email'],
      'photo' => ['nullable', 'file'],
      'password' => ['required'],
      'is_verified' => ['required', 'boolean'],
    ]);

    $validated['password'] = Hash::make($validated['password']);

    if ($request->hasFile('photo')) {
      $validated['photo'] = $request->file('photo')->store('public');
    }

    $contact = $code->restaurant_user()->create($validated);

    return new ContactResource($contact);
  }
}
