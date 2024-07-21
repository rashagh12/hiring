@php use Carbon\Carbon; @endphp
@extends('layouts.apps')

@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('public.jobs.index') }}" class="nav-link"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="card-head">
                                <div id="message"></div>
                                @include('account.message')
                            </div>
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    <div class="jobs_conetent">
                                        <h4>{{ $job->title }}</h4>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p><i class="fa fa-map-marker"></i>{{ $job->company->address }}</p>
                                            </div>
                                            <div class="location">
                                                <p><i class="fa fa-clock-o"></i>{{ $job->working_time->value }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now {{ ($job->job_applications_count > 0) ? 'saved-job' : '' }}">
                                        <a class="heart_mark" href="javascript:void(0);"
                                           onclick="savedJob({{ $job->id }})">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            @if (!empty($job->description))
                                <div class="single_wrap">
                                    <h4>Job Description</h4>
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            @endif

                            @if (!empty($job->responsibilities))
                                <div class="single_wrap">
                                    <h4>Responsibilities</h4>
                                    {!! nl2br(e($job->responsibilities)) !!}
                                </div>
                            @endif

                            @if (!empty($job->qualifications))
                                <div class="single_wrap">
                                    <h4>Qualifications</h4>
                                    {!! nl2br(e($job->qualifications)) !!}
                                </div>
                            @endif

                            @if (!empty($job->benefits))
                                <div class="single_wrap">
                                    <h4>Benefits</h4>
                                    <p>{{ $job->benefits }}</p>
                                </div>
                            @endif

                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">
                                @if (Auth::check())
                                    @if(auth()->user()->isSeeker())
                                        @if (auth()->user()->savedJobs()->where('job_id', $job->id)->exists())
                                            <form action="{{ route('seeker.jobs.unsave', $job->id) }}" method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Unsave</button>
                                            </form>
                                        @else
                                            <form action="{{ route('seeker.jobs.save', $job->id) }}" method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </form>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#applyModal"
                                               class="btn Explore">Apply</a>
                                        @endif
                                    @endif
                                @else
                                    <a href="javascript:void(0);" class="btn Explore disabled">Login to Apply</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (Auth::check() && (auth()->user()->isAdmin() || auth()->user()->isEmployer()))
                        <div class="card shadow border-0 mt-4">
                            <div class="job_details_header">
                                <div class="single_jobs white-bg d-flex justify-content-between">
                                    <div class="jobs_left d-flex align-items-center">
                                        <div class="jobs_conetent">
                                            <h4>Applicants</h4>
                                        </div>
                                    </div>
                                    <div class="jobs_right"></div>
                                </div>
                            </div>
                            <div class="descript_wrap white-bg">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>CV</th>
                                        <th>Applied Date</th>
                                    </tr>
                                    @if ($job->jobApplications->isNotEmpty())
                                        @foreach ($job->jobApplications as $application)
                                            <tr>
                                                <td>{{ $application->user->name }}</td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>{{ $application->user->phone }}</td>
                                                <td><a href="{{ url('resumes/', $application->resume) }}"
                                                       class="nav-link">{{ $application->resume }}</a></td>
                                                <td>{{ Carbon::parse($application->created_at)->format('d M, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No applicants found</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_summary">
                            <div class="summary_header ps-3  pb-1 pt-4">
                                <h3>Job Summary</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on:
                                        <span>{{ Carbon::parse($job->created_at)->format('d M, Y') }}</span>
                                    </li>
                                    <li>Vacancy: <span>{{ $job->vacancies }}</span></li>
                                    @if (!empty($job->salary))
                                        <li>Salary: <span>{{ $job->salary }}</span></li>
                                    @endif
                                    <li>Location: <span>{{ $job->company->address }}</span></li>
                                    <li>Job Nature: <span>{{ $job->working_time->value }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_summary">
                            <div class="summary_header ps-3 pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $job->company->name }}</span></li>
                                    <li>Location: <span>{{ $job->company->address }}</span></li>
                                    @if (!empty($job->company->website))
                                        <li>Website: <span><a href="{{$job->company->website}}">{{ $job->company->website }}</a></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="applyModalLabel">Upload your CV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="applyForm" id="applyForm" action="{{ route('seeker.jobs.apply', $job->id) }}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="resume" class="form-label">Enter Your CV</label>
                            <input type="file" class="form-control @error('resume') is-invalid @enderror" required
                                   id="resume" name="resume">
                            @error('resume')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn Explore mx-3">Upload and Apply</button>
                            <button type="button" class="btn outline" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
    <script>
        @if ($errors->has('resume'))
        $(document).ready(function () {
            $('#applyModal').modal('show');
        });
        @endif
    </script>
@endsection
