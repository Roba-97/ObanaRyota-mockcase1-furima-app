<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'condition_id',
        'image_path',
        'name',
        'brand',
        'price',
        'detail',
        'sold_flag'
    ];

    public function seller()
    {
        return $this->belongsTo(Profile::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function condition() {
        return $this->hasOne(Condition::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
