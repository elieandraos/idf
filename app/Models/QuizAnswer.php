<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
	protected $table = 'quiz_answers';
	
	/**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'quiz_id', 'user_id', 'course_id', 'answer', 'score'
    ];

	public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
