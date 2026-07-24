<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Review;
use App\Models\ReviewReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Attraction $attraction)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = new Review();
        $review->attraction_id = $attraction->id;
        $review->user_id = Auth::id();
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        return back()->with('success', __('attractions.review_added'));
    }

    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $reply = new Review();
        $reply->attraction_id = $review->attraction_id;
        $reply->user_id = Auth::id();
        $reply->parent_id = $review->id;
        $reply->comment = $validated['comment'];
        $reply->save();

        return back()->with('success', __('attractions.reply_added'));
    }

    public function react(Request $request, Review $review)
    {
        $user = Auth::user();
        
        $reaction = ReviewReaction::where('review_id', $review->id)
                                  ->where('user_id', $user->id)
                                  ->where('type', 'like')
                                  ->first();

        if ($reaction) {
            // If exists, unlike
            $reaction->delete();
        } else {
            // Else, like
            ReviewReaction::create([
                'review_id' => $review->id,
                'user_id' => $user->id,
                'type' => 'like'
            ]);
        }

        return back();
    }
}
