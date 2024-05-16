<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = ['site_title', 'site_description', 'logo_path', 'comments', 'register', 'site_status'];
}
