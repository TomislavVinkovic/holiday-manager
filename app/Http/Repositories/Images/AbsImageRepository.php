<?php

namespace App\Http\Repositories\Images;

use App\Models\Image;

abstract class AbsImageRepository {

    protected const BASE_PATH = 'public/images';

    public abstract function createImage($file, string $path = ''): Image;
    public abstract function updateImage($file, int $image_id, string $path = ''): Image;
    public abstract function destroyImage(int $id): void;
}