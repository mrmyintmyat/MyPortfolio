<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'about', 'size', 'post_status', 'online_or_offline', 'logo', 'category', 'download_links', 'image', 'user_id'];

    protected $casts = [
        'image' => 'array',
        'download_links' => 'json',
    ];
}
