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
 * @mixin \Eloquent
 */
class RequestAttendance extends Model
{
    use HasFactory;
}
