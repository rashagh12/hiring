@extends('layouts.app')

@section('main')

<section class="section-5 bg-2 ">
    <div class="container py-5 mt-1 pt-1">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item "><a class="nav-link"  href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Applicants</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('account.sidebar')
            </div>
            <div class="col-lg-9">
                        @include('account.message')
                        <div class="card shadow border-0 m-4">
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
                                        <th>Applied Date</th>
                                    </tr>
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $application)
                                        <tr>
                                            <td>{{ $application->user->name  }}</td>
                                            <td>{{ $application->user->email  }}</td>
                                            <td>{{ $application->user->mobile  }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                            </td>
                                        </tr> 
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3">Applicants not found</td>
                                        </tr>
                                    @endif
                                    
                                </table>
                                
                            </div>
                        </div>
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">   
function removeJob(id) {
    if (confirm("Are you sure you want to remove?")) {
        $.ajax({
            url : '{{ route("account.removeJobs") }}',
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
@endsection