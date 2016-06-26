@extends('layout')

@section('content')

    <div class="clearfix">
        <div class="pull-right">
            <div><b>You can also delete this job</b></div>
            <form action="{{ route('job.destroy', ['id' => $job->id, 'job_access_token' => $job_access_token]) }}" method="POST">
                <input type="hidden" value="DELETE" name="_method">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger pull-right">Delete</button>
            </form>
        </div>
    </div>

    <form action="{{ route('job.update', ['id' => $job->id, 'job_access_token' => $job_access_token]) }}" method="POST">
        <input type="hidden" value="PUT" name="_method">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="jobUserEmailInput">Your email</label>
            <input type="text" class="form-control" id="jobUserEmailInput" name="job[user_email]" placeholder="your.email@example.com" value="{{ $job->user_email or '' }}">
        </div>

        <div class="form-group">
            <label for="jobTitleInput">Job title</label>
            <input type="text" class="form-control" id="jobTitleInput" name="job[title]" placeholder="Title" value="{{ $job->title or '' }}">
        </div>

        <div class="form-group">
            <label for="jobDescriptionInput">Job description</label>
            <textarea class="form-control" name="job[description]" id="jobDescriptionInput" cols="30" rows="5">{{ $job->description or '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="jobSkillsInput">Your skills</label>
            {{--<input type="text" class="form-control" id="jobSkillsInput" name="skills[]">--}}
            <select id="jobSkillsInput" class="form-control" name="skills[]" multiple="multiple">
                @foreach($job->skills as $skill)
                    <option selected value="{{ $skill->id }}">{{ $skill->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-default btn-success">Update</button>
    </form>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#jobSkillsInput").select2({
                tags: true
            });
        });
    </script>
@endsection