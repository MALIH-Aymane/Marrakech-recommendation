<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttractionEmbedding extends Model
{
    protected $fillable = [
        'attraction_id',
        'embedding',
    ];

    protected $casts = [
        'embedding' => 'array',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }
}