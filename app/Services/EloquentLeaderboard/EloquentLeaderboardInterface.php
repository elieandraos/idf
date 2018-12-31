<?php
namespace App\Services\EloquentLeaderboard;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * Gamify any eloquent model.
 * 
 * Now, we can gamify Users with most enrolled courses, or Courses with most enrolled users etc...
 * All of them will have the same defined contracts accoring to our custom gamification logic.
 * 
 */
interface EloquentLeaderboardInterface  
{
	public function getTopChunk() : Collection;
	public function getBottomChunk() : Collection;
	public function getMiddleChunk() : Collection;
	public function getLeaderboard() : Collection;
}
