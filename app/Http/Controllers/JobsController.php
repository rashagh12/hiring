<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Mail\JobNotificationEmail;
use App\Models\Client;
use App\Models\Job;
use App\Models\JobType;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\MaritalStatuses;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    // Show jobs page
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1);

        // Search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        // Search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // Search using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // Search using Job Type
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        $jobs = $jobs->with(['jobType', 'category']);

        // Sort jobs
        $jobs = $jobs->orderBy('created_at', $request->sort == '0' ? 'ASC' : 'DESC');

        $jobs = $jobs->paginate(9);
        $maritalStatus = MaritalStatuses::all();

        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'maritalStatus' => $maritalStatus
        ]);
    }

    public function detail($id)
    {
        $job = Job::where(['id' => $id, 'status' => 1])
            ->with(['jobType', 'category'])
            ->first();

        if ($job == null) {
            abort(404);
        }

        $count = SavedJob::where('job_id', $id)->count();
        $applications = JobApplication::where('job_id', $id)->with('user')->get();

        return view('front.jobDetail', [
            'job' => $job,
            'count' => $count,
            'applications' => $applications,
        ]);
    }

    public function applicants($id)
    {
        $applications = JobApplication::where('job_id', $id)->with('user')->get();

        return view('admin.jobs.applied', [
            'applications' => $applications,
        ]);
    }

    public function applyJob(Request $request)
    {
        $id = $request->id;
        $job = Job::find($id);

        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return response()->json(['status' => false, 'message' => $message]);
        }

        $employerId = $job->user_id;

        if ($employerId == Auth::user()->id) {
            $message = 'You cannot apply for your own job.';
            session()->flash('error', $message);
            return response()->json(['status' => false, 'message' => $message]);
        }

        $jobApplicationCount = JobApplication::where(['user_id' => Auth::user()->id, 'job_id' => $id])->count();

        if ($jobApplicationCount > 0) {
            $message = 'You already applied for this job.';
            session()->flash('error', $message);
            return response()->json(['status' => false, 'message' => $message]);
        }

        $application = JobApplication::create([
            'job_id' => $id,
            'user_id' => Auth::user()->id,
            'employer_id' => $employerId,
            'applied_date' => now()
        ]);

        // Send Notification Email to Employer
        $employer = User::find($employerId);
        $mailData = ['employer' => $employer, 'user' => Auth::user(), 'job' => $job];
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        $message = 'You have successfully applied.';
        session()->flash('success', $message);

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function updateProfilecv(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $validator = Validator::make($request->all(), [
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'job_id' => 'required|exists:jobs,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cv = $request->file('cv');
        $fileName = uniqid("cv_") . "." . $cv->getClientOriginalExtension();
        $cv->move(public_path("cv"), $fileName);

        if ($user->cv) {
            File::delete(public_path('cv/' . $user->cv));
        }

        $user->update(['cv' => $fileName]);

        session()->flash('success', 'CV added successfully.');
        return redirect()->route('job.detail', ['id' => $request->job_id]);
    }


    public function savedJob(Request $request)
    {
        $id = $request->id;
        $job = Job::find($id);

        if ($job == null) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found'
            ], 404);
        }

        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($count > 0) {
            return response()->json([
                'status' => false,
                'message' => 'You already saved this job.'
            ], 400);
        }

        SavedJob::create([
            'job_id' => $id,
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'You have successfully saved the job.'
        ], 200);
    }

}
