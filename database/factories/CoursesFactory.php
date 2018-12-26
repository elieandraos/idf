<?php

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\QuizAnswer;
use Faker\Generator as Faker;
use App\Models\CourseEnrollment;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Course::class, function (Faker $faker) {
    $words = [
        'Design',
        'Thinking',
        'UX',
        'UI',
        'User Experience',
        'How to',
        'Product',
        'Web Deisign',
        'Visualization',
        'Management',
        'for',
        'and',
        'or',
        'with',
        'from scratch',
    ];
    $title = collect($words)->shuffle()->take(random_int(3, 7))->implode(' ');

    return [
        'title' => $title,
        'slug' => str_slug($title),
    ];
});

$factory->define(Lesson::class, function (Faker $faker) {
    return [
//        'course_id',
        'title' => $faker->sentence,
        'number' => $faker->numberBetween(1, 100),
    ];
});

$factory->define(CourseEnrollment::class, function (Faker $faker) {
    return [
        'course_id' => function () {
            return factory(Course::class)->lazy()->getKey();
        },
        'user_id' => function () {
            return factory(User::class)->lazy()->getKey();
        },
    ];
});

$factory->define(Quiz::class, function (Faker $faker) {
    return [
//        'lesson_id',
        'max_score' => random_int(5, 10),
        'question' => sprintf('Is %s similar to Red?', $this->faker->colorName),
    ];
});

$factory->define(QuizAnswer::class, function (Faker $faker) {
    return [
//        'quiz_id',
//        'user_id',
        'answer' => $faker->sentence,
        'score' => random_int(0, 5),
    ];
});
