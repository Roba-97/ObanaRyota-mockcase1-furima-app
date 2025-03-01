<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'profile_id',
        'content'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
