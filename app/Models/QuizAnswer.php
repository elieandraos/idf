<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
	protected $table = 'quiz_answers';
	
	public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
