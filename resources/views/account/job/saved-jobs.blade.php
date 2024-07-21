@extends('layouts.app')

@section('main')

<section class="section-5 bg-2 ">
    <div class="container py-5 mt-1 pt-1">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item "><a class="nav-link"  href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('account.sidebar')
            </div>
            <div class="col-lg-9">
                        
                        <div class="card border-0 shadow mb-4 p-3">
                            <div class="card-head">
                                @include('account.message')
                            </div>
                            <div class="card-body card-form">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="fs-4 mb-1">Saved Jobs</h3>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        @if ($savedJobs->isNotEmpty()) 
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Applicants</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                    
                                        @foreach ($savedJobs as $savedJob)
                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">{{ $savedJob->job->title }}</div>
                                                <div class="info1">{{ $savedJob->job->jobType->name }} . {{ $savedJob->job->location }}</div>
                                            </td>
                                            <td>{{ $savedJob->job->applications->count() }} Applications</td>
                                            <td>
                                                @if ($savedJob->job->status == 1)
                                                <div class="job-status text-capitalize">Active</div>
                                                @else
                                                <div class="job-status text-capitalize">Block</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center mt-1">
                                                <a class="btn outline me-2" href="{{ route('jobDetail',$savedJob->id) }}" type="submit">View</a>
                                            <form action="{{ route('account.removeSavedJob',$savedJob->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn Explore me-2">Remove</button>
                                                {{-- <a class="btn btn-primary me-2" href=""  >Remove</a> --}}
                                            </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">Job saved not found</td>
                                    </tr>
                                    @endif
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $savedJobs->links() }}
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection
