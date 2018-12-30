<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollment;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Resources\CourseEnrollmentResource;

class CourseEnrollmentController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $course = $request->course;
        $courseEnrollment = $request->courseEnrollment;

        $enrollmentsWorldwide = CourseEnrollment::with('user')->displayRank()->where('course_id', $course->id)->orderBy('score', 'DESC')->get();
        // dd( $enrollmentsWorldwide );
        
        return view('courseEnrollment', [
            'course' => $course,
        ]);
    }
}
