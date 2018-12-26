<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $max_score
 */
class Quiz extends Model
{
	protected $table = 'quizzes';
	
	public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
