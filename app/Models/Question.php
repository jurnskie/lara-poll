<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Util\Str;

class Question extends Model
{
    protected $fillable = ['title','status'];

    use HasFactory;

    public function answers(){
        return $this->hasMany(Answer::class)->orderBy('order','desc');
    }

    public function excerpt(){
        return Str::limit($this->description, 100);
    }
}
