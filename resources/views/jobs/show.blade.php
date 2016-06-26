@extends('layout')

@section('content')

    @if (session()->has('job_created.link'))
        <div class="alert alert-info">
            <div>Now you can access for editing/deleting job post by this link:</div>
            <p><b>{{ session()->get('job_created.link') }}</b></p>
        </div>
    @endif

    <h1>{{ $job->title }}</h1>
    <div class="clearfix"><span class="pull-right">by {{ $job->user_email }}</span></div>
    <p style="margin: 20px 0 0 0">{{ $job->description }}</p>
    <p style="margin: 20px 0 0 0"><b>My skills:</b> ...</p>
@endsection