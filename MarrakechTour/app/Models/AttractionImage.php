<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttractionImage extends Model
{
    protected $fillable = [
    'attraction_id',
    'image',
    'source',
];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }
}
