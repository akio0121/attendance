<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_work',
        'finish_work',
        'total_work',

    ];

    public function rests()
    {
        return $this->hasMany(Rest::class, 'attendance_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

