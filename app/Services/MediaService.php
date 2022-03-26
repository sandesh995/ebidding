<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class MediaService
{
    public static function upload(UploadedFile $file, string $folder = "uploads"): int
    {
        $name = Str::slug($file->getClientOriginalName());
        $extension = $file->extension();
        $type = $file->getMimeType();
        $path = Str::random(10) . mt_rand(1, 100) . "." . $extension;

        // Store File
        $file->storeAs("public/" . $folder, $path);

        // Store in Database
        $media = Media::create([
            'name' => $name,
            'type' => $type,
            'path' => $folder . "/" . $path,
        ]);

        return $media->id;
    }
}
