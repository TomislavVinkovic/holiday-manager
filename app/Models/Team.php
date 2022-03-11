<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\User;
use App\Models\Project;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    protected $table = 'teams';
    
    public function users() {
        return $this->belongsToMany(User::class, 'team_has_user');
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function logo() {
        return $this->hasOne(Image::class, 'id', 'logo_id');
    }
}