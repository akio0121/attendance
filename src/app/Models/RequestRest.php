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
