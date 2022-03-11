<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VacationRequest extends Model
{
    use HasFactory;

    protected $table = 'vacation_requests';
    
    protected $fillable = ['start_date', 'end_date', 'approved', 'description'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
