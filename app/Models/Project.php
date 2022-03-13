<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Team;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    protected $table = 'projects';

    public function logo() {
        return $this->hasOne(Image::class, 'id', 'logo_id');
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'project_has_team');
    }
}
