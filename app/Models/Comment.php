<?php

namespace App\Models;

use App\Models\Game;
use App\Models\User;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['likes','from_user_id', 'to_user_id', 'text', 'post_id', 'name'];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function post()
    {
        return $this->belongsTo(Game::class, 'post_id');
    }

    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    // public function paginatedReplies($perPage = 10)
    // {
    //     return $this->replies()->paginate($perPage);
    // }
}
