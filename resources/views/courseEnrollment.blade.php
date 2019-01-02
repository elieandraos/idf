<?php
/**
 * @var \App\CourseEnrollmentn $enrollment
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <h2 class="card-header">Lessons</h2>
                    <div class="card-body">
                        <ol>
                            @foreach($course->lessons as $lesson)
                                <li>{{ $lesson->title }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <course-leaderboard 
                    url="{!! route('courseEnrollments.leaderboard', $course->slug) !!}"
                    :user-id="{!! auth()->id() !!}"
                    :course-id="{!! $course->id !!}"
                    update-score-url="{!! route('courseEnrollments.score-update', $course->slug) !!}"
                ></course-leaderboard>

            </div>
        </div>
    </div>
@endsection
