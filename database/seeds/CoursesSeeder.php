<?php

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $course = factory(Course::class)->create();
            $this->addLessonsToCourse($course);
        }
    }

    private function addLessonsToCourse(Course $course)
    {
        $numberOfLessons = random_int(8, 15);

        for ($i = 0; $i < $numberOfLessons; $i++) {
            $lesson = factory(Lesson::class)->create([
                'course_id' => $course->getKey(),
                'number' => $i + 1,
            ]);
            $this->addQuizzesToLesson($lesson);
        }
    }

    private function addQuizzesToLesson(Lesson $lesson)
    {
        $numberOfQuizzes = random_int(1, 5);

        for ($i = 0; $i < $numberOfQuizzes; $i++) {
            factory(Quiz::class)->create([
                'lesson_id' => $lesson->getKey(),
                'max_score' => random_int(5, 10),
            ]);
        }
    }
}
