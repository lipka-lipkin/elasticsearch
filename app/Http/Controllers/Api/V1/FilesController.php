<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FileStoreRequest;
use App\Http\Resources\Api\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Imagick;

class FilesController extends Controller
{
    public function store(FileStoreRequest $request){
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $name = \Str::random();
        $name = $name. '.' .$extension;
        $file = Storage::disk('public')->putFileAs('files', $file, $name);
        $image = File::create([
            'extension' => $request->extension,
            'path' => $file
        ]);
        return FileResource::make($image);
    }

    public function resize(Request $request){
        $paths = File::whereIn('id', $request->images)->pluck('path');
        foreach($paths as $path){
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)){
                $this->resizeAndSaveImage($fullPath);
            }
        }
    }

    private function resizeAndSaveImage($path){
        $imagick = new Imagick($path);
        $originalWidth = $imagick->getImageWidth();
        $originalHeight = $imagick->getImageHeight();
        $originalSize = $originalWidth . '*' . $originalHeight;
        $newWidth = $originalWidth / 2;
        $newHeight = $originalHeight / 2;
        $imagick->resizeImage($newWidth, $newHeight, 1, 1);
        $basename = File::getBasenameWithExtension($path);
        $imagick->writeImage($basename);
    }
}
