<?php
/**
 * @var \App\CourseEnrollmentn $enrollment
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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

                <div class="card mt-4">
                    <h2 class="card-header">Statistics</h2>
                    <div class="card-body">

                        <p>
                            Your rankings improve every time you answer a question correctly.
                            Keep learning and earning course points to become one of our top learners!
                        </p>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <h4>You are ranked <b>{!! $leaderboardCountryRank !!}</b> in {!! auth()->user()->country->name !!}</h4>
                                <ul style="padding: 0px;">
                                    @foreach($leaderboardCountry as $key => $item)
                                        <li class="courseRanking__rankItem"
                                            style="display: flex; flex-direction: row; padding: 10px;">
                                            <div class="position"
                                                 style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                                {!! $item->user_rank !!}
                                            </div>
                                            <div class="info">
                                                <div style="font-size: 16px;">
                                                    @if($item->is_logged_user)
                                                      <b>{!! $item->user->name !!}</b>
                                                    @else
                                                        {!! $item->user->name !!}
                                                    @endif
                                                </div>
                                                <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                     {!! $item->score !!} PTS
                                                </div>
                                            </div>
                                        </li>
                                        @if( ($key+1) % 3 == 0 ) <hr/> @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h4>You are ranked <b>{!! $leaderboardWorldwideRank !!}</b> Worldwide</h4>
                                <ul style="padding: 0px;">
                                    @foreach($leaderboardWorldwide as $key => $item)
                                        <li class="courseRanking__rankItem"
                                            style="display: flex; flex-direction: row; padding: 10px;">
                                            <div class="position"
                                                 style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                                {!! $item->user_rank !!}
                                            </div>
                                            <div class="info">
                                                <div style="font-size: 16px;">
                                                    @if($item->is_logged_user)
                                                      <b>{!! $item->user->name !!}</b>
                                                    @else
                                                        {!! $item->user->name !!}
                                                    @endif
                                                </div>
                                                <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                     {!! $item->score !!} PTS
                                                </div>
                                            </div>
                                        </li>
                                        @if( ($key+1) % 3 == 0 ) <hr/> @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
