<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogController extends Controller
{
  public function create()
  {

    $action = "add";
    $modal_title = "Add New Catalog";

    return view('frontend.catalog.modal', compact('action', 'modal_title'));
  }


  public function store(Request $request)
  {
    // Validate the request data

    $user = auth()->guard('frontend')->user();

    $restaurant = DB::table("restaurants")->where("restaurant_user_id", $user->id)->first();

    $request->validate([
      'name' => 'required|max:80',
      'status' => 'required|boolean',
      'display_order' => 'nullable|integer'
    ]);

    try {
      // Create a new catalog record
      Catalog::create([
        'restaurant_id' => $restaurant->id,
        'name' => $request->input('name'),
        'status' => $request->input('status'),
        'display_order' => $request->input('display_order') ?? 0,
      ]);

      return back()->with('success', 'Catalog created successfully.');
    } catch (\Exception $e) {
      // Log the error details
      Log::error('Error creating catalog: ' . $e->getMessage());

      return back()->withErrors(['error' => 'An error occurred while creating the catalog. Please try again.'])->withInput();
    }
  }

  public function edit($id)
  {
    // Check if the ID is empty or not valid
    if (empty($id) || !is_numeric($id)) {
      return back()->with('error', 'Invalid catalog ID.');
    }

    $action = "edit";
    $modal_title = "Edit Catalog";

    // Retrieve the catalog item from the database
    $catalog = DB::table('catalogs')->where('id', $id)->first();

    // Check if the catalog item exists
    if (!$catalog) {
      return back()->with('error', 'Catalog item not found.');
    }

    // Pass the catalog item to the view
    return view('frontend.catalog.modal', compact('action', 'modal_title', 'catalog'));
  }

  public function update(Request $request, $id)
  {
    // Validate the request data
    $request->validate([
      'name' => 'required|max:80',
      'status' => 'required|boolean',
      'display_order' => 'nullable|integer',
    ]);

    try {
      // Find the catalog and update
      $catalog = Catalog::findOrFail($id);

      $catalog->update([
        'name' => $request->input('name'),
        'status' => $request->input('status'),
        'display_order' => $request->input('display_order') ?? 0,
        'updated_at' => now()
      ]);

      return back()->with('success', 'Catalog updated successfully.');
    } catch (\Exception $e) {
      // Log error details
      Log::error('Error updating catalog: ' . $e->getMessage());

      return back()->withErrors(['error' => 'An error occurred while updating the catalog. Please try again.'])->withInput();
    }
  }

  public function delete($id)
  {
    try {
      // Find the catalog by ID
      $catalog = Catalog::findOrFail($id);

      // Check if any catalog items are associated with this catalog
      $item_exist = DB::table("catalog_items")->where('catalog_id', $catalog->id)->exists();

      if ($item_exist) {
        return redirect()->back()->with('error', 'Catalog is in use and cannot be deleted.');
      }

      // Delete the catalog
      $catalog->delete();

      // Redirect with success message
      return back()->with('success', 'Catalog deleted successfully.');
    } catch (\Exception $e) {
      // Log the error with the catalog ID for better debugging
      Log::error('Error deleting catalog with ID ' . $id . ': ' . $e->getMessage());

      // Redirect with error message
      return redirect()->back()->with(['error' => 'An error occurred while deleting the catalog. Please try again.']);
    }
  }
}
