<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'is_deal',
        'last_accessed_at'
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
