<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Http\Request;

use App\Http\Requests;

class JobController extends Controller
{

    /**
     * @var \Illuminate\Mail\Mailer
     */
    protected $mailer;

    public function __construct(MailerContract $mailer)
    {
        $this->mailer = $mailer;

        $this->middleware('job_access', ['only' => [
            'edit',
            'update',
            'destroy'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::orderBy('updated_at', 'desc')->take(6)->get();
        return view('jobs.index', ['index' => true, 'jobs' => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'job.title' => 'required|max:255',
            'job.description' => 'required',
            'job.user_email' => 'required|email',
        ]);

        $skills = $request->input('skills');
        $skillsIds = [];
        foreach($skills as $skill) {
            $skillsIds[] = Skill::insertGetId([
                'name' => $skill
            ]);
        }

        // Should been made not here, should been made using repositories or another class using TokenRepositoryInterface
        $jobAccessToken = $this->generateToken();

        $job = new Job($request->input('job'));
        $job->job_access_token = $jobAccessToken;
        $result = $job->save();

        if ($result) {
            flash()->success('The job post successfully created!');
            $request->session()->flash('job_created.link', route('job.edit', [
                'id' => $job->id,
                'job_access_token' => $jobAccessToken,
            ]));

            $this->mailer->queue('emails.jobposting', ['job'=>$job], function ($message) use ($job) {
                $message->from('hello@cooljobboard.com', 'Cool Job Board');
                $message->to($job->user_email)->subject('Thank you for posting a job!');
            });


            $job->skills()->attach($skillsIds);
        }

        return redirect()->route('job.show', ['id' => $job->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', ['job' => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.edit', ['job' => $job, 'job_access_token' => $job->job_access_token]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->fill($request->input('job'));
        $result = $job->save();

        $skills = $request->input('skills');

        $skillsIds = [];
        foreach($skills as $skill) {
            if (ctype_digit($skill)) {
                $skillsIds[] = (int) $skill;
            } else {
                $skillsIds[] = Skill::insertGetId([
                    'name' => $skill
                ]);
            }
        }

        if ($result != false) {
            flash()->success('The job post successfully updated!');

            if (!empty($skillsIds)) {
                $job->skills()->sync($skillsIds);
            }
        } else {
            flash()->error('Something went wrong while saving!');
        }

        return redirect()->route('job.edit', ['id' => $job->id, 'job_access_token' => $job->job_access_token]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->skills()->detach();
        $result = $job->delete();

        if ($result != false) {
            flash()->success('The job post successfully deleted!');
        } else {
            flash()->error('Something went wrong while deleting!');
        }

        return redirect()->route('job.index');
    }

    protected function generateToken()
    {
        //return hash_hmac('sha256', str_random(20), config('app.key'));
        return str_random(20);
    }
}