<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\jobType;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\JobApplication;
use App\Models\SavedJob;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::orderBy('name','ASC')->get();
        $newCategories = Category::where('status',1)->orderBy('name','ASC')->get();

        $featuredJobs = Job::where('status',1)
        ->orderBy('created_at','DESC')
        ->with('jobType')
        ->where('isFeatured',1)->get();


        $latestJobs = Job::where('status',1)
                        ->with('jobType')
                        ->orderBy('created_at','DESC')
                        ->get();

        $data=[
            'categories'     => $categories,
            'newCategories'  => $newCategories,
            'featuredJobs'   => $featuredJobs,
            'latestJobs'     => $latestJobs,
        ];
        return view('home',$data);
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }

    public function profile(){

        $id = Auth::user()->id;

        $user = User::where('id',$id)->first();
        return view('account.profile',[
            'user' => $user,
        ]);
    }


    public function updateprofile(Request $request){

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);


        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success','Profile updated successfully.');

            // return response()->json([
            //     'status' => true,
            //     'errors' => []
            // ]);
            return redirect()->route('account.profile');

        }
        else {
            // return response()->json([
            //     'status' => false,
            //     'errors' => $validator->errors()
            // ]);
            session()->flash('errots',$validator->errors());
            return redirect()->route('account.profile')->with('errots',$validator->errors());
        }
    }



    public function updateProfilePic(Request $request) {
        //dd($request->all());

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg'
        ]);

        if ($validator->passes()) {

            $image = $request->image;
            $imageName= uniqid("prof_").".". $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path("profile_pic"),$imageName);


            // Create a small thumbnail
            $sourcePath = public_path('/profile_pic/'.$imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));


            // Delete Old Profile Pic
            File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));
            File::delete(public_path('profile_pic'.Auth::user()->image));

            User::where('id',$id)->update(['image' => $imageName]);

            session()->flash('success','Profile picture updated successfully.');

            // return response()->json([
            //     'status' => true,
            //     'errors' => []
            // ]);

            return redirect()->route('account.profile');

        } else {
            return redirect()->route('account.update')->with("errors","This should be an image");
        }
    }

    public function createJob(){

        $categories = Category::orderBy('name','ASC')->where('status',1)->get();

        $jobTypes =  jobType::orderBy('name','ASC')->where('status',1)->get();


        return view('account.job.createjob',[
            'categories' =>  $categories,
            'jobTypes' =>  $jobTypes,
        ]);
    }


    public function saveJob(Request $request) {

        $rules= [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'salary'     => 'required',
            'company_name' => 'required|min:3|max:75',
            'benefits' => 'required',
            'description' => 'required',
            'responsibility' => 'required',
            'qualifications' =>'required',
            'keywords' => 'required',
            'experience'=> 'required',
            'company_location'=>'required',
            'company_name' => 'required',

        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {

        $jobs=new Job();
        $jobs->title        = $request->title;
        $jobs->category_id = $request->category;
        $jobs->job_type_id  = $request->jobType;
        $jobs->user_id = Auth::user()->id;
        $jobs->vacancy      = $request->vacancy;
        $jobs->location     = $request->location;
        $jobs->description  = $request->description;
        $jobs->salary       =$request->salary;
        $jobs->company_name = $request->company_name;
        $jobs->benefits     = $request->benefits;
        $jobs->responsibility = $request->responsibility;
        $jobs->qualifications = $request->qualifications;
        $jobs->keywords     = $request->keywords;
        $jobs->experience   = $request->experience;
        $jobs->company_location=$request->company_location;
        $jobs->company_name      = $request->company_name;
        $jobs->save();

        session()->flash('success','Job added successfully.');

        return redirect()->route('account.myJobs',$jobs->id) ;
        }
        else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function myJobs($id){
        $jobs = Job::where('user_id',Auth::user()->id)->with('jobType')

        ->orderBy('created_at','DESC')->paginate(10);
        return view('account.job.myjob',[
            'jobs' =>$jobs,
        ]);
    }

    public function editejob(Request $request, $id){

        // $job = Job::findorFail($id);
        // compact('job')
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();

        $jobTypes =  jobType::orderBy('name','ASC')->where('status',1)->get();

        $job=Job::where([
            'user_id' => Auth::user()->id,
            'id'      =>$id
        ])->first();

        if ($job == null) {
            abort(404);
        }

        return view('account.job.editejob',[
            'categories' =>  $categories,
            'jobTypes' =>  $jobTypes,
            'job' => $job,
        ]);
    }

    public function updatejob(Request $request , $id) {

        $rules= [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'salary'     => 'required',
            'benefits' => 'required',
            'description' => 'required',
            'responsibility' => 'required',
            'qualifications' =>'required',
            'keywords' => 'required',
            'experience'=> 'required',


        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {

        $jobs= Job::findorFail($id);
        $jobs->title        = $request->title;
        $jobs->category_id = $request->category;
        $jobs->job_type_id  = $request->jobType;
        $jobs->user_id = Auth::user()->id;
        $jobs->vacancy      = $request->vacancy;
        $jobs->location     = $request->location;
        $jobs->description  = $request->description;
        $jobs->salary       =$request->salary;
        $jobs->benefits     = $request->benefits;
        $jobs->responsibility = $request->responsibility;
        $jobs->qualifications = $request->qualifications;
        $jobs->keywords     = $request->keywords;
        $jobs->experience   = $request->experience;
        $jobs->save();

        session()->flash('success','Job updated successfully.');

        return redirect()->route('account.myJobs',$jobs->id) ;
        }
        else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function deletejob($id){

        $job = Job::find($id);
        // Job::destroy($id);
        $job->delete();
        return redirect()->route('account.create');

    }

    public function jobApplication(){
        $jobApplications = JobApplication::where('user_id',Auth::user()->id)
        ->with(['job','job.jobType','job.applications'])
        ->orderBy('created_at','DESC')
        ->paginate(10);
        return view('account.job.job-application',[
            'jobApplications' => $jobApplications,
        ]);
    }

    public function removeJobs($id){
        $jobApplication= JobApplication::findOrFail($id)->delete();
        if ($jobApplication == null) {
        return redirect()->route('account.jobApplication')->with('error','Job application not found');
        }

        return redirect()->route('account.jobApplication')->with('success','Job application removed successfully.');



    }

    public function savedJobs(){
        // $jobApplications = JobApplication::where('user_id',Auth::user()->id)
        // ->with(['job','job.jobType','job.applications'])
        // ->orderBy('created_at','DESC')
        // ->paginate(10);

        $savedJobs = SavedJob::where([
            'user_id' => Auth::user()->id
        ])->with(['job','job.jobType','job.applications'])
        ->orderBy('created_at','DESC')
        ->paginate(10);

        return view('account.job.saved-jobs',[
            'savedJobs' => $savedJobs,
        ]);
    }



    public function removesavedJobs($id){

        $savedJob= SavedJob::findOrFail($id)->delete();
        if ($savedJob == null) {
            // session()->flash('error','Job not found');
        return redirect()->route('account.savedJobs')->with('error','Job not found');
        }

        // SavedJob::findOrFail($id)->delete();
        // session()->flash('success','Job removed successfully.');

        return redirect()->route('account.savedJobs')->with('success','Job removed successfully.');


    }


}
