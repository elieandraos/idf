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
                                <h4>You are ranked <b>4th</b> in {{ auth()->user()->country->name }}</h4>
                                {{--Replace this stub markup by your code--}}
                                <ul style="padding: 0px;">
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            1
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Sandra Lidstream
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                205 PTS (+93)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            2
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Corvin Dalek
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                200 PTS (+88)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            3
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Kumar Jubar
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                180 PTS (+68)
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            4
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;"><b>Alfred Maroz</b></div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                112 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            5
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Arthur Rembo
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                95 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            15
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Colin Shpak
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                74 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            34
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Gustaf Makinen
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                20 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            35
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Selena Manesh
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                10 PTS
                                            </div>
                                        </div>
                                    </li>
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            36
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                Adam Morrison
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                3 PTS
                                            </div>
                                        </div>
                                    </li>
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
