<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Answer extends Model
{
    protected $fillable=['description','order','question_id'];

    use HasFactory;

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function excerpt(){
        return Str::limit($this->description, 20);
    }
}
