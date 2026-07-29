<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassificationReference extends Model
{
    protected $fillable = [

        'nom',
        'type',

    ];
}