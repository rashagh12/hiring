@extends('layouts.app')

@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs') }}" class="nav-link"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
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
                                                <p><i class="fa fa-map-marker"></i>{{ $job->location }}</p>
                                            </div>
                                            <div class="location">
                                                <p><i class="fa fa-clock-o"></i>{{ $job->jobType->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now {{ ($count == 1) ? 'saved-job' : '' }}">
                                        <a class="heart_mark" href="javascript:void(0);" onclick="savedJob({{ $job->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            @if (!empty($job->description))
                                <div class="single_wrap">
                                    <h4>Job description</h4>
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            @endif

                            @if (!empty($job->responsibility))
                                <div class="single_wrap">
                                    <h4>Responsibility</h4>
                                    {!! nl2br(e($job->responsibility)) !!}
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
                                <a href="#" onclick="savedJob({{ $job->id }});" class="btn outline">Save</a>

                                @if (Auth::check())
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalcv" class="btn Explore">Apply</a>
                                @else
                                    <a href="javascript:void(0);" class="btn Explore disabled">Login to Apply</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (Auth::check() && Auth::user()->isAdmin())
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
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td>{{ $application->user->name }}</td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>{{ $application->user->mobile }}</td>
                                                <td><a href="{{ route('admin.users.cv', $application->user->id) }}" class="nav-link">{{ $application->user->cv }}</a></td>
                                                <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Applicants not found</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summary</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on: <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                    <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                    @if (!empty($job->salary))
                                        <li>Salary: <span>{{ $job->salary }}</span></li>
                                    @endif
                                    <li>Location: <span>{{ $job->location }}</span></li>
                                    <li>Job Nature: <span>{{ $job->jobType->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $job->company_name }}</span></li>
                                    <li>Location: <span>{{ $job->company_location }}</span></li>
                                    @if (!empty($job->company_website))
                                        <li>Website: <span>{{ $job->company_website }}</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModalcv" tabindex="-1" aria-labelledby="exampleModalLabelcv" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabelcv">Upload your CV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="ProfilePicForm" id="ProfilePicForm" action="{{ route('account.updateProfilecv', ['job_id' => $job->id]) }}" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="marital" class="form-label">Your Marital Status*</label>
                                <select name="marital" id="marital" class="form-control">
                                    @foreach ($maritalstatus as $maritalstatu)
                                        <option value="{{ $maritalstatu->id }}">{{ $maritalstatu->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Your Age*</label>
                                <input type="text" class="form-control @error('age') is-invalid @enderror" required name="age" id="age">
                                @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="cv" class="form-label">Enter Your CV</label>
                            <input type="file" class="form-control" id="cv" name="cv">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn Explore mx-3">Upload</button>
                            <button type="button" class="btn outline" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script type="text/javascript">
        function savedJob(id) {
            $.ajax({
                url: '{{ route("savedJob") }}',
                type: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    $('#message').html('<div class="alert alert-danger">An error occurred: ' + xhr.responseJSON.message + '</div>');
                }
            });
        }
    </script>
@endsection
