<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\VacationRequest;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'oib',
        'first_name',
        'last_name',
        'residence',
        'date_of_birth',
        'available_vacation_days',
        'is_superuser'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['roles'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function team() {
        return $this->belongsToMany(Team::class, 'team_has_user');
    }

    public function vacationRequests() {
        return $this->hasMany(VacationRequest::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'user_has_role');
    }
}
