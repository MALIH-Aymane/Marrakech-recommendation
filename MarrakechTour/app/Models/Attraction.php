<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
   protected $fillable = [
    'rate',
    'attraction',
    'reviews',
    'details',
    'attraction_url',
    'reviews_url',
    'languages',
    'location_img',
    'ratings_list',
    'type',
    'latitude',
    'longitude',
    'uuid',
    'photo',
];
}
