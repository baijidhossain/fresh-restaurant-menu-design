<?php

namespace App\Http\Controllers\Admin;

use App\Models\Code;
use App\Models\RestaurantUser;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\RestaurantUserStoreRequest;
use App\Http\Requests\Admin\RestaurantUserUpdateRequest;

class RestaurantUserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {

    $this->authorize('view-any', RestaurantUser::class);

    $search = $request->get('search', '');

    $restaurant_user = RestaurantUser::search($search)
      ->latest()
      ->paginate(3)
      ->withQueryString();

    // Calculate serial index for restaurant user
    $restaurant_user->getCollection()->transform(function ($item, $index) use ($restaurant_user) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($restaurant_user->currentPage() - 1) * $restaurant_user->perPage());
      return $item;
    });

    return view('admin.restaurant_user.index', compact('restaurant_user', 'search'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request): View
  {
    $this->authorize('create', RestaurantUser::class);

    $codes = Code::pluck('code', 'id');

    return view('admin.restaurant_user.create', compact('codes'));
  }

  /**
   * Store a newly created resource in storage.
   */

  public function store(RestaurantUserStoreRequest $request): RedirectResponse
  {
    $this->authorize('create', RestaurantUser::class);

    $validated = $request->validated();

    $validated['password'] = Hash::make($validated['password']);

    if ($request->hasFile('photo')) {
      $validated['photo'] = $request->file('photo')->store('public');
    }

    $validated['slug'] = RestaurantUser::generateSlug($validated['name']);

    $restaurant_user = RestaurantUser::create($validated);

    return redirect()
      ->route('restaurant_user.edit', $restaurant_user)
      ->withSuccess(__('crud.common.created'));
  }


  /**
   * Display the specified resource.
   */
  public function show(Request $request, RestaurantUser $restaurant_user): View
  {
    $this->authorize('view', $restaurant_user);

    return view('admin.restaurant_user.show', compact('restaurant_user'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request, RestaurantUser $restaurant_user): View
  {
    $this->authorize('update', $restaurant_user);

    $codes = Code::pluck('code', 'id');

    return view('admin.restaurant_user.edit', compact('restaurant_user', 'codes'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(RestaurantUserUpdateRequest $request, RestaurantUser $restaurant_user): RedirectResponse
  {
    $this->authorize('update', $restaurant_user);

    $validated = $request->validated();

    if (empty($validated['password'])) {
      unset($validated['password']);
    } else {
      $validated['password'] = Hash::make($validated['password']);
    }

    if ($request->hasFile('photo')) {
      if ($restaurant_user->photo) {
        Storage::delete($restaurant_user->photo);
      }

      $validated['photo'] = $request->file('photo')->store('public/restaurant/users');
    }

    $restaurant_user->update($validated);

    return redirect()
      ->route('restaurant_user.edit', $restaurant_user)
      ->withSuccess(__('crud.common.saved'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(
    Request $request,
    RestaurantUser $restaurant_user
  ): RedirectResponse {
    $this->authorize('delete', $restaurant_user);

    if ($restaurant_user->photo) {
      Storage::delete($restaurant_user->photo);
    }

    $restaurant_user->delete();

    return redirect()
      ->route('restaurant_user.index')
      ->withSuccess(__('crud.common.removed'));
  }
}
