<?php

namespace App\Http\Repositories\Images;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Repositories\Images\AbstractImageRepository;
use Exception;

class ImageRepository extends AbstractImageRepository {

    public function createImage($file, $path = ''): Image {
        try {
            $newImagePath = $file->store(self::BASE_PATH . $path);
            $image = Image::create([
                'file_path' => $newImagePath
            ]);

            return $image;
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function updateImage($file, int $image_id, $path = ''): Image {
        try {
            $image = Image::findOrFail($image_id);
            Storage::delete([$image->file_path]);
            $newImagePath = $file->store(self::BASE_PATH . $path);
            $image->file_path = $newImagePath;
            $image->save();

            return $image;
        } catch (Exception $e) {
            throw $e;
        }
        
    }

    public function destroyImage(int $id) : void {
        try {
            $image = Image::findOrFail($id);
            Storage::delete([$image->file_path]);
            $image->delete();
        } catch (Exception $e) {
            throw $e;
        }
        
    }
}