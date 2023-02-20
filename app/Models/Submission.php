<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['question_id', 'answer_id', 'user_id'];

    use HasFactory;
}
