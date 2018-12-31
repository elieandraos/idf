<?php

namespace App\Services\EloquentLeaderboard;

use App\Models\CourseEnrollment;
use Illuminate\Support\Collection;
use App\Services\EloquentLeaderboard\EloquentLeaderboardInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CourseEnrollmentLeaderboard implements EloquentLeaderboardInterface
{
	protected $collection;

	/**
	 * Filter the given collection to get only CourseEnrollment model items
	 * For each model item:
	 * 
	 * - Add a field 'is_logged_user' to indicate if this is the logged in user
	 * - Sort by the 'score' DESC then 'is_logged_user' DESC (logged in user will always on be top in case of tie score with other users)
	 * - map again the sorted collection and add a field 'user_rank'
	 * 
	 * Adding 'is_logged_user' and 'user_rank' virtually on the collection will avoid slow query execution time.  
	 * In case I needed to do that in the db query, I would have to add: 
	 * (SELECT CASE WHEN user_id = authUserId THEN 1... as is_logged_user) and (SELECT @rownum  := @rownum  + 1 AS user_rank)
	 * And these will slow down the query time.
	 * 
	 * @param Collection $collection 
	 * @return type
	 */
	public function setCollection(EloquentCollection $collection) : EloquentLeaderboardInterface
	{
		$this->collection = $collection->whereInstanceOf('App\Models\CourseEnrollment')
										->map(function($item, $key){
								            $item['is_logged_user'] = ( $item['user_id'] == auth()->id() ) ? 1 : 0;
								            return $item;
								        })
								        ->sort(function($a, $b) {
										   if($a->score === $b->score) {
										     if($a->is_logged_user === $b->is_logged_user) {
										       return 0;
										     }
										     return $a->is_logged_user < $b->is_logged_user ? 1 : -1;
										   } 
										   return $a->score < $b->score ? 1 : -1;
										})
										->values()
								        ->map(function($item, $key){
								            $item['user_rank'] = $key + 1;
								            return $item;
								        });
		return $this;
	}

	public function getChunkSize() : int
	{
		return 3;
	}

	public function getTopChunk() : Collection
	{
		return $this->collection->take( $this->getChunkSize() );
	}

	public function getMiddleChunk() : Collection
	{
		$median = $this->getMedian( $this->getUserRank() );
		return $this->collection->whereBetween( 'user_rank', [$median -1, $median + 1]);
	}

	public function getBottomChunk() : Collection
	{
		$size = $this->getChunkSize() * -1;
		return $this->collection->take( $size );
	}

	public function getLeaderboard( ) : Collection
	{
		return  $this->getTopChunk()->merge($this->getMiddleChunk())->merge($this->getBottomChunk());
	}

	/**
	 * Get the median index for the middle chunk
	 * 
	 * @param int $userRank 
	 * @return int
	 */
	private function getMedian(int $userRank) : int
	{
		if(!$this->userHasMiddleRank($userRank))
			return (int) floor($this->collection->count() / 2);
		else if($this->userHasMiddleRank($userRank) && !$this->userIsAtLastMiddleRank($userRank)) 
			return $userRank;
		else
			return $userRank - 1;
	}

	/**
	 * Check if the user rank belongs to the middle chunk
	 * 
	 * @param int $userRank 
	 * @return bool
	 */
	private function userHasMiddleRank( int $userRank ) : bool
	{
		$bottomRankMax = $this->collection->count() + 1;
		$bottomRankMin = $bottomRankMax - $this->getChunkSize();
		return ( $userRank > $this->getChunkSize() && $userRank < $bottomRankMin) ? true : false;
	}

	/**
	 * Check if the user rank is the last one in the middle chunk
	 * 
	 * @param int $userRank 
	 * @return bool
	 */
	private function userIsAtLastMiddleRank(int $userRank) : bool
	{
		$bottomRankMax = $this->collection->count() + 1;
		$bottomRankMin = $bottomRankMax - ( $this->getChunkSize() + 1 );
		return ( $userRank == $bottomRankMin ) ? true : false;
	}

	/**
	 * Return the logged in user course enrollment
	 * 
	 * @return CourseEnrollment
	 */
	private function getUserCourseEnrollment() : CourseEnrollment
	{
		return $this->collection->where('is_logged_user', 1)->first();
	}

	/**
	 * Get the logged in user rank in the current collection
	 * 
	 * @return int
	 */
	public function getUserRank() : int
	{
		$userCourseEnrollment = $this->getUserCourseEnrollment();
		return $userCourseEnrollment->user_rank;
	}
}