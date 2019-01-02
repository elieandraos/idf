<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollment;
use Illuminate\Contracts\Support\Renderable;
use App\Services\EloquentLeaderboard\CourseEnrollmentLeaderboard;

class CourseEnrollmentController extends Controller
{

    public function show(Request $request, string $slug) : Renderable
    {
        $course = $request->course;
        $courseEnrollment = $request->courseEnrollment;
        
        return view('courseEnrollment', [
            'course' => $course
        ]);
    }

    public function leaderboard(Request $request, string $slug)
    {
        $course = $request->course;

        $enrollmentsWorldwide = CourseEnrollment::with('user')
                                            ->where('course_id', $course->id)
                                            ->get();

        $enrollmentsCountry = CourseEnrollment::with('user')
                                            ->whereHas('user', function($query) {
                                                $query->where('country_id', auth()->user()->country_id);
                                            })->where('course_id', $course->id)
                                            ->get();

        $enrollmentsLeaderboardCountry = new CourseEnrollmentLeaderboard($enrollmentsCountry);
        $enrollmentsLeaderboardWorldwide = new CourseEnrollmentLeaderboard($enrollmentsWorldwide);

        return response()->json([
            'leaderboardWorldwide' => $enrollmentsLeaderboardWorldwide->getLeaderBoard(),
            'leaderboardWorldwideRank' => $enrollmentsLeaderboardWorldwide->getUserRank(),
            'leaderboardCountry' => $enrollmentsLeaderboardCountry->getLeaderBoard(),
            'leaderboardCountryRank' => $enrollmentsLeaderboardCountry->getUserRank()
        ]);
    }

    public function updateScore(Request $request, string $slug)
    {
        $courseEnrollment = $request->courseEnrollment;
        $courseEnrollment->update(['score' => $request->score]);
        return response()->json(['status' => 'success']);
    }
}
