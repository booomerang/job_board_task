@extends('layout')

@section('content')
    <form action="{{ route('job.store') }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="jobUserEmailInput">Your email</label>
            <input type="text" class="form-control" id="jobUserEmailInput" name="job[user_email]" placeholder="your.email@example.com">
        </div>

        <div class="form-group">
            <label for="jobTitleInput">Job title</label>
            <input type="text" class="form-control" id="jobTitleInput" name="job[title]" placeholder="Title">
        </div>

        <div class="form-group">
            <label for="jobDescriptionInput">Job description</label>
            <textarea class="form-control" name="job[description]" id="jobDescriptionInput" cols="30" rows="5"></textarea>
        </div>

        <div class="form-group">
            <label for="jobSkillsInput">Your skills</label>
            <input type="text" class="form-control" id="jobSkillsInput" name="skills[]">
        </div>

        <button type="submit" class="btn btn-default btn-success">Create</button>
    </form>
@endsection