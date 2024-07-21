@php use App\Enums\WorkingTime; @endphp
@extends('layouts.apps')


@section('main')
    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>
                </div>
                {{-- <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select name="sort" id="sort" class="form-control">
                            <option value="1" {{ (Request::get('sort') == '1') ? 'selected' : '' }}>Latest</option>
                            <option value="0" {{ (Request::get('sort') == '0') ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>
                </div> --}}
            </div>

            <div class="row pt-5">
                @include('jobs.search-form')
                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                @if ($jobs->isNotEmpty())
                                    @foreach ($jobs as $job )
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 shadow mb-4">
                                                <div class="card-body">
                                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                                    <p>{{ Str::words( $job->description, $words=10, '...') }}</p>
                                                    <div class="bg-light p-3 border">
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i
                                                                    class="fa fa-map-marker"></i></span>
                                                            <span class="ps-1">{{ $job->company->address }}</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                            <span class="ps-1">{{ $job->working_time }}</span>
                                                        </p>
                                                        @if (!is_null($job->salary))
                                                            <p class="mb-0">
                                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                                <span class="ps-1">{{ $job->salary }}</span>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="d-grid mt-3">
                                                        <a href="{{ route('public.jobs.show',$job) }}"
                                                           class="btn Explore btn-lg">Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-md-12">
                                        {{ $jobs->withQueryString()->links() }}
                                    </div>
                                @else
                                    <p>No jobs found matching your criteria.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
{{-- @section('customJs')
<script>
    $("#searchForm").submit(function(e){
        e.preventDefault();

        var url = '{{ route("jobs") }}?';

        var keyword = $("#keyword").val();
        var location = $("#location").val();
        var category = $("#category").val();
        var experience = $("#experience").val();
        var sort = $("#sort").val();

        var checkedJobTypes = $("input:checkbox[name='job_type']:checked").map(function(){
            return $(this).val();
        }).get();

        // If keyword has a value
        if (keyword != "") {
            url += '&keyword='+keyword;
        }

        // If location has a value
        if (location != "") {
            url += '&location='+location;
        }

        // If category has a value
        if (category != "") {
            url += '&category='+category;
        }

        // If experience has a value
        if (experience != "") {
            url += '&experience='+experience;
        }

        // If user has checked job types
        if (checkedJobTypes.length > 0) {
            url += '&jobType='+checkedJobTypes;
        }

        url += '&sort='+sort;

        window.location.href=url;

    });

    $("#sort").change(function(){
        $("#searchForm").submit();
    });

</script>
@endsection --}}
