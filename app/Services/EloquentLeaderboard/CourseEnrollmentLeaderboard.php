<?php

namespace App\Services\EloquentLeaderboard;

use App\Models\CourseEnrollment;
use Illuminate\Support\Collection;
use App\Services\EloquentLeaderboard\EloquentLeaderboard;
use App\Services\EloquentLeaderboard\EloquentLeaderboardInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CourseEnrollmentLeaderboard extends EloquentLeaderboard implements EloquentLeaderboardInterface
{
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
	public function handleCollection(EloquentCollection $collection) : Collection
	{
		return $collection->whereInstanceOf('App\Models\CourseEnrollment')
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
	}

	public function getTopChunk() : Collection
	{
		return $this->getCollection()->take( $this->getChunkSize() );
	}

	public function getMiddleChunk() : Collection
	{
		$median = $this->getMedian();
		return $this->getCollection()->whereBetween( 'user_rank', [$median -1, $median + 1]);
	}

	public function getBottomChunk() : Collection
	{
		$size = $this->getChunkSize() * -1;
		return $this->getCollection()->take( $size );
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
	private function getMedian() : int
	{
		$userRank = $this->getUserRank();

		if(!$userRank || !$this->userHasMiddleRank($userRank))
			return (int) floor($this->getCollection()->count() / 2);
		else if ($this->userHasMiddleRank($userRank) && $this->userIsAtFirstMiddleRank($userRank))
			return $userRank + 1;
		else if ($this->userHasMiddleRank($userRank) && $this->userIsAtLastMiddleRank($userRank))
			return $userRank - 1;
		else
			return $userRank;
	}

	/**
	 * Check if the user rank belongs to the middle chunk
	 * 
	 * @param int $userRank 
	 * @return bool
	 */
	private function userHasMiddleRank( int $userRank ) : bool
	{
		$bottomRankMax = $this->getCollection()->count() + 1;
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
		$bottomRankMax = $this->getCollection()->count() + 1;
		$bottomRankMin = $bottomRankMax - ( $this->getChunkSize() + 1 );
		return ( $userRank == $bottomRankMin ) ? true : false;
	}

	/**
	 * Check if the user rank is the first one in the middle chunk
	 * 
	 * @param int $userRank 
	 * @return bool
	 */
	private function userIsAtFirstMiddleRank(int $userRank) : bool
	{
		$middleRankMin = $this->getChunkSize() + 1;
		return ($userRank == $middleRankMin) ? true : false;
	}

	/**
	 * Return the logged in user course enrollment
	 * 
	 * @return CourseEnrollment
	 */
	private function getUserCourseEnrollment() : CourseEnrollment
	{
		return $this->getCollection()->where('is_logged_user', 1)->first();
	}

	/**
	 * Get the logged in user rank in the current collection
	 * 
	 * @return int
	 */
	public function getUserRank() : int
	{
		$userCourseEnrollment = $this->getUserCourseEnrollment();
		return ($userCourseEnrollment) ? $userCourseEnrollment->user_rank : 0;
	}
}