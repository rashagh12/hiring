<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Enums\WorkingTime;
use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    // Admin and Employer routes

    // List all jobs
    public function index()
    {
        $jobs = Job::withCount('jobApplications')->paginate(10);
        return view('jobs.list', compact('jobs'));
    }

    // Show create job form
    public function create()
    {
        $categories = Category::all();
        $companies = auth()->user()->companies;
        $jobTypes = (WorkingTime::getValues());
        return view('jobs.create', compact('categories', 'companies', 'jobTypes'));
    }

    // Store new job
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['title' => 'required|string|max:255', 'description' => 'required|string', 'experience' => 'required|string', 'benefits' => 'nullable|string', 'responsibilities' => 'nullable|string', 'keywords' => 'nullable|string', 'is_featured' => 'required|boolean', 'status' => 'required|in:' . implode(',', JobStatus::cases()), 'working_time' => 'required|in:' . implode(',', WorkingTime::cases()), 'vacancies' => 'required|integer', 'salary' => 'required|numeric', 'company_id' => 'required|exists:companies,id', 'category_id' => 'required|exists:categories,id',]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $job = new Job(['title' => $request->title, 'description' => $request->description, 'experience' => $request->experience, 'benefits' => $request->benefits, 'responsibilities' => $request->responsibilities, 'keywords' => $request->keywords, 'is_featured' => $request->is_featured, 'status' => JobStatus::from($request->status), 'working_time' => WorkingTime::from($request->working_time), 'vacancies' => $request->vacancies, 'salary' => $request->salary, 'company_id' => $request->company_id, 'category_id' => $request->category_id,]);
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    // Show a specific job

    public function save(Request $request, Job $job)
    {
        $user = Auth::user();

        // Check if the job is already saved by the user
        if ($user->savedJobs()->where('job_id', $job->id)->exists()) {
            return redirect()->route('public.jobs.show', $job)->with('error', 'You have already saved this job.');
        }

        // Save the job
        $user->savedJobs()->attach($job->id);

        return redirect()->route('public.jobs.show', $job)->with('success', 'Job saved successfully.');

    }

    public function unsave(Request $request, Job $job)
    {
        $user = Auth::user();

        // Check if the job is already saved by the user
        if (!$user->savedJobs()->where('job_id', $job->id)->exists()) {
            return redirect()->route('public.jobs.show', $job)->with('error', 'You have not saved this job.');
        }

        // Unsave the job
        $user->savedJobs()->detach($job->id);

        return redirect()->route('public.jobs.show', $job)->with('success', 'Job unsaved successfully.');

    }

    // Show edit job form

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    // Update a job

    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    // Delete a job

    public function update(Request $request, Job $job)
    {
        $validator = Validator::make($request->all(), ['title' => 'required|string|max:255', 'description' => 'required|string', 'experience' => 'required|string', 'benefits' => 'nullable|string', 'responsibilities' => 'nullable|string', 'keywords' => 'nullable|string', 'is_featured' => 'required|boolean', 'status' => 'required|in:' . implode(',', JobStatus::cases()), 'working_time' => 'required|in:' . implode(',', WorkingTime::cases()), 'vacancies' => 'required|integer', 'salary' => 'required|numeric', 'company_id' => 'required|exists:companies,id', 'category_id' => 'required|exists:categories,id',]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $job->fill(['title' => $request->title, 'description' => $request->description, 'experience' => $request->experience, 'benefits' => $request->benefits, 'responsibilities' => $request->responsibilities, 'keywords' => $request->keywords, 'is_featured' => $request->is_featured, 'status' => JobStatus::from($request->status), 'working_time' => WorkingTime::from($request->working_time), 'vacancies' => $request->vacancies, 'salary' => $request->salary, 'company_id' => $request->company_id, 'category_id' => $request->category_id,]);
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    // Seeker routes

    // Save a job to user's saved jobs

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }

    // Public routes

    public function seekerIndex(Request $request)
    {
        $jobs = Job::with('jobApplications')->where('status', JobStatus::APPROVED)->paginate(8);
        return view('seekers.list', compact('jobs'));

    }

    public function seekerShow(Job $job)
    {
        return view('seekers.view', compact('job'));

    }

    // List public jobs
    public function publicIndex()
    {
        $jobs = Job::with('jobApplications', 'company')->where('status', JobStatus::APPROVED)->paginate(8);
        $categories = Category::all();
        return view('jobs.public-index', compact('jobs', 'categories'));
    }

    public function publicSearch(Request $request)
    {
        $query = Job::query();

        if ($request->filled('keywords')) {
            $query->where('title', 'like', '%' . $request->input('keywords') . '%')->orWhere('description', 'like', '%' . $request->input('keywords') . '%')->orWhere('keywords', 'like', '%' . $request->input('keywords') . '%')->orWhere('benefits', 'like', '%' . $request->input('keywords') . '%')->orWhere('responsibilities', 'like', '%' . $request->input('keywords') . '%');
        }

        if ($request->filled('location')) {
            $query->whereRelation('company', 'address', 'like', '%' . $request->input('location') . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('job_type')) {
            $query->where('working_time', $request->input('job_type'));
        }

        if ($request->filled('experience')) {
            $query->where('experience', '>=', $request->input('experience'));
        }

        $jobs = $query->with('jobApplications', 'company')->where('status', JobStatus::APPROVED)->paginate(8);
        $categories = Category::all();
        return view('jobs.public-index', compact('jobs', 'categories'));
    }

    // Show a specific public job
    public function publicShow(Job $job)
    {
        $job->load(['jobApplications', 'company'])->loadCount('jobApplications');
        return view('jobs.public-view', compact('job'));
    }

    public function updateStatus(Request $request, Job $job)
    {
        $request->validate(['status' => ['required', 'in:' . implode(',', JobStatus::getValues())],]);

        $job->status = JobStatus::from($request->input('status'));
        $job->save();
        Mail::to($job->company->email)->send(new JobNotificationEmail($job));
        return redirect()->route('jobs.index')->with('success', 'Job status updated successfully');
    }
}
