<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VacationRequest extends Model
{
    use HasFactory;

    protected $table = 'vacation_requests';
    protected $with = ['approvals', 'user'];
    protected $fillable = ['start_date', 'end_date', 'approved', 'description', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function approvals() {
        return $this->hasMany(VacationRequestApproval::class, 'vacation_request_id');
    }
}
