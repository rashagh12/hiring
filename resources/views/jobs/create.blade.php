@extends('layouts.apps')

@section('main')

    <section class="section-5 bg-2 ">
        <div class="container py-5 mt-1 pt-1">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create Job</li>
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
                    <form action="{{ route('jobs.store') }} " method="POST">
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Create Job</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                               class="form-control" required>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control" required>
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" name="jobType" id="jobType" required>
                                            <option>Select job type</option>
                                            @foreach ($jobTypes as $jobType)
                                                <option value="{{ $jobType }}">{{ $jobType }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy"
                                               class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                               class="form-control" required>
                                    </div>

                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" required
                                              value="{{ old('description') }}" rows="5"
                                              placeholder="Description"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5"
                                              required value='{{ old('benefits') }}' placeholder="Benefits"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" required
                                              value='{{ old('responsibility') }}' cols="5" rows="5"
                                              placeholder="Responsibility"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="qualifications" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" required
                                              cols="5" value='{{ old('qualifications') }}' rows="5"
                                              placeholder="Qualifications"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="experience" class="mb-2">Experience <span class="req">*</span></label>
                                    <select name="experience" id="experience" class="form-control" required>
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Years</option>
                                        <option value="3">3 Years</option>
                                        <option value="4">4 Years</option>
                                        <option value="5">5 Years</option>
                                        <option value="6">6 Years</option>
                                        <option value="7">7 Years</option>
                                        <option value="8">8 Years</option>
                                        <option value="9">9 Years</option>
                                        <option value="10">10 Years</option>
                                        <option value="10_plus">10+ Years</option>
                                    </select>
                                </div>


                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                           class="form-control" required>
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="col-12">
                                        <select name="company" class="form-select">
                                            <option value="">Select a Category</option>
                                            @foreach($companies as $company) @endforeach
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn Explore">Save Job</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        </div>
    </section>

@endsection
