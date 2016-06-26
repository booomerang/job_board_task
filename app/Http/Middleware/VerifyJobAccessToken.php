<?php

namespace App\Http\Middleware;

use App\Models\Job;
use Closure;

class VerifyJobAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jobId = $request->route()->getParameter('job'); // get id of the job from route

        if (
            !$request->input('job_access_token') ||
            is_null(Job::where('id', $jobId)->where('job_access_token', $request->input('job_access_token'))->first())
        ) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
