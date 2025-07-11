<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'postcode',
        'address',
        'building',
        'average_rating',
        'rating_count',
        'rating_sum'
    ];
}
