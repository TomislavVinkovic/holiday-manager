<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationRequestApproval extends Model
{
    use HasFactory;

    protected $table = 'vacation_request_approvals';
    protected $fillable = ['vacation_request_id', 'lead_id'];

}
