<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'about', 'price', 'reduced_price', 'category', 'image', 'user_id'];

    protected $casts = [
        'image' => 'array',
    ];
}
