<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Mail\JobNotificationEmail;
use App\Models\Job;
use App\Models\JobType;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    //this method will show jobs page
    public function index(Request $request){
        $categories  = Category::where('status',1)->get();

        $jobTypes    = JobType::where('status',1)->get();

        $jobs        = Job::where('status',1);

         // Search using keyword
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }
        // Search using location
        if(!empty($request->location)) {
            $jobs = $jobs->where('location',$request->location);
        }

         // Search using category
        if(!empty($request->category)) {
            $jobs = $jobs->where('category_id',$request->category);
        }

        $jobTypeArray = [];
        // Search using Job Type
        if(!empty($request->jobType)) {
            $jobTypeArray = explode(',',$request->jobType);

            $jobs = $jobs->whereIn('job_type_id',$jobTypeArray);
        } 

        $jobs= $jobs->with(['jobType','category']);

        if($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at','ASC');
        } else {
            $jobs = $jobs->orderBy('created_at','DESC');
        }
        $jobs=$jobs->paginate(9);

        return view('front.jobs',[
            'categories'   => $categories,
            'jobTypes'     => $jobTypes,
            'jobs'         => $jobs,
        ]);
    }

    public function detail($id){

        $job = Job::where([
            'id' => $id, 
            'status' => 1
        ])->with(['jobType','category'])->first();

        if ($job == null) {
            abort(404);
        }

        $count = SavedJob::where([
            // 'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        // fetch applicants
        $applications= JobApplication::where('job_id',$id)->with('user')->get();
        

        return view('front.jobDetail',[ 
            'job' => $job,
            'count' =>$count,
            'applications' =>$applications,
        ]);
    }


    public function applicants($id){
        $applications = JobApplication::where('job_id',$id)->with('user')->get();

        return view('admin.jobs.applied',[
            'applications' =>$applications,
        ]);
    }
    
    public function applyJob(Request $request) {
        $id = $request->id;

        $job = Job::where('id',$id)->first();

        // If job not found in db
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // you can not apply on your own job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You can not apply on your own job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // You can not apply on a job twise
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        
        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();


        // Send Notification Email to Employer
        $employer = User::where('id',$employer_id)->first();
        
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];

    


        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        $message = 'You have successfully applied.';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    
    public function updateProfilecv(Request $request) {
        // dd($request->all());

        $id = Auth::user()->id;
        // You can not apply on a job twise
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        
        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $validator = Validator::make($request->all(),[
            'cv' => 'required'
        ]);
        if ($validator->passes()) {

            $cv = $request->cv;
            $fileName= uniqid("cv_").".". $request->file('cv')->getClientOriginalExtension();
            $request->file('cv')->move(public_path("cv"),$fileName);

            File::delete(public_path('cv'.Auth::user()->cv));

            User::where('id',$id)->update(['cv' => $fileName]);

            // session()->flash('success','  successfully.');
            return redirect()->back()->with("success","added Successfully");

            // return resp

        // $data =new User();

        // $cv=$request->cv;
        // $filename=uniqid("cv_").'.'.$cv->getClientOriginalExtension();
        // $request->cv->move(public_path("cv"),$filename);
        // $data->cv=$filename;
        // $data->save();

        }

        // File::delete(public_path('cv'.Auth::user()->cv));

        // User::where('id',$id)->update(['cv' => $filename]);
        // session()->flash('success','CV Uploaded successfully.');
        // return redirect()->back();
    }

    public function savedJob(Request $request) {

        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error','Job not found');

            return response()->json([
                'status' => false,
                // 'errors' => errors()
            ]);
        }

             // Check if user already saved the job
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
    
            if ($count > 0) {
                // session()->flash('error','You already saved this job.');
    
                return redirect()->route('jobDetail',$job->id)->with("error","You already saved this job.");
            }
    
            $savedJob = new SavedJob;
            $savedJob->job_id = $id;
            $savedJob->user_id = Auth::user()->id;
            $savedJob->save();
    
            session()->flash('success','You have successfully saved the job.');
    
            return response()->json([
                'status' => true,
            ]);
        // return view('account.job.saved-jobs');

    }

}
