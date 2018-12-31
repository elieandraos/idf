<?php
namespace App\Services\EloquentLeaderboard;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * Gamify any eloquent model.
 * 
 * Returns top/middle/bottom chunks from a given eloquent model collection
 */
interface EloquentLeaderboardInterface  
{
	public function setCollection(EloquentCollection $collection) : EloquentLeaderboardInterface;
	public function getChunkSize() : int;
	public function getTopChunk() : Collection;
	public function getBottomChunk() : Collection;
	public function getMiddleChunk() : Collection;
	public function getLeaderboard() : Collection;
}
