<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->createDb();
    }

    /** @test **/
    public function it_redirects_to_login_page_if_user_is_not_loggedin()
    {
        $this->get('courses/'.uniqid())->assertRedirect('login');
    }

    /** @test **/
    public function it_redirects_to_page_not_found_when_hitting_an_invalid_course_url()
    {
        $this->be($this->users[0]);
        $this->get('/courses/'.uniqid())->assertNotFound();
    }

    /** @test **/
    public function it_redirects_to_page_not_found_when_the_auth_user_hits_a_course_that_he_in_not_enrolled_to()
    {
        $this->be($this->users[0]);
        $this->get('/courses/'.$this->courses[1]->slug)->assertNotFound();
    }

    /** @test **/
    public function it_shows_leaderboard()
    {
        $this->be($this->users[0]);
        $this->get('/courses/'.$this->courses[0]->slug)->assertSee('Statistics');
    }
}
