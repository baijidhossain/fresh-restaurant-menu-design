<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class RestaurantController extends Controller
{
  public function index(Request $request)
  {
    // Retrieve the search term from the request
    $search = $request->input('search');

    // Query the Restaurant model with a condition
    $restaurants = Restaurant::when($search, function ($query, $search) {
      return $query->where('name', 'like', "%{$search}%")
        ->orWhere('address', 'like', "%{$search}%");
    })->paginate(10);

    // Calculate serial index for restaurant
    $restaurants->getCollection()->transform(function ($item, $index) use ($restaurants) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($restaurants->currentPage() - 1) * $restaurants->perPage());
      return $item;
    });

    return view('admin.restaurant.index', compact('restaurants'));
  }

  public function create()
  {
    $restaurant_users  = RestaurantUser::all();
    return view('admin.restaurant.create', compact('restaurant_users'));
  }

  public function store(Request $request)
  {
    // Validate the request data
    $request->validate([
      'restaurant_user' => 'required|unique:restaurants,restaurant_user_id',
      'name' => 'required|max:100',
      'phone' => 'nullable|max:20',
      'address' => 'nullable|max:150',
      'start_time' => 'nullable|date_format:H:i',
      'end_time' => 'nullable|date_format:H:i',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
      'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
    ]);

    try {
      // Handle file uploads for logo and banner
      $logoPath = $this->handleFileUpload($request, 'logo', 'restaurant/logos');
      $bannerPath = $this->handleFileUpload($request, 'banner', 'restaurant/banners');

      // Insert new restaurant into the database
      DB::table('restaurants')->insert([
        'restaurant_user_id' => $request->input('restaurant_user'),
        'name' => $request->input('name'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'start_time' => $request->input('start_time'),
        'end_time' => $request->input('end_time'),
        'logo' => $logoPath,
        'banner' => $bannerPath,
      ]);

      return redirect()->route('restaurant.index')->with('success', 'Restaurant created successfully.');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => 'An error occurred while creating the restaurant. Please try again.'])->withInput();
    }
  }

  public function edit($id)
  {
    // Retrieve the restaurant by ID
    $restaurant = DB::table('restaurants')->where('id', $id)->first();

    $restaurant_users  = RestaurantUser::all();

    if (!$restaurant) {
      return redirect()->route('restaurant.index')->withErrors(['error' => 'Restaurant not found.']);
    }

    // Pass the restaurant data to the view
    return view('admin.restaurant.edit', compact('restaurant', 'restaurant_users'));
  }

  public function update(Request $request, $id)
  {
    // Validate the request data
    $request->validate([

      'restaurant_user' => 'required',
      'name' => 'required|max:40',
      'phone' => 'required|max:20',
      'address' => 'required|max:150',
      'start_time' => 'nullable|date_format:H:i',
      'end_time' => 'nullable|date_format:H:i',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
      'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',

    ]);

    try {
      // Find the restaurant by ID
      $restaurant = DB::table('restaurants')->where('id', $id)->first();

      if (!$restaurant) {
        return redirect()->route('restaurant.index')->withErrors(['error' => 'Restaurant not found.']);
      }

      // Handle file uploads
      $logoExistingPath = $restaurant->logo;
      $bannerExistingPath = $restaurant->banner;

      // Handle file uploads for logo and banner
      $logoPath = $this->handleFileUpload($request, 'logo', 'restaurant/logos') ??  $logoExistingPath;
      $bannerPath = $this->handleFileUpload($request, 'banner', 'restaurant/banners') ??  $bannerExistingPath;

      // Update the restaurant details
      DB::table('restaurants')->where('id', $id)->update([
        'restaurant_user_id' =>  $request->input('restaurant_user'),
        'name' => $request->input('name'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'start_time' => $request->input('start_time'),
        'end_time' => $request->input('end_time'),
        'logo' => $logoPath,
        'banner' => $bannerPath,
        'updated_at' => now(),
      ]);

      return redirect()->route('restaurant.index')->with('success', 'Restaurant updated successfully.');
    } catch (\Exception $e) {
      // Log the exception
      Log::error('Error updating restaurant: ' . $e->getMessage());

      return redirect()->back()->withErrors(['error' => 'An error occurred while updating the restaurant. Please try again.']);
    }
  }

  public function view(Request $request, $id)
  {

    if (!$id) {
      return redirect()->route('admin.restaurants.index')->with('error', 'Invalid restaurant id');
    }

    // Retrieve the restaurant by ID
    $restaurant = DB::table('restaurants')->where('id', $id)->first();

    // Check if the restaurant is not found
    if (!$restaurant) {
      return redirect()->route('admin.restaurants.index')->with('error', 'Restaurant not found.');
    }

    // Retrieve the current page for catalogs and catalog items from the query parameters
    $catalogPage = $request->input('catalog_page', 1); // Default to page 1 if not specified
    $itemPage = $request->input('item_page', 1); // Default to page 1 if not specified

    // Retrieve the catalogs for the restaurant with pagination
    $catalogs = DB::table('catalogs')
      ->where('restaurant_id', $restaurant->id)
      ->paginate(10, ['*'], 'catalog_page', $catalogPage); // Use 'catalog_page' for pagination

    // Calculate serial index for restaurant
    $catalogs->getCollection()->transform(function ($item, $index) use ($catalogs) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($catalogs->currentPage() - 1) * $catalogs->perPage());
      return $item;
    });

    // Retrieve the catalog items for the restaurant with pagination
    $catalog_items = DB::table('catalog_items')
      ->join('catalogs', 'catalog_items.catalog_id', '=', 'catalogs.id')
      ->where('catalogs.restaurant_id', $restaurant->id)
      ->select('catalog_items.*', 'catalogs.name as catalog_name')
      ->paginate(10, ['*'], 'item_page', $itemPage); // Use 'item_page' for pagination

    // Calculate serial index for restaurant
    $catalog_items->getCollection()->transform(function ($item, $index) use ($catalog_items) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($catalog_items->currentPage() - 1) * $catalog_items->perPage());
      return $item;
    });

    // Return the view with the restaurant, catalogs, and catalog items data
    return view('admin.restaurant.view', compact('restaurant', 'catalogs', 'catalog_items'));
  }

  public function delete($id)
  {
    try {
      // Find the restaurant by ID
      $restaurant = DB::table('restaurants')->where('id', $id)->first();

      if (!$restaurant) {
        return back()->withErrors(['error' => 'Restaurant not found.']);
      }

      // Delete the restaurant
      $deleted = DB::table('restaurants')->where('id', $id)->delete();

      if ($deleted) {
        // Delete related files if they exist
        if ($restaurant->logo && Storage::disk('public')->exists($restaurant->logo)) {
          Storage::disk('public')->delete($restaurant->logo);
        }
        if ($restaurant->banner && Storage::disk('public')->exists($restaurant->banner)) {
          Storage::disk('public')->delete($restaurant->banner);
        }

        return redirect()->route('restaurant.index')->with('success', 'Restaurant deleted successfully.');
      }

      return redirect()->route('restaurant.index')->withErrors(['error' => 'Failed to delete the restaurant.']);
    } catch (\Exception $e) {

      return redirect()->route('restaurant.index')->withErrors(['error' => 'An error occurred while deleting the restaurant. Please try again.']);
    }
  }

  private function handleFileUpload($request, $fileKey, $storagePath)
  {
    if ($request->hasFile($fileKey)) {
      // Get the uploaded file and generate a new file name
      $file = $request->file($fileKey);
      $newFileName = 'goCards_' . $fileKey . '_' . time() . '.' . $file->getClientOriginalExtension();

      // Define the upload path inside storage
      $uploadPath = storage_path('app/public/' . $storagePath);

      // Move the file to the storage path
      $file->move($uploadPath, $newFileName);

      // Return the new file path
      return $newFileName;
    }

    return null;
  }
}
