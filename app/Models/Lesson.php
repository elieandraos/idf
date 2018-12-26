<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $course_id
 * @property int $number
 * @property string $title
 */
class Lesson extends Model
{
	public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
