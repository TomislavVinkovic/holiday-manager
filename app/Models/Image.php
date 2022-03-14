<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $fillable = ['file_path'];

    //ova metoda uploada sliku, kreira image model i vraca id novostvorenog image modela sa samo jednom metodom
    public static function uploadAndCreateGetId($image) : int {
        $path = $image->store('public/images');
        $newImageId = self::insertGetId([
            'file_path' => $path
        ]);

        return $newImageId;
    }
}
