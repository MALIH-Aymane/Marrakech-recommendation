<?php

namespace App\Http\Controllers;
use App\Models\Attraction;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
   public function index()
{
    $totalAttractions = Attraction::count();

    $totalUsers = User::count();

    $averageRate = round(
        Attraction::whereNotNull('rate')->avg('rate'),
        2
    );

    $photos = Attraction::whereNotNull('photo')->count();

    $reviews = Attraction::whereNotNull('reviews')
                ->where('reviews','!=','Reviews not found')
                ->count();

    $lastAttractions = Attraction::whereNotNull('photo')
                ->latest()
                ->take(5)
                ->get();

    $topAttractions = Attraction::whereNotNull('rate')
                ->orderByDesc('rate')
                ->take(10)
                ->get(['attraction','rate']);

    $ratingDistribution = Attraction::select(
            DB::raw('FLOOR(rate) as rating'),
            DB::raw('COUNT(*) as total')
        )
        ->whereNotNull('rate')
        ->groupBy(DB::raw('FLOOR(rate)'))
        ->orderBy('rating')
        ->get();
        $ratingLabels=$ratingDistribution->pluck('rating');
        $ratingCounts=$ratingDistribution->pluck('total');
        $topNames=$topAttractions->pluck('attraction');
        $topRates=$topAttractions->pluck('rate');

    return view('dashboard', compact(
        'totalAttractions',
        'totalUsers',
        'averageRate',
        'photos',
        'reviews',
        'lastAttractions',
        'topAttractions',
        'ratingDistribution',
        'ratingLabels',
        'ratingCounts',
        'topNames',
        'topRates'
    ));
}
 
}