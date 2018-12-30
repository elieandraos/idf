<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseEnrollment;
use Illuminate\Contracts\Support\Renderable;

class CourseEnrollmentController extends Controller
{
    public function show(Request $request, string $slug): Renderable
    {
        return view('courseEnrollment', [
            'enrollment' => $request->courseEnrollment,
            'course' => $request->course,
        ]);
    }
}
