<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RestaurantController extends Controller
{

  public function update(Request $request, $id)
  {
    // Validate the request data
    $validatedData = $request->validate([
      'name' => 'required|max:40',
      'phone' => 'required|max:20',
      'address' => 'required|max:150',
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
      'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
    ]);

    try {
      $restaurant = Restaurant::findOrFail($id);

      $manager = new ImageManager(new Driver());

      // Handle logo upload
      if ($request->hasFile('logo')) {

        if ($restaurant->logo) {
          $oldLogoPath = 'restaurant/logos/' . $restaurant->logo;
          if (Storage::disk('public')->exists($oldLogoPath)) {
            Storage::disk('public')->delete($oldLogoPath);
          }
        }

        $logoImage = $request->file('logo');

        $newLogoFileName = 'goCards_logo_' . time() . '.' . $logoImage->getClientOriginalExtension();

        $image = $manager->read($logoImage->getRealPath());

        if ($image->width() > 150 || $image->height() > 150) {
          $image->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
        }

        Storage::disk('public')->put('restaurant/logos/' . $newLogoFileName, (string)$image->encode());

        $validatedData['logo'] = $newLogoFileName;
      }

      // Handle banner upload
      if ($request->hasFile('banner')) {
        if ($restaurant->banner) {
          $oldBannerPath = 'restaurant/banners/' . $restaurant->banner;
          if (Storage::disk('public')->exists($oldBannerPath)) {
            Storage::disk('public')->delete($oldBannerPath);
          }
        }

        $bannerImage = $request->file('banner');
        $newBannerFileName = 'goCards_banner_' . time() . '.' . $bannerImage->getClientOriginalExtension();

        $image = $manager->read($bannerImage->getRealPath());

        if ($image->width() > 870 || $image->height() > 450) {
          $image->resize(870, 450, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
        }

        Storage::disk('public')->put('restaurant/banners/' . $newBannerFileName, (string)$image->encode());

        $validatedData['banner'] = $newBannerFileName;
      }

      // Update restaurant details in the database
      $restaurant->update($validatedData);

      return back()->with('success', 'Restaurant updated successfully.');
    } catch (\Exception $e) {
      Log::error('Error updating restaurant: ' . $e->getMessage());
      return back()->withErrors(['error' => 'An error occurred while updating the general info. Please try again.']);
    }
  }











  // public function update(Request $request, $id)
  // {


  //   // Validate the request data
  //   $request->validate([

  //     'name' => 'required|max:40',
  //     'phone' => 'required|max:20',
  //     'address' => 'required|max:150',
  //     'start_time' => 'required|date_format:H:i',
  //     'end_time' => 'required|date_format:H:i',
  //     'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
  //     'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',

  //   ]);

  //   try {
  //     // Find the restaurant by ID
  //     $restaurant = DB::table('restaurants')->where('id', $id)->first();

  //     if (!$restaurant) {
  //       return redirect()->route('restaurant.index')->withErrors(['error' => 'Restaurant not found.']);
  //     }

  //     // Handle file uploads
  //     $logoPath = $restaurant->logo;
  //     $bannerPath = $restaurant->banner;


  //     if ($request->hasFile('logo')) {
  //       // Delete the existing logo file if it exists
  //       if ($logoPath && Storage::disk('public')->exists($logoPath)) {
  //         Storage::disk('public')->delete($logoPath);
  //       }
  //       // Store the new logo
  //       $logoPath = $request->file('logo')->store('restaurant/logos', 'public');
  //     }

  //     if ($request->hasFile('banner')) {
  //       // Delete the existing banner file if it exists
  //       if ($bannerPath && Storage::disk('public')->exists($bannerPath)) {
  //         Storage::disk('public')->delete($bannerPath);
  //       }
  //       // Store the new banner
  //       $bannerPath = $request->file('banner')->store('restaurant/banners', 'public');
  //     }


  //     // Update the restaurant details
  //     DB::table('restaurants')->where('id', $id)->update([
  //       'name' => $request->input('name'),
  //       'phone' => $request->input('phone'),
  //       'address' => $request->input('address'),
  //       'start_time' => $request->input('start_time'),
  //       'end_time' => $request->input('end_time'),
  //       'logo' => $logoPath,
  //       'banner' => $bannerPath,
  //       'updated_at' => now(),
  //     ]);

  //     // return back()->with('success', 'General info updated successfully.');

  //     return back()->with('success', 'Restaurant updated successfully.');
  //   } catch (\Exception $e) {
  //     // Log the exception
  //     Log::error('Error updating restaurant: ' . $e->getMessage());

  //     return back()->withErrors(['error' => 'An error occurred while updating the general info. Please try again.']);
  //   }
  // }
}
