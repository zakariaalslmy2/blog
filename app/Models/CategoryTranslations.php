<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'content'];
}