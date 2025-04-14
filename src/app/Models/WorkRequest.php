<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WorkRequest
 *
 * @property int $id
 * @property int $attendance_id
 * @property string $request_date
 * @property int $request_flg
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attendance|null $attendance
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequestRest> $requestRests
 * @property-read int|null $request_rests_count
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest whereRequestFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'request_date',
        'request_flg',
    ];


    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function requestRests()
    {
        return $this->hasMany(RequestRest::class, 'request_attendance_id');
    }
}
