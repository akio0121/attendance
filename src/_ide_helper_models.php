<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Request
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request query()
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereUpdatedAt($value)
 */
	class Request extends \Eloquent {}
}

namespace App\Models{
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
 */
	class RequestAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RequestRest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestRest query()
 */
	class RequestRest extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Rest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property int $admin_flg
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdminFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

