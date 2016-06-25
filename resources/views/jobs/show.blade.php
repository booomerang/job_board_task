@extends('layout')

@section('content')
    <h1>{{ $job->title }}</h1>
    <div class="clearfix"><span class="pull-right">by {{ $job->user_email }}</span></div>
    <p style="margin: 20px 0 0 0">{{ $job->description }}</p>
    <p style="margin: 20px 0 0 0"><b>My skills:</b> ...</p>
@endsection