<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'content', 'smallDescrption'];
}