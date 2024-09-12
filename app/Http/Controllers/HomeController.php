<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RestaurantUser;
use Illuminate\Support\Facades\Http;
use App\Models\Code;
use App\Models\Restaurant;
use App\Models\Catalog;
use App\Models\CatalogItem;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
  public function scan(Request $request)
  {
    $code = Code::where('code', $request->code)->firstOrFail();

    $contact = RestaurantUser::where('code_id', $code->id);

    //if code has client related
    if ($contact->exists()) {
      return redirect()->route('profile', ['user' => $contact->first()->slug]);
    } else {
      return redirect()->route('register', $code->code);
    }
  }

  public function profile(Request $request, $slug)
  {

    // Fetch restaurant user
    $restaurant_user = RestaurantUser::where('slug', $slug)->firstOrFail();

    // Log visit
    $agent = new Agent();

    Visit::create([
      'ip_address' => $request->ip(),
      'user_agent' => $request->userAgent(),
      'device_type' => $agent->device(),
      'browser' => $agent->browser(),
      'os' => $agent->platform(),
      'restaurant_user_id' => $restaurant_user->id,
    ]);

    // Fetch restaurant associated with the user
    $restaurant = Restaurant::where('restaurant_user_id', $restaurant_user->id)->firstOrFail();

    // Fetch catalogs
    $catalogs = Catalog::where('restaurant_id', $restaurant->id)
      ->orderBy('catalogs.display_order', 'asc')
      ->orderBy('catalogs.created_at', 'desc')
      ->orderBy('catalogs.updated_at', 'desc')
      ->get();

    // Return view with data
    return view('profile', [
      'user' => $restaurant_user,
      'restaurant' => $restaurant,
      'catalogs' => $catalogs,
      'restaurant_user' => $restaurant_user,

    ]);
  }


  public function passwordChange(Request $request)
  {
    // Validate the request
    $validatedData = $request->validate([
      'new_password' => 'nullable|string|min:8|confirmed',
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
    ]);

    try {
      // Get the currently authenticated user
      $user = auth()->guard('frontend')->user(); // Use Auth::user() if you are using Laravel's built-in authentication

      // Update the user's password if a new one is provided
      if (!empty($validatedData['new_password'])) {
        $user->password = Hash::make($validatedData['new_password']);
      }

      // Update the user's name and email
      $user->name = $validatedData['name'];
      $user->email = $validatedData['email'];

      $user->save();

      return back()->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
      // Log and handle the exception
      Log::error('Profile update failed: ' . $e->getMessage());
      return back()->with('error', 'Failed to update profile.');
    }
  }

  public function edit(Request $request)
  {

    $user = auth()->guard('frontend')->user();

    $restaurant = DB::table("restaurants")->where("restaurant_user_id", $user->id)->first() ?? [];

    $restaurant_user = $user;

    // Retrieve the current page for catalogs and catalog items from the query parameters
    $catalogPage = $request->input('catalog_page', 1); // Default to page 1 if not specified
    $itemPage = $request->input('item_page', 1); // Default to page 1 if not specified

    // Retrieve the catalogs for the restaurant with pagination

    // Fetch paginated catalogs
    $catalogs = DB::table('catalogs')
      ->leftJoin('catalog_items', 'catalogs.id', '=', 'catalog_items.catalog_id')
      ->where('catalogs.restaurant_id', $restaurant->id)
      ->groupBy('catalogs.id', 'catalogs.name', 'catalogs.display_order', 'catalogs.restaurant_id', 'catalogs.status', 'catalogs.created_at', 'catalogs.updated_at') // Group by the columns in the SELECT clause
      ->select('catalogs.*', DB::raw('COUNT(catalog_items.id) as item_count')) // Count the number of items per catalog
      ->orderBy('catalogs.display_order', 'asc') // Orders by display_order in ascending order
      ->orderBy('catalogs.created_at', 'desc') // Then orders by created_at in ascending order
      ->paginate(8, ['*'], 'catalog_page', $catalogPage);


    // Calculate serial index for catalogs
    $catalogs->getCollection()->transform(function ($item, $index) use ($catalogs) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($catalogs->currentPage() - 1) * $catalogs->perPage());
      return $item;
    });

    // Fetch paginated catalog items
    $catalog_items = DB::table('catalog_items')
      ->join('catalogs', 'catalog_items.catalog_id', '=', 'catalogs.id')
      ->where('catalogs.restaurant_id', $restaurant->id)
      ->select('catalog_items.*', 'catalogs.name as catalog_name')
      ->orderBy('catalog_items.display_order', 'asc') // Orders by display_order in ascending order
      ->orderBy('catalog_items.created_at', 'desc') // Then orders by created_at in ascending order
      ->paginate(8, ['*'], 'item_page', $itemPage);

    // Calculate serial index for catalog items
    $catalog_items->getCollection()->transform(function ($item, $index) use ($catalog_items) {
      // Calculate serial index for paginated results
      $item->serial_index = $index + 1 + (($catalog_items->currentPage() - 1) * $catalog_items->perPage());
      return $item;
    });

    return view('update', ['user' => $user, 'restaurant' => $restaurant, 'catalogs' => $catalogs, 'catalog_items' => $catalog_items, 'restaurant_user' => $restaurant_user]);
  }

  public function contact($slug)
  {
    $user = RestaurantUser::where('slug', $slug)->firstOrFail();

    $restaurant = Restaurant::where('restaurant_user_id', $user->id)->first();

    //generate vcf
    $vcf = $this->generateVCard($user, $restaurant);
    return response($vcf)->header('Content-Type', 'text/vcard');
  }

  public function generateVCard($user, $restaurant)
  {

    //current host + /profile/slug

    $userWebsite = request()->getSchemeAndHttpHost() . '/' . $user['slug'];

    $vCard = "BEGIN:VCARD\n";
    $vCard .= "VERSION:3.0\n";
    $vCard .= "N:" . $restaurant['name'] . "\n";
    $vCard .= "FN:" . $restaurant['name'] . "\n";
    $vCard .= "TEL;TYPE=WORK,VOICE:" . $restaurant['phone']  . "\n";
    $vCard .= "URL:" . $userWebsite . "\n";
    $vCard .= "ADR;TYPE=WORK:;;" . $restaurant['address']  . ";;;;" . "\n";

    // Append notes if available
    if (!empty($user['notes'])) {
      foreach ($user['notes'] as $note) {
        $vCard .= "NOTE:" . $note['property'] . ' : ' . $note['asset'] . "\n";
      }
    }

    $vCard .= "END:VCARD";

    return $vCard;
  }


  public function update(Request $request)
  {


    $user = auth()->guard('frontend')->user();

    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email',
      'phone' => 'required',
    ]);

    $data = [
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'designation' => $request->designation,
      'company' => $request->company,
      'address' => $request->address,
      'bio' => $request->bio,
    ];

    if ($request->hasFile('photo')) {
      $data['photo'] = $request->file('photo')->store('public');
    }

    $user->update($data);

    $user->socialLinks()->delete();

    $user->notes()->delete();

    $request->key && $request->value && $user->socialLinks()->each(function ($link) use ($request) {

      $link->update([
        'key' => $request->key[$link->key] ?? $link->key,
        'value' => $request->value[$link->key] ?? $link->value,
      ]);
    });

    $request->property && $request->asset && $user->notes()->each(function ($property) use ($request) {

      $property->update([
        'property' => $request->property[$link->property] ?? $link->property,
        'asset' => $request->asset[$link->asset] ?? $link->asset,
      ]);
    });

    foreach ($request->key ?? [] as $key => $value) {
      $user->socialLinks()->create([
        'key' => $request->key[$key],
        'value' => $request->value[$key],
      ]);
    }

    foreach ($request->property ?? [] as $key => $value) {
      $user->notes()->create([
        'property' => $request->property[$key],
        'asset' => $request->asset[$key],
      ]);
    }

    return redirect()->route('account.edit')->withSuccess("Profile updated");
  }

  public function statistics()
  {

    $visitor = new VisitController();

    // counts
    $todaysVisitors = $this->formatNumber($visitor->getTodaysVisitors());

    $totalVisits    = $this->formatNumber($visitor->getTotalVisits());

    $uniqueVisits   = $this->formatNumber($visitor->getUniqueVisits());

    // info
    $lastVisit = $visitor->getLastVisit();

    // auth creted at
    $created = auth()->guard('frontend')->user()->created_at;

    // chars
    $visit = $visitor->lastSevenDaysVisits();

    $usage = $visitor->getOsUsage();

    return view('statistics', compact('todaysVisitors', 'totalVisits', 'uniqueVisits', 'lastVisit', 'created', 'visit', 'usage'));
  }

  public function search(Request $request)
  {
    $query = $request->get('query');

    $slug = $request->get('slug');

    $user = RestaurantUser::where('slug', $slug)->firstOrFail();

    $restaurant = DB::table("restaurants")->where("restaurant_user_id", $user->id)->first() ?? [];

    $items = DB::table('catalogs')
      ->join('catalog_items', 'catalogs.id', '=', 'catalog_items.catalog_id')
      ->where('catalogs.restaurant_id', $restaurant->id)
      ->where('catalog_items.name', 'like', "%$query%")
      ->orderBy('catalog_items.display_order', 'asc')
      ->select('catalog_items.*', 'catalogs.name as catalog_name')
      ->get();

    // Return a view with the search results
    return view('frontend.catalog_item.search', compact('items'));
  }

  public function getItems(Request $request)
  {
    $catalog = $request->get('catalog');
    $slug = $request->get('slug');

    // Fetch the user by slug
    $user = RestaurantUser::where('slug', $slug)->firstOrFail();

    // Fetch the restaurant associated with the user
    $restaurant = DB::table("restaurants")->where("restaurant_user_id", $user->id)->first();

    if (!$restaurant) {
      return response()->json(['message' => 'Restaurant not found'], 404);
    }

    // Build the base query
    $items = DB::table('catalogs')
      ->join('catalog_items', 'catalogs.id', '=', 'catalog_items.catalog_id')
      ->where('catalogs.restaurant_id', $restaurant->id);

    // Apply filters based on the catalog type
    if ($catalog == "popular") {
      $items->where('catalog_items.popular', 1);
    } elseif ($catalog == "offer") {
      $items->where('catalog_items.offer_price', '>', 0);
    } else {
      $items->where('catalogs.id', $catalog);
    }

    // Apply sorting and fetch results
    $items = $items->orderBy('catalog_items.display_order', 'asc')
      ->orderBy('catalog_items.created_at', 'desc')
      ->orderBy('catalog_items.updated_at', 'desc')
      ->select('catalog_items.*', 'catalogs.name as catalog_name')
      ->get();

    // Return the view with the results
    return view('frontend.catalog_item.search', compact('items'));
  }



  private function formatNumber($number)
  {
    if ($number >= 1000000000) {
      return number_format($number / 1000000000, 1) . 'B';
    } elseif ($number >= 1000000) {
      return number_format($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
      return number_format($number / 1000, 1) . 'K';
    } else {
      return (string)$number;
    }
  }
}
