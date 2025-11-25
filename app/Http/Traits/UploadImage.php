<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait UploadImage
{
    /**
     * رفع صورة في التخزين storage/app/public/{folder}
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  string $folder
     * @return string path
     */
    public function uploadImage($file, $folder = 'general')
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($folder, $filename, 'public');
    }
}
