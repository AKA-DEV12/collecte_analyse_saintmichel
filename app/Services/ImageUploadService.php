<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploadService
{
    public function uploadAumonierPhoto(UploadedFile $file): string
    {
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = 'images/rendezvous/'.$filename;
        // store on public disk so it's accessible via /storage
        $file->storeAs('public', $path);
        return 'storage/'.$path;
    }
}
