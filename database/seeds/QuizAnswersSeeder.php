<?php
ini_set('memory_limit', '1024M');

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\Country;
use App\Models\QuizAnswer;
use Illuminate\Database\Seeder;
use App\Models\CourseEnrollment;

class QuizAnswersSeeder extends Seeder
{
    private const NUMBER_OF_USERS = 150;

    /** @var \Illuminate\Support\Collection */
    private $countryIds;
    /** @var \Illuminate\Support\Collection */
    private $courseIds;

    public function __construct()
    {
        $this->countryIds = Country::all(['id'])->pluck('id');
        $this->courseIds = Course::all(['id'])->pluck('id');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < self::NUMBER_OF_USERS; $i++) {
            $user = factory(User::class)->create(['country_id' => $this->countryIds->random()]);
            $this->enrolInCoursesAndGenerateAnswers($user, random_int(0, $this->courseIds->count()));
        }
    }

    private function enrolInCoursesAndGenerateAnswers(User $user, int $numberOfCoursesToEnrol)
    {
        $userEnroledTo = [];

        for ($i = 0; $i < $numberOfCoursesToEnrol; $i++) {
            $courseIdToEnrol = $this->courseIds->diff($userEnroledTo)->random();
            $userEnroledTo[] = $courseIdToEnrol;
            $enrolment = factory(CourseEnrollment::class)->create([
                'user_id' => $user->id,
                'course_id' => $courseIdToEnrol,
            ]);

            $this->generateAnswersForEnrolment($enrolment);
        }
    }

    private function generateAnswersForEnrolment(CourseEnrollment $enrollment)
    {
        $allQuizesFromCourse = $enrollment->course->quizzes;
        $quizzesToGenerateAnswers = $allQuizesFromCourse->take(random_int(0, $allQuizesFromCourse->count()));

        $quizzesToGenerateAnswers->each(function (Quiz $quiz) use ($enrollment) {
            $quizScore = random_int(0, $quiz->max_score);

            factory(QuizAnswer::class)->create([
                'quiz_id' => $quiz->id,
                'user_id' => $enrollment->user->id,
                'course_id' => $quiz->lesson->course->id,
                'score' => $quizScore,
            ]);

            $enrollment->update([
                'score' => $enrollment->score + $quizScore
            ]);
        });
    }
}
