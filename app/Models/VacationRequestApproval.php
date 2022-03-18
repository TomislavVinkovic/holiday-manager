<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationRequestApproval extends Model
{
    use HasFactory;

    protected $table = 'vacation_request_approvals';
    protected $fillable = ['vacation_request_id', 'lead_id'];
    protected $with = ['lead'];

    public function lead() {
        return $this->belongsTo(User::class);
    }

    public function vacationRequest() {
        return $this->belongsTo(VacationRequest::class);
    }
}
