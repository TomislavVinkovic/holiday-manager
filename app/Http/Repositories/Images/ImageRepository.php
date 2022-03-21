<?php

namespace App\Http\Repositories\Images;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Repositories\Images\AbstractImageRepository;
use Exception;

class ImageRepository extends AbstractImageRepository {

    public function createImage($file, $path = ''): Image {
        $newImagePath = $file->store(self::BASE_PATH . $path);
        $image = Image::create([
            'file_path' => $newImagePath
        ]);

        return $image;
    }

    public function updateImage($file, int $image_id, $path = ''): Image {
        $image = Image::findOrFail($image_id);
        Storage::delete([$image->file_path]);
        $newImagePath = $file->store(self::BASE_PATH . $path);
        $image->file_path = $newImagePath;
        $image->save();

        return $image;
    
    }

    public function destroyImage(int $id) : void {
        $image = Image::findOrFail($id);
        Storage::delete([$image->file_path]);
        $image->delete();
        
    }
}