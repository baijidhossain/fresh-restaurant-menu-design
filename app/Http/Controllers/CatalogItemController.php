<?php

namespace App\Http\Controllers;

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
  public function create()
  {

    $action = "add";
    $modal_title = "Add New Menu Item";

    $user = auth()->guard('frontend')->user();

    $restaurant = DB::table("restaurants")->where("restaurant_user_id", $user->id)->first();

    $catalogs = DB::table('catalogs')
      ->where('restaurant_id', $restaurant->id)
      ->orderBy('display_order', 'asc')
      ->get();

    return view('frontend.catalog_item.modal', compact('action', 'modal_title', 'catalogs'));
  }


  public function store(Request $request)
  {
    try {
      // Validate the incoming request data
      $validatedData = $request->validate(
        [
          'catalog_id' => 'required|exists:catalogs,id',
          'name' => 'required|string|max:100',
          'description' => 'required|string|max:150',
          'price' => 'required|numeric|min:0',
          'offer_price' => 'nullable|numeric|min:0',
          'popular' => 'required|boolean',
          'status' => 'required|boolean',
          'display_order' => 'nullable|integer|min:0',
          'custom_field' => 'nullable|string|max:255',
          'product' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:1024', // Validate the product image
        ],
        [
          'product.required' => 'Item image is required',
        ]
      );

      // Handle file upload if a new file is provided
      if ($request->hasFile('product')) {

        // Store new product image
        $productImage = $request->file('product');
        $newFileName = 'goCards_item_' . time() . '.' . $productImage->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());

        // Initialize the Image Manager
        $image = $manager->read($productImage->getRealPath());

        // Resize original image to 1024x768
        if ($image->width() > 1200 || $image->height() > 720) {
          // Resize original image to 1024px width, keeping the aspect ratio and auto-adjusting height
          $image->coverDown(1200, 720);
        }

        // Save the original image
        $originalImagePath = 'restaurant/products/' . $newFileName;
        Storage::disk('public')->put($originalImagePath, (string)$image->encode());

        // Check image dimensions and compress (resize if larger than 150x150)
        if ($image->width() > 150 || $image->height() > 150) {
          $image->coverDown(150, 150);
        }

        // Save the compressed image (thumbnail)
        $thumbnailPath = 'restaurant/products/thumbnails/' . $newFileName;
        Storage::disk('public')->put($thumbnailPath, (string) $image->encode());

        // Store the image filename in the validated data array
        $validatedData['image'] = $newFileName;
      }

      // Create a new catalog item
      CatalogItem::create([
        'catalog_id' => $validatedData['catalog_id'],
        'name' => $validatedData['name'],
        'image' => $validatedData['image'],
        'description' => $validatedData['description'],
        'price' => $validatedData['price'],
        'offer_price' => $validatedData['offer_price'] ?? "0.00",
        'popular' => $validatedData['popular'],
        'status' => $validatedData['status'],
        'display_order' => $validatedData['display_order'] ?? 0,
        'custom_field' => $validatedData['custom_field'] ?? null,
      ]);

      // Redirect back with a success message
      return back()->with('success', 'Catalog item created successfully.');
    } catch (\Exception $e) {
      // Log and handle errors
      Log::error('Error creating catalog item: ' . $e->getMessage());
      return back()->with('error', 'Failed to create catalog item. ' . $e->getMessage());
    }
  }


  public function update(Request $request, $id)
  {
    // Validate request data
    $validatedData = $request->validate([
      'catalog_id' => 'required|exists:catalogs,id',
      'name' => 'required|string|max:100',
      'description' => 'nullable|string|max:150',
      'price' => 'required|numeric',
      'offer_price' => 'nullable|numeric',
      'popular' => 'required|boolean',
      'status' => 'required|boolean',
      'display_order' => 'nullable|integer',
      'custom_field' => 'nullable|string|max:255',
      'product' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
    ]);

    try {
      // Find the catalog item by ID
      $catalogItem = CatalogItem::findOrFail($id);

      // Handle file upload if a new file is provided
      if ($request->hasFile('product')) {
        // Delete the old image if it exists
        if ($catalogItem->image) {
          $oldImagePathThumb = 'restaurant/products/thumbnails/' . $catalogItem->image;
          $oldImagePathOriginal = 'restaurant/products/' . $catalogItem->image;

          // Check and delete old image files if they exist
          if (Storage::disk('public')->exists($oldImagePathThumb)) {
            Storage::disk('public')->delete($oldImagePathThumb);
          }
          if (Storage::disk('public')->exists($oldImagePathOriginal)) {
            Storage::disk('public')->delete($oldImagePathOriginal);
          }
        }

        // Store new product image
        $productImage = $request->file('product');
        $newFileName = 'goCards_item_' . time() . '.' . $productImage->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());
        $image = $manager->read($productImage->getRealPath());

        // Resize original image to 1024x768
        if ($image->width() > 1200 || $image->height() > 720) {
          $image->coverDown(1200, 720);
        }

        // Save the original image
        $originalImagePath = 'restaurant/products/' . $newFileName;
        Storage::disk('public')->put($originalImagePath, (string)$image->encode());

        // Create and save thumbnail (150x150)
        $thumbnail = $image->coverDown(150, 150);

        $thumbnailPath = 'restaurant/products/thumbnails/' . $newFileName;
        Storage::disk('public')->put($thumbnailPath, (string)$thumbnail->encode());

        // Set new image path for saving in the database
        $validatedData['image'] = $newFileName;
      } else {
        // Keep the old image if no new one is uploaded
        $validatedData['image'] = $catalogItem->image;
      }

      // Update the catalog item with validated data
      $catalogItem->update($validatedData);

      return back()->with('success', 'Catalog item updated successfully.');
    } catch (\Exception $e) {
      // Log the error for debugging
      Log::error('Update failed: ' . $e->getMessage());

      return back()->with('error', 'Failed to update catalog item.');
    }
  }

  // public function update(Request $request, $id)
  // {
  //   // Validate request data
  //   $validatedData = $request->validate(
  //     [
  //       'catalog_id' => 'required|exists:catalogs,id',
  //       'name' => 'required|string|max:100',
  //       'description' => 'nullable|string|max:150',
  //       'price' => 'required|numeric',
  //       'offer_price' => 'nullable|numeric',
  //       'popular' => 'required|boolean',
  //       'status' => 'required|boolean',
  //       'display_order' => 'nullable|integer',
  //       'custom_field' => 'nullable|string|max:255',
  //       'product' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
  //     ],
  //   );

  //   try {
  //     // Find the catalog item by ID
  //     $catalogItem = CatalogItem::findOrFail($id);

  //     // Handle file upload if a new file is provided
  //     if ($request->hasFile('product')) {


  //       // Delete the old image if it exists
  //       if ($catalogItem->image) {
  //         $oldImagePath = 'restaurant/products/thumbnails/' . $catalogItem->image;
  //         if (Storage::disk('public')->exists($oldImagePath)) {
  //           Storage::disk('public')->delete($oldImagePath);
  //         }
  //       }
  //       // Handle the product image upload
  //       $productImagePath = $request->file('product');


  //       $newPath = null;

  //       if ($productImagePath) {

  //         $newFileName = 'goCards_item_' . time() . ".png";
  //         $savePath = storage_path('app/public/restaurant/products/' . $newFileName);

  //         $productImagePath->save($savePath);
  //         // Create an ImageManager instance (using the GD driver)
  //         $manager = new ImageManager(new Driver());
  //         // Read the image from the uploaded file
  //         $image = $manager->read($productImagePath->getRealPath());
  //         // Define the file name and path
  //         $savePath = storage_path('app/public/restaurant/products/' . $newFileName);
  //         $image->toPng()->save($savePath, 75);
  //         // Resize the image to 150x150
  //         $image->resize(150, 150, function ($constraint) {
  //           $constraint->aspectRatio(); // Keep aspect ratio
  //           $constraint->upsize();      // Prevent upscaling
  //         });

  //         $savePath = storage_path('app/public/restaurant/products/thumbnails/' . $newFileName);
  //         $image->toPng()->save($savePath, 75);

  //         $newPath = $newFileName;
  //       }
  //     }

  //     $validatedData['image'] = $newPath ?? $catalogItem->image;

  //     // Update the catalog item with validated data
  //     $catalogItem->update($validatedData);

  //     return back()->with('success', 'Catalog item updated successfully.');
  //   } catch (\Exception $e) {
  //     // Log and handle the exception
  //     Log::error('Update failed: ' . $e->getMessage());
  //     return back()->with('error', 'Failed to update catalog item.');
  //   }
  // }

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

  public function edit($id)
  {

    // Check if the ID is empty or not valid
    if (empty($id) || !is_numeric($id)) {
      return back()->with('error', 'Invalid catalog ID.');
    }

    $action = "edit";
    $modal_title = "Edit Menu Item";

    // Retrieve the catalog item from the database
    $catalog_item = DB::table('catalog_items')->where('id', $id)->first();

    $user = auth()->guard('frontend')->user();

    $restaurant = DB::table("restaurants")->where("restaurant_user_id", $user->id)->first();

    $catalogs = DB::table('catalogs')
      ->where('restaurant_id', $restaurant->id)
      ->orderBy('display_order', 'asc')
      ->get();

    // Check if the catalog item exists
    if (!$catalog_item) {
      return back()->with('error', 'Catalog item not found.');
    }



    // Pass the catalog item to the view
    return view('frontend.catalog_item.modal', compact('action', 'modal_title', 'catalogs', 'catalog_item'));
  }
}
