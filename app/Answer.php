<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'answer', 'question', 'user'
    ];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
