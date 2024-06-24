<?php
// app/Models/Question.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'eng_questions', 'mm_questions'];

    protected $casts = [
        'eng_questions' => 'array',
        'mm_questions' => 'array',
    ];
}
