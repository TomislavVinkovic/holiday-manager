<?php

namespace App\Http\Repositories\Images;

use App\Http\Repositories\Images\ImageRepositoryInterface;

abstract class AbstractImageRepository implements ImageRepositoryInterface {

    protected const BASE_PATH = 'public/images';
}