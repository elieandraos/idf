<?php

namespace Tests\Unit\Leaderboard;

use Tests\TestCase;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\EloquentLeaderboard\CourseEnrollmentLeaderboard;

class CourseEnrollmentLeaderboardTest extends TestCase
{
	use RefreshDatabase;

	protected $course;

	protected function setUp()
    {
        parent::setUp();
        $this->createDb();

        // testing leaderboard by country of the first user, as it is the easiest
    	// scores will be from 1 to 15 respectively for the users enrolled
    	// in other words, at this point, the auth user is last with score 1.
        $this->be($this->users[0]);
        $this->course = $this->courses[0];
    }

    protected function getCountryCourseEnrollements()
    {
    	return  CourseEnrollment::with('user')
                                    ->whereHas('user', function($query) {
                                        $query->where('country_id', auth()->user()->country_id);
                                    })->where('course_id', $this->course->id)
                                    ->get();
    }

    protected function updateUserScore($score = 10)
    {
    	$courseEnrollment = CourseEnrollment::where('user_id', $this->users[0]->id)->where('course_id', $this->course->id)->first();
    	$courseEnrollment->update([ 'score' => $score]);
    }

    /** @test */
    public function it_should_return_nine_items()
    {
    	$leaderboard = new CourseEnrollmentLeaderboard($this->getCountryCourseEnrollements());
    	$collection = $leaderboard->getLeaderBoard();
        $this->assertTrue($collection->count() == ($leaderboard->getChunkSize() * 3) );
    }

    /** @test */
    public function it_should_contain_user_rank_in_every_item_in_collection()
    {
    	$leaderboard = new CourseEnrollmentLeaderboard($this->getCountryCourseEnrollements());
    	$collection = $leaderboard->getLeaderBoard();

    	$hasUserRank = true;
    	$collection->map( function($item) use ($hasUserRank) {
    		$hasUserRank = (!$item->exists('user_rank')) ? false : true;
    		return $item;
    	});
    	
        $this->assertTrue($hasUserRank);
    }

    /** @test */
    public function it_should_contain_is_logged_user_in_every_item_in_collection()
    {
    	$leaderboard = new CourseEnrollmentLeaderboard($this->getCountryCourseEnrollements());
    	$collection = $leaderboard->getLeaderBoard();

    	$hasIsLoggedUser = true;
    	$collection->map( function($item) use ($hasIsLoggedUser) {
    		$hasIsLoggedUser = (!$item->exists('is_logged_user')) ? false : true;
    		return $item;
    	});
    	
        $this->assertTrue($hasIsLoggedUser);
    }

    /** @test */
    public function user_is_in_bottom_chunk()
    {
    	$leaderboard = new CourseEnrollmentLeaderboard($this->getCountryCourseEnrollements());
    	$collection = $leaderboard->getBottomChunk();

    	$filtered = $collection->filter( function($item) {
    		return $item->is_logged_user == 1;
    	});

        $this->assertTrue($filtered->count() == 1);
    }

     /** @test */
    public function user_rank_is_last_in_leaderboard()
    {
    	$courseEnrollments = $this->getCountryCourseEnrollements();
    	$leaderboard = new CourseEnrollmentLeaderboard($courseEnrollments);
    	$collection = $leaderboard->getLeaderboard();

    	$filtered = $collection->filter( function($item) {
    		return $item->is_logged_user == 1;
    	})->values()->first();

        $this->assertTrue($filtered->user_rank == $courseEnrollments->count());
        $this->assertTrue($filtered->user_rank == $leaderboard->getUserRank());
    }

    /** @test **/
    public function update_with_highest_score_and_verify_user_is_top_rank()
    {
    	$this->updateUserScore(100);
    	$leaderboard = new CourseEnrollmentLeaderboard($this->getCountryCourseEnrollements());
    	$collection = $leaderboard->getLeaderboard();

    	$filtered = $collection->filter( function($item) {
    		return $item->is_logged_user == 1;
    	})->values()->first();

    	// verify user is ranked first
    	$this->assertTrue($filtered->user_rank == 1);
    	$this->assertTrue($leaderboard->getUserRank() == 1);

    	// verify user is in top chunk
    	$collection = $leaderboard->getTopChunk();

    	$filtered = $collection->filter( function($item) {
    		return $item->is_logged_user == 1;
    	});

        $this->assertTrue($filtered->count() == 1);
    }

    /** @test **/
    public function tie_score_with_highest_ranked_user_but_verify_he_is_ranked_above_him()
    {
    	$this->updateUserScore(15);
    	$leaderboard = new CourseEnrollmentLeaderboard($this->getCountryCourseEnrollements());

    	// verify that 2 users has the same score in top chunk but the logged in user ranked first
    	$collection = $leaderboard->getTopChunk();

    	$filtered = $collection->filter( function($item) {
    		return $item->score == 15;
    	});

        $this->assertTrue($filtered->count() == 2);
        $this->assertTrue($leaderboard->getUserRank() == 1);
    }
}