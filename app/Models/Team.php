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

    protected $fillable = ['name', 'description', 'lead_id', 'logo_id'];
    protected $table = 'teams';
    protected $with = ['lead'];

    public function users() {
        return $this->belongsToMany(User::class, 'team_has_user');
    }

    public function lead() {
        return $this->hasOne(User::class, 'id', 'lead_id');
    }

    public function projects() {
        return $this->belongsToMany(Project::class, 'project_has_team');
    }

    public function logo() {
        return $this->hasOne(Image::class, 'id', 'logo_id');
    }
}
