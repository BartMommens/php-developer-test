<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'copyright',
        'explanation',
        'url',
        'hdurl',
        'media_type',
        'created_at'
    ];

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }
}
