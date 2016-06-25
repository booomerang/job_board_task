@extends('layout')

@section('content')
    @foreach($jobs->chunk(3) as $jobChunk)
        <div class="col-lg-6">
            @foreach($jobChunk as $job)
                <h4><a href="{{ route('job.show', ['job' => $job->id]) }}">{{ $job->title }}</a></h4>
                <p>{{ $job->description }}</p>
            @endforeach
        </div>
    @endforeach
@endsection