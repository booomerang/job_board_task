<h3>Thank you for creating job post on our site!</h3>

<br/>

<div>Your job post's data was:</div>
<p>Job title: {{ $job->title }}</p>
<p>Job description: {{ $job->description }}</p>

<br/>

<div>Now you can access for editing/deleting job post by this link:</div>
<p>{{ route('job.edit', ['id' => $job->id, 'job_access_token' => $job->job_access_token]) }}</p>