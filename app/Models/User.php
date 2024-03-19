<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Game;
use App\Models\Noti;
use App\Models\Reply;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser,MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'logo','email', 'status', 'is_logged_in', 'device_token', 'password', 'user_token', 'setting'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'status', 'is_logged_in', 'device_token', 'user_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'setting' => 'json'
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->status, 'adminzynn');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function notices()
    {
        return $this->hasMany(Noti::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'from_user_id');
    }

    public function replies(){
        return $this->hasMany(Reply::class, 'from_user_id');
    }

    public function reply_to_name_replies(){
        return $this->hasMany(Reply::class, 'to_user_id');
    }
}
