<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ContactCollection;
use App\Http\Requests\Admin\restaurant_usertoreRequest;
use App\Http\Requests\Admin\ContactUpdateRequest;

class ContactController extends Controller
{
  public function index(Request $request): ContactCollection
  {
    $this->authorize('view-any', RestaurantUser::class);

    $search = $request->get('search', '');

    $restaurant_user = RestaurantUser::search($search)
      ->latest()
      ->paginate();

    return new ContactCollection($restaurant_user);
  }

  public function store(restaurant_usertoreRequest $request): ContactResource
  {
    $this->authorize('create', RestaurantUser::class);

    $validated = $request->validated();

    $validated['password'] = Hash::make($validated['password']);

    if ($request->hasFile('photo')) {
      $validated['photo'] = $request->file('photo')->store('public');
    }

    $contact = RestaurantUser::create($validated);

    return new ContactResource($contact);
  }

  public function show(Request $request, Contact $contact): ContactResource
  {
    $this->authorize('view', $contact);

    return new ContactResource($contact);
  }

  public function update(
    ContactUpdateRequest $request,
    Contact $contact
  ): ContactResource {
    $this->authorize('update', $contact);

    $validated = $request->validated();

    if (empty($validated['password'])) {
      unset($validated['password']);
    } else {
      $validated['password'] = Hash::make($validated['password']);
    }

    if ($request->hasFile('photo')) {
      if ($contact->photo) {
        Storage::delete($contact->photo);
      }

      $validated['photo'] = $request->file('photo')->store('public');
    }

    $contact->update($validated);

    return new ContactResource($contact);
  }

  public function destroy(Request $request, Contact $contact): Response
  {
    $this->authorize('delete', $contact);

    if ($contact->photo) {
      Storage::delete($contact->photo);
    }

    $contact->delete();

    return response()->noContent();
  }
}
