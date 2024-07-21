@php use App\Enums\JobStatus; @endphp
@php use Carbon\Carbon; @endphp
@extends('layouts.apps')

@section('main')

    <section class="section-5 bg-2">
        <div class="container py-5 mt-1 pt-1">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Jobs</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ route('jobs.create') }}" class="btn Explore">Post a Job</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Tools</th>
                                    </tr>
                                    </thead>
                                    <tbody class="border-0">
                                    @if ($jobs->isNotEmpty())
                                        @foreach ($jobs as $job)
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $job->id }}</div>
                                                </td>
                                                <td><a class="nav-link"
                                                       href="{{ route('public.jobs.show', $job->id) }}">{{ $job->title }}</a>
                                                </td>
                                                <td><a class="nav-link"
                                                       href="{{ route('public.jobs.show', $job->id) }}">{{ $job->job_applications_count }}
                                                        Applicants</a></td>
                                                <td>
                                                    <form action="{{route('jobs.updateStatus',$job)}}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" class="form-select"
                                                                onchange="this.form.submit()">
                                                            @foreach(JobStatus::getValues() as $status)
                                                                <option
                                                                    value="{{$status}}" @selected($job->status->value==$status) >
                                                                    {{ucfirst($status)}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex mt-4">{{ Carbon::parse($job->created_at)->format('d M, Y') }}</div>
                                                </td>

                                                <td>
                                                    <div class="d-flex mt-4">
                                                        <div style="margin-top: -10px;">
                                                            <a class="btn outline me-2"
                                                               href="{{ route('jobs.edit', $job->id) }}" type="submit">Edit</a>
                                                        </div>
                                                        <form action="{{ route('jobs.destroy', $job->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div style="margin-top: -10px;">
                                                                <button type="submit" class="btn Explore">Delete
                                                                </button>
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
                </div>
            </div>
        </div>
    </section>

@endsection
