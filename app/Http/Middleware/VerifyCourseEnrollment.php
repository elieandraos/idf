<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\Course;
use App\Models\CourseEnrollment;

class VerifyCourseEnrollment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $slug = $request->route('slug');

        // verify the course exists
        $course = Course::with('lessons')->where('slug', $slug)->first() ?? abort(404, 'Unknown course');

        // verify the user is enrolled in the course
        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->first() ?? abort(404, 'You are not enrolled to this course');

        // we do not want to query the course again in the controller
        $request->merge( ['course' => $course, 'courseEnrollment' => $enrollment] );

        return $next($request);
    }
}
