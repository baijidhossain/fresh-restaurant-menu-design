<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatalogItem;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
          $query->where('catalog_items.name', 'like', "%{$search}%")
            ->orWhere('catalogs.name', 'like', "%{$search}%");
        });
      })
      ->select('catalog_items.*', 'catalogs.name as catalog_name')
      ->orderBy('catalog_items.display_order', 'asc')
      ->orderBy('catalog_items.updated_at', 'desc') // Order by id in descending order
      ->paginate(10); // Change the number of items per page as needed

    // Calculate serial index for catalog items
    $catalog_items->getCollection()->transform(function ($item, $index) use ($catalog_items) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($catalog_items->currentPage() - 1) * $catalog_items->perPage());
      return $item;
    });

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

      $productImagePath = $this->handleFileUpload($request, 'product', 'restaurant/products');

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

      // Handle the product image upload
      $validatedData['image'] = $this->handleFileUpload($request, 'product', 'restaurant/products',  $catalogItem->image);


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

  private function handleFileUpload($request, $fileKey, $storagePath, $existingPath = "")
  {
    // Check if the request contains the file
    if ($request->hasFile($fileKey)) {
      // Delete the old image if it exists
      if ($existingPath) {
        $oldImagePathThumb = $storagePath . '/thumbnails/' . $existingPath;
        $oldImagePathOriginal = $storagePath . '/' . $existingPath;

        // Check and delete old image files if they exist
        if (Storage::disk('public')->exists($oldImagePathThumb)) {
          Storage::disk('public')->delete($oldImagePathThumb);
        }
        if (Storage::disk('public')->exists($oldImagePathOriginal)) {
          Storage::disk('public')->delete($oldImagePathOriginal);
        }
      }

      // Get the uploaded file
      $file = $request->file($fileKey);
      $newFileName = 'goCards_' . $fileKey . '_' . time() . '.' . $file->getClientOriginalExtension();

      // Create an image manager instance and read the uploaded file
      $manager = new ImageManager(new Driver());
      $image = $manager->read($file->getRealPath());

      // Resize the image to 1200x720 if necessary
      // Resize original image to 1024x768
      if ($image->width() > 1200 || $image->height() > 720) {
        $image->coverDown(1200, 720);
      }

      // Save the original image
      $originalImagePath = $storagePath . '/' . $newFileName;
      Storage::disk('public')->put($originalImagePath, (string) $image->encode());

      // Create and save thumbnail (150x150)
      $thumbnail = $image->coverDown(150, 150);

      $thumbnailPath = $storagePath . '/thumbnails/' . $newFileName;
      Storage::disk('public')->put($thumbnailPath, (string) $thumbnail->encode());

      // Return the new file name
      return $newFileName;
    }

    // Return the existing file name if no new file is uploaded
    return $existingPath;
  }
}
