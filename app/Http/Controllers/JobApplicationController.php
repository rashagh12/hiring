<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Enums\JobStatus;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    // Admin and Employer routes

    // List all job applications
    public function index()
    {
        $applications = JobApplication::paginate(10);
        return view('job-applications.list', compact('applications'));
    }

    // Show a specific job application
    public function show(JobApplication $application)
    {
        return view('applications.show', compact('application'));
    }


    // Apply for a job
    public function store(Request $request, Job $job)
    {
        $validator = Validator::make($request->all(), [
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $application = new JobApplication();
        $application->user_id = Auth::id();
        $application->job_id = $job->id;

        if ($request->hasFile('resume')) {
            $fileName = time() . '.' . $request->resume->extension();
            $request->resume->move(public_path('resumes'), $fileName);
            $application->resume = $fileName;
        }

        $application->status = 'pending';
        $application->save();

        return redirect()->route('public.jobs.show', $job)->with('success', 'Application submitted successfully.');
    }
    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate(['status' => ['required', 'in:' . implode(',', ApplicationStatus::getValues())],]);

        $application->status = ApplicationStatus::from($request->input('status'));
        $application->save();

        return redirect()->route('employer.applications.index')->with('success', 'Application status updated successfully');
    }
}
