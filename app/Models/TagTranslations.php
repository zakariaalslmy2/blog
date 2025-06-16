<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','content', 'address'];
}