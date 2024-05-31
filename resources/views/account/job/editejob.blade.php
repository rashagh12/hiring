@extends('layouts.app')

@section('main')

<section class="section-5 bg-2 ">
    <div class="container py-5 mt-1 pt-1">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebars')
            </div>
            <div class="col-lg-9">
                        @include('account.message')
                <form action="{{ route('account.updatejob',$job->id) }} " method="POST">
                    @csrf
                    @method('PUT')
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1"> Edit Job details </h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text"  id="title" name="title" class="form-control" value="{{ $job->title }}">
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                            <option {{ ($job->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" name="jobType" id="jobType">
                                            <option>Select job type</option>
                                            @if ($jobTypes->isNotEmpty())
                                            @foreach ($jobTypes as $jobType)
                                            <option {{ ($job->job_type_id == $jobType->id) ? 'selected' : '' }} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1"  id="vacancy" name="vacancy" class="form-control" value="{{ $job->vacancy }}">
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="salary" class="mb-2">Salary</label>
                                        <input type="text" id="salary" name="salary"  class="form-control" value="{{ $job->salary }}">
                                    </div>
        
                                    <div class="mb-4 col-md-6">
                                        <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text"  id="location" name="location"  class="form-control" value="{{ $job->location }}">
                                    </div>
                                </div>
        
                                <div class="mb-4">
                                    <label for="description" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"  >{{ $job->description }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="benefits" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" >{{ $job->benefits }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="responsibility" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility"  cols="5" rows="5" >{{ $job->responsibility }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="qualifications" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5"  rows="5" >{{ $job->qualifications }}</textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="experience" class="mb-2">Experience <span class="req">*</span></label>
                                    <select name="experience" id="experience" class="form-control">
                                        <option value="1" {{ ($job->experience == 1) ? 'selected' : '' }}>1 Year</option>
                                        <option value="2" {{ ($job->experience == 2) ? 'selected' : '' }}>2 Years</option>
                                        <option value="3" {{ ($job->experience == 3) ? 'selected' : '' }}>3 Years</option>
                                        <option value="4" {{ ($job->experience == 4) ? 'selected' : '' }}>4 Years</option>
                                        <option value="5" {{ ($job->experience == 5) ? 'selected' : '' }}>5 Years</option>
                                        <option value="6" {{ ($job->experience == 6) ? 'selected' : '' }}>6 Years</option>
                                        <option value="7" {{ ($job->experience == 7) ? 'selected' : '' }}>7 Years</option>
                                        <option value="8" {{ ($job->experience == 8) ? 'selected' : '' }}>8 Years</option>
                                        <option value="9" {{ ($job->experience == 9) ? 'selected' : '' }}>9 Years</option>
                                        <option value="10" {{ ($job->experience == 10) ? 'selected' : '' }}>10 Years</option>
                                        <option value="10_plus" {{ ($job->experience == '10_plus') ? 'selected' : '' }}>10+ Years</option>
                                    </select>
                                </div>
                                
        
                                <div class="mb-4">
                                    <label for="keywords" class="mb-2">Keywords<span class="req">*</span></label>
                                    <input type="text" id="keywords" name="keywords" value="{{ $job->keywords }}" class="form-control">
                                </div>
                            </div> 
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>               
                    </div>
                </form>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection