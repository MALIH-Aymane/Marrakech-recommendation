<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'attraction_id', 'user_id', 'parent_id', 'rating', 'comment'
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }
    
    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    public function reactions()
    {
        return $this->hasMany(ReviewReaction::class);
    }

    protected static function booted()
    {
        static::created(function ($review) {
            if ($review->attraction) {
                $review->attraction->increment('reviews_count');
            }
        });

        static::deleted(function ($review) {
            if ($review->attraction) {
                $review->attraction->decrement('reviews_count');
            }
        });
    }
}
