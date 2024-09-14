<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Restaurant;

class CatalogController extends Controller
{
  public function index(Request $request)
  {
    // Retrieve the search term from the request
    $search = $request->input('search');

    $catalogs = Catalog::join('restaurants', 'catalogs.restaurant_id', '=', 'restaurants.id')
      ->when($search, function ($query, $search) {
        return $query->where('catalogs.name', 'like', "%{$search}%");
      })
      ->select('catalogs.*', 'restaurants.name as restaurant_name') // Select fields from both tables
      ->paginate(10); // Adjust the number of items per page as needed

    // Calculate serial index for catalogs
    $catalogs->getCollection()->transform(function ($item, $index) use ($catalogs) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($catalogs->currentPage() - 1) * $catalogs->perPage());
      return $item;
    });


    return view('admin.catalog.index', compact('catalogs', 'search'));
  }

  public function create()
  {
    $restaurants  = Restaurant::all();
    return view('admin.catalog.create', compact('restaurants'));
  }

  public function store(Request $request)
  {
    // Validate the request data
    $request->validate([
      'name' => 'required|max:80',
      'restaurant' => 'required',
      'status' => 'required',
    ]);

    try {
      // Create a new catalog record
      Catalog::create([
        'restaurant_id' => $request->input('restaurant'),
        'name' => $request->input('name'),
        'status' => $request->input('status'),
      ]);

      return redirect()->route('catalog.index')->with('success', 'Catalog created successfully.');
    } catch (\Exception $e) {
      // Log the error details
      Log::error('Error creating catalog: ' . $e->getMessage());

      return redirect()->back()->withErrors(['error' => 'An error occurred while creating the catalog. Please try again.'])->withInput();
    }
  }

  public function edit($id)
  {
    // Retrieve the restaurant by ID
    $catalog = DB::table('catalogs')->where('id', $id)->first();

    $restaurants  = Restaurant::all();

    if (!$catalog) {
      return redirect()->route('catalog.index')->withErrors(['error' => 'Restaurant not found.']);
    }
    // Pass the restaurant data to the view
    return view('admin.catalog.edit', compact('catalog', 'restaurants'));
  }

  public function update(Request $request, $id)
  {
    // Validate the request data
    $request->validate([
      'name' => 'required|max:80',
      'restaurant' => 'required|exists:restaurants,id',
      'display_order' => 'required|integer',
    ]);

    try {
      // Find the catalog and update
      $catalog = Catalog::findOrFail($id);
      $catalog->update([
        'restaurant_id' => $request->input('restaurant'),
        'name' => $request->input('name'),
        'display_order' => $request->input('display_order'),
      ]);

      return redirect()->route('catalog.index')->with('success', 'Catalog updated successfully.');
    } catch (\Exception $e) {
      // Log error details
      Log::error('Error updating catalog: ' . $e->getMessage());

      return redirect()->back()->withErrors(['error' => 'An error occurred while updating the catalog. Please try again.'])->withInput();
    }
  }

  public function delete($id)
  {
    try {
      // Find the catalog by ID
      $catalog = Catalog::findOrFail($id);

      // Delete the catalog
      $catalog->delete();

      // Redirect with success message
      return back()->with('success', 'Catalog deleted successfully.');
    } catch (\Exception $e) {
      // Log the error
      Log::error('Error deleting catalog: ' . $e->getMessage());

      // Redirect with error message
      return back()->withErrors(['error' => 'An error occurred while deleting the catalog. Please try again.']);
    }
  }
}
