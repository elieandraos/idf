<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollment;
use Illuminate\Contracts\Support\Renderable;
use App\Services\EloquentLeaderboard\CourseEnrollmentLeaderboard;

class CourseEnrollmentController extends Controller
{
    protected $courseEnrollmentLeaderboard;

    public function __construct(CourseEnrollmentLeaderboard $courseEnrollmentLeaderboard)
    {
        $this->courseEnrollmentLeaderboard = $courseEnrollmentLeaderboard;
    }

    public function show(Request $request, string $slug) : Renderable
    {
        $course = $request->course;
        $courseEnrollment = $request->courseEnrollment;

        $enrollmentsWorldwide = CourseEnrollment::with('user')->where('course_id', $course->id)->get();
        $enrollmentsLeaderboardWorldwide = $this->courseEnrollmentLeaderboard->setCollection($enrollmentsWorldwide);
        
        return view('courseEnrollment', [
            'course' => $course,
            'leaderboardWorldwide' => $enrollmentsLeaderboardWorldwide->getLeaderBoard(),
            'leaderboardWorldwideRank' => $enrollmentsLeaderboardWorldwide->getUserRank()
        ]);
    }
}
