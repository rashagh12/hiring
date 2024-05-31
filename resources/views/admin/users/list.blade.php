@extends('layouts.app')

@section('main')

<section class="section-5 bg-2 ">
    <div class="container py-5 mt-1 pt-1">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
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
                                        <h3 class="fs-4 mb-1">Users</h3>
                                    </div>
                                    {{-- <div style="margin-top: -10px;">
                                        <a href="{{ route('account.create') }}" class="btn btn-primary">Post a Job</a>
                                    </div> --}}
                                    
                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Emial</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Tools</th>
                                                {{-- <th scope="col">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            {{-- @if ($jobs->isNotEmpty()) --}}
                                            @foreach ($users as $user )
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $user->id }}</div>
                                                    {{-- <div class="info1">{{ $job->job_type_id->name }} . {{ $job->location }}</div> --}}
                                                </td>
                                                <td>{{ $user->name }}</td>
                                            
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                                <td>
                                                    {{ $user->mobile }}
                                                </td>
                                                <td>
                                                    
                                                    <div class="d-flex mt-4">
                                                    <div style="margin-top: -10px; " >
                                                        <a class="btn btn-outline-primary me-2" href="{{ route('admin.users.edite',$user->id) }}" type="submit">Edit</a>
                                                    </div>
                                                    <form action="{{ route('admin.users.delete',$user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div style="margin-top: -10px; ">
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </div>
                                                </form>
                                                    </div>               
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            {{ $users->links() }}
                        </div> 

        
            </div>
        </div>
    </div>
</section>

@endsection