<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RequestRest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest query()
 * @property int $id
 * @property int $request_attendance_id
 * @property string $wait_start_rest
 * @property string $wait_finish_rest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RequestAttendance|null $requestAttendance
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest whereRequestAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest whereWaitFinishRest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest whereWaitStartRest($value)
 * @mixin \Eloquent
 */
class RequestRest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_attendance_id',
        'wait_start_rest',
        'wait_finish_rest',

    ];

    public function requestAttendance()
    {
        return $this->belongsTo(RequestAttendance::class);
    }
}
