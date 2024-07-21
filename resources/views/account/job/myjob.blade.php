@extends('layouts.app')

@section('main')

<section class="section-5 bg-2 ">
    <div class="container py-5 mt-1 pt-1">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ul class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboerd</li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebars')
            </div>
            <div class="col-lg-9">
                        @include('account.message')
                        <div class="card border-0 shadow mb-4 p-3">
                            <div class="card-body card-form">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="fs-4 mb-1">Jobs</h3>
                                    </div>
                                    <div style="margin-top: -10px;">
                                        <a href="{{ route('account.create') }}" class="btn btn-primary">Post a Job</a>
                                    </div>
                                    
                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Job Created</th>
                                                <th scope="col">Applicants</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            @if ($jobs->isNotEmpty())
                                            @foreach ($jobs as $job )
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $job->title }}</div>
                                                    {{-- <div class="info1">{{ $job->job_type_id->name }} . {{ $job->location }}</div> --}}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                                <td>{{ $job->applications->count() }} Applications</td>
                                                <td>
                                                    @if ($job->status == 1)
                                                    <div class="job-status text-capitalize">Active</div>
                                                    @else
                                                    <div class="job-status text-capitalize">Block</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex mt-4">
                                                    <div style="margin-top: -10px; " >
                                                        <a class="btn outline me-2" href="{{ route('account.editejob',$job->id) }}" type="submit">Edit</a>
                                                    </div>
                                                    <form action="{{ route('account.deletejob',$job->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div style="margin-top: -10px; ">
                                                        <button type="submit" class="btn Explore">Delete</button>
                                                    </div>
                                                </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $jobs->links() }}
                        </div> 


                </form>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection