<?php declare(strict_types=1);

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property Course $course
 * @property User $user
 */
class CourseEnrollment extends Model
{
	protected $table = 'course_enrollments';
	
	/**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'course_id', 'user_id', 'score'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
