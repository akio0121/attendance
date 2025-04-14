<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rest;

/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 * @property string $start_work
 * @property string|null $finish_work
 * @property string|null $total_work
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rest> $rests
 * @property-read int|null $rests_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereFinishWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStartWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereTotalWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUserId($value)
 * @property-read \App\Models\RequestAttendance|null $requestAttendance
 * @property-read \App\Models\WorkRequest|null $workRequest
 * @mixin \Eloquent
 */
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

    public function requestAttendance()
    {
        return $this->hasOne(RequestAttendance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workRequest()
    {
        return $this->hasOne(WorkRequest::class);
    }
}

