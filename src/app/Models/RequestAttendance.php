<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RequestAttendance
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereUpdatedAt($value)
 * @property int $attendance_id
 * @property string $wait_start_work
 * @property string $wait_finish_work
 * @property string $notes
 * @property-read \App\Models\Attendance|null $attendance
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequestRest> $requestRests
 * @property-read int|null $request_rests_count
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereWaitFinishWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestAttendance whereWaitStartWork($value)
 * @mixin \Eloquent
 */
class RequestAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'wait_start_work',
        'wait_finish_work',
        'notes',

    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function requestRests()
    {
        return $this->hasMany(RequestRest::class);
    }

}
