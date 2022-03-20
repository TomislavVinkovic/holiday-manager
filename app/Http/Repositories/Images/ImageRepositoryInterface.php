<?php

namespace App\Http\Repositories\Images;

use App\Models\Image;

interface ImageRepositoryInterface {
    public function createImage($file, string $path = ''): Image;
    public function updateImage($file, int $image_id, string $path = ''): Image;
    public function destroyImage(int $id): void;
}