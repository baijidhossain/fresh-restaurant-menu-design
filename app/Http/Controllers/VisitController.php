<?php

namespace App\Http\Controllers;


use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
  public function getTodaysVisitors()
  {
    $today = Carbon::today();
    $contactId = Auth::user()->id;

    $todaysVisitors = Visit::where('restaurant_user_id', $contactId)
      ->whereDate('created_at', $today)
      ->count();

    return $todaysVisitors;
  }

  public function getTotalVisits()
  {
    $contactId = Auth::user()->id;

    $totalVisits = Visit::where('restaurant_user_id', $contactId)->count();

    return $totalVisits;
  }

  public function getUniqueVisits()
  {
    $contactId = Auth::user()->id;

    $uniqueVisits = Visit::where('restaurant_user_id', $contactId)
      ->distinct('ip_address')
      ->count('ip_address');

    return $uniqueVisits;
  }

  public function getLastVisit()
  {
    $contactId = Auth::user()->id;

    $lastVisit = Visit::where('restaurant_user_id', $contactId)
      ->orderBy('created_at', 'desc')
      ->first();

    return $lastVisit ? $lastVisit->created_at : null;
  }

  public function lastSevenDaysVisits()
  {
    $contactId = Auth::user()->id;

    // Calculate date range
    $startDate = Carbon::today()->subDays(6); // 7 days ago
    $endDate = Carbon::today(); // Today

    // Fetch visits data from database
    $visits = Visit::where('restaurant_user_id', $contactId)
      ->whereDate('created_at', '>=', $startDate)
      ->whereDate('created_at', '<=', $endDate)
      ->select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('COUNT(*) as total_visits')
      )
      ->groupBy('date')
      ->orderBy('date')
      ->get();

    // Prepare response array with all seven days
    $response = [];
    $date = clone $startDate;

    // Initialize an associative array to map dates to visit counts
    $visitsByDate = [];
    foreach ($visits as $visit) {
      $visitsByDate[$visit->date] = $visit->total_visits;
    }

    // Loop through each day in the date range and populate response
    while ($date <= $endDate) {
      $formattedDate = $date->format('Y-m-d');
      $totalVisits = isset($visitsByDate[$formattedDate]) ? $visitsByDate[$formattedDate] : 0;

      $response[] = [
        'date' => $formattedDate,
        'total_visits' => $totalVisits,
      ];

      // Move to the next day
      $date->addDay();
    }

    return $response;
  }


  public function getOsUsage()
  {
    $contactId = Auth::user()->id;

    $osUsage = Visit::where('restaurant_user_id', $contactId)
      ->select(
        'os',
        DB::raw('COUNT(*) as visit_count')
      )
      ->groupBy('os')
      ->get();

    return $osUsage;
  }
}
