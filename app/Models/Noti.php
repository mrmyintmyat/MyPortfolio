<?php

namespace App\Models;

use App\Models\Game;
use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Noti extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = ['image', 'title', 'text', 'user_id', 'game_id', 'type','from_id'];
    protected $casts = [
        'type' => 'json',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
