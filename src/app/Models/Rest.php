<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rest
 *
 * @property int $id
 * @property int $attendance_id
 * @property string $start_rest
 * @property string|null $finish_rest
 * @property string|null $total_rest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attendance|null $attendance
 * @method static \Illuminate\Database\Eloquent\Builder|Rest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rest query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereFinishRest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereStartRest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereTotalRest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'start_rest',
        'finish_rest',
        'total_rest',

    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }
}
