<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{

  public function update(Request $request, $id)
  {


    // Validate the request data
    $request->validate([

      'name' => 'required|max:40',
      'phone' => 'required|max:20',
      'address' => 'required|max:150',
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i',
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
      $logoPath = $restaurant->logo;
      $bannerPath = $restaurant->banner;


      if ($request->hasFile('logo')) {
        // Delete the existing logo file if it exists
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
          Storage::disk('public')->delete($logoPath);
        }
        // Store the new logo
        $logoPath = $request->file('logo')->store('restaurant/logos', 'public');
      }

      if ($request->hasFile('banner')) {
        // Delete the existing banner file if it exists
        if ($bannerPath && Storage::disk('public')->exists($bannerPath)) {
          Storage::disk('public')->delete($bannerPath);
        }
        // Store the new banner
        $bannerPath = $request->file('banner')->store('restaurant/banners', 'public');
      }


      // Banner or logo path from modal
      // if ($request->banner_modal) {
      //   $bannerPath = str_replace('/storage/', '', $request->banner_modal);
      // }

      // if ($request->logo_modal) {
      //   $logoPath = str_replace('/storage/', '', $request->logo_modal);
      // }

      // Update the restaurant details
      DB::table('restaurants')->where('id', $id)->update([
        'name' => $request->input('name'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'start_time' => $request->input('start_time'),
        'end_time' => $request->input('end_time'),
        'logo' => $logoPath,
        'banner' => $bannerPath,
        'updated_at' => now(),
      ]);

      // return back()->with('success', 'General info updated successfully.');

      return back()->with('success', 'Restaurant updated successfully.');
    } catch (\Exception $e) {
      // Log the exception
      Log::error('Error updating restaurant: ' . $e->getMessage());

      return back()->withErrors(['error' => 'An error occurred while updating the general info. Please try again.']);
    }
  }
}
