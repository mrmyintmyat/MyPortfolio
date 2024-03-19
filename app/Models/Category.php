<?php

namespace App\Models;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function games($category_name)
    {
        $games = collect();
        $gamesForCategory = Game::where('category', 'like', "%{$category_name}%")->get();
        $games = $games->concat($gamesForCategory);

        return $games;
    }
}
