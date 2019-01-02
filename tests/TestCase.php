<?php

namespace Tests;

use App\Models\User;
use App\Models\Course;
use App\Models\Country;
use App\Models\CourseEnrollment;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private const NUMBER_OF_COURSES = 3;
    private const NUMBER_OF_COUNTRIES = 5;
    private const NUMBER_OF_USERS_PER_COUNTRY = 15;

    protected $users = [];
    protected $courses = [];
    protected $courseEnrollments = [];

    /**
     * Persist these factories in memory testing database.
     *
     * @return type
     */
    public function createDb()
    {
    	// create 3 courses
    	for ($i = 0; $i < self::NUMBER_OF_COURSES; $i++) 
            $this->courses[] = factory(Course::class)->create();

    	// create 5 countries 
    	for ($i = 0; $i < self::NUMBER_OF_COUNTRIES; $i++) {
            $country = factory(Country::class)->create();
            // add 15 users to each country
            for($j = 0; $j < self::NUMBER_OF_USERS_PER_COUNTRY; $j++)
            	$this->users[] = factory(User::class)->create(['country_id' => $country->getKey() ]);
        }

        // enroll all the users to the first course
        foreach($this->users as $user)
        	$this->courseEnrollments[] = factory(CourseEnrollment::class)->create([
                'user_id' => $user->id,
                'course_id' => $this->courses[0]->id,
                'score' => ($user->id)
            ]);
    }
}
