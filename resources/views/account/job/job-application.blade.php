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
                                        <h3 class="fs-4 mb-1">Jobs Applied</h3>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        @if ($jobApplications->isNotEmpty()) 
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Applied Date</th>
                                                <th scope="col">Applicants</th>
                                                <th scope="col">Status</th>
                                                {{-- <th scope="col">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                    
                                        @foreach ($jobApplications as $jobApplication)
                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">{{ $jobApplication->job->title }}</div>
                                                <div class="info1">{{ $jobApplication->job->jobType->name }} . {{ $jobApplication->job->location }}</div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($jobApplication->applied_date)->format('d M, Y') }}</td>
                                            <td>{{ $jobApplication->job->applications->count() }} Applications</td>
                                            <td>
                                                @if ($jobApplication->job->status == 1)
                                                <div class="job-status text-capitalize">Active</div>
                                                @else
                                                <div class="job-status text-capitalize">Block</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center mt-1">
                                                <a class="btn outline me-2" href="{{ route('jobDetail',$jobApplication->id) }}" type="submit">View</a>
                                            <form action="{{ route('account.removeJobs',$jobApplication->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn Explore me-2 d-flex justify-content-center" onclick="removeJob({{ $jobApplication->id }})">Remove</button>
                                            </form>
                                        </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">Job Applications not found</td>
                                    </tr>
                                    @endif
                                    
                                    
                                </tbody>                                
                            </table>
                        </div>
                        <div>
                            {{ $jobApplications->links() }}
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection
{{-- @section('customJs')
<script type="text/javascript">   
function removeJob(id) {
    if (confirm("Are you sure you want to remove?")) {
        $.ajax({
            url : '{{ route("account.removeJobs",$jobApplication->id) }}',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                window.location.href='{{ route("account.jobApplication") }}';
            }
        });
    } 
}
</script>
@endsection --}}