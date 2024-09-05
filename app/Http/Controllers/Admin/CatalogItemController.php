<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatalogItem;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogItemController extends Controller
{
  public function index(Request $request)
  {
    // Retrieve the search term from the request
    $search = $request->input('search');

    // Query the Restaurant model with a condition
    $catalog_items = CatalogItem::join('catalogs', 'catalog_items.catalog_id', '=', 'catalogs.id')
      ->when($search, function ($query, $search) {
        return $query->where(function ($query) use ($search) {
          $query->where('catalog_items.item_name', 'like', "%{$search}%")
            ->orWhere('catalogs.name', 'like', "%{$search}%");
        });
      })
      ->select('catalog_items.*', 'catalogs.name as catalog_name')
      ->orderBy('catalog_items.id', 'desc') // Order by id in descending order
      ->paginate(10); // Change the number of items per page as needed


    return view('admin.catalog_item.index', compact('catalog_items', 'search'));
  }

  public function create()
  {
    $catalogs  = Catalog::all();
    return view('admin.catalog_item.create', compact('catalogs'));
  }

  public function store(Request $request)
  {
    try {
      // Validate the incoming request data
      $validatedData = $request->validate([
        'catalog_id' => 'required|exists:catalogs,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'offer_price' => 'nullable|numeric|min:0',
        'popular' => 'required|boolean',
        'status' => 'required|boolean',
        'display_order' => 'required|integer|min:1',
        'product' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the product image
      ]);

      // Handle the product image upload
      $productImagePath = $request->file('image')
        ? $request->file('image')->store('restaurant/product', 'public')
        : null;



      // Create a new catalog item
      CatalogItem::create([
        'catalog_id' => $validatedData['catalog_id'],
        'name' => $validatedData['name'],
        'image' => $productImagePath,
        'description' => $validatedData['description'],
        'price' => $validatedData['price'],
        'offer_price' => $validatedData['offer_price'],
        'popular' => $validatedData['popular'],
        'status' => $validatedData['status'],
        'display_order' => $validatedData['display_order'],
      ]);

      // Redirect back with a success message
      return redirect()->route('catalog.item.index')->with('success', 'Catalog item created successfully.');
    } catch (\Exception $e) {
      // Log the error for debugging
      Log::error('Error creating catalog item: ' . $e->getMessage());

      // Redirect back with an error message
      return redirect()->back()->with('error', 'An error occurred while creating the catalog item. Please try again.');
    }
  }


  public function edit($id)
  {
    // Retrieve the restaurant by ID
    $catalog_item = DB::table('catalog_items')->where('id', $id)->first();

    $catalogs  = Catalog::all();

    if (!$catalog_item) {
      return redirect()->route('catalog.index')->withErrors(['error' => 'Restaurant not found.']);
    }
    // Pass the restaurant data to the view
    return view('admin.catalog_item.edit', compact('catalogs', 'catalog_item'));
  }

  public function update(Request $request, $id)
  {
    $validatedData = $request->validate([
      'catalog_id' => 'required|exists:catalogs,id',
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'price' => 'required|numeric',
      'offer_price' => 'nullable|numeric',
      'popular' => 'required|boolean',
      'status' => 'required|boolean',
      'display_order' => 'required|integer',
    ]);

    try {
      $catalogItem = CatalogItem::findOrFail($id);
      $catalogItem->update($validatedData);

      return redirect()->route('catalog.item.index')->with('success', 'Catalog item updated successfully.');
    } catch (\Exception $e) {
      // Optionally log the exception
      Log::error('Update failed: ' . $e->getMessage());

      return redirect()->route('catalog.item.index')->with('error', 'Failed to update catalog item.');
    }
  }

  // CatalogItemController.php
  public function delete($id)
  {
    try {
      $catalogItem = CatalogItem::findOrFail($id);
      $catalogItem->delete();

      return back()->with('success', 'Catalog item deleted successfully.');
    } catch (\Exception $e) {
      // Optionally log the exception
      Log::error('Delete failed: ' . $e->getMessage());

      return back()->with('error', 'Failed to delete catalog item.');
    }
  }
}
