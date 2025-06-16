<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'content', 'address'];
    protected $table = "setting_translations";

}
