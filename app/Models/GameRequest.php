<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRequest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'photo_link', 'type', 'version', 'status', 'user_id'];
}
