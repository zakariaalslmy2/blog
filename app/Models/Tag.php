<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Tag extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['title', 'content', 'address'];
    protected $fillable = [ 'id', 'created_at', 'updated_at', 'deleted_at'];
}