<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'about', 'size', 'post_status', 'setting', 'online_or_offline', 'logo', 'category', 'downloads', 'download_links', 'image', 'user_id'];

    protected $casts = [
        'image' => 'array',
        'download_links' => 'json',
        'setting' => 'json',
        'downloads' => 'array',
    ];

    // protected static function booted(): void
    // {
    //     self::deleted(function (Game $game){
    //         Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
    //     });
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->latest();
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'post_id')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function categories(): HasMany
    // {
    //    return $this->hasMany(Category::class, 'category', 'name');
    // }
}
