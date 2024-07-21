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
                                        <h3 class="fs-4 mb-1">Categories</h3>
                                    </div>
                                    <div style="margin-top: -10px;">
                                        <a href="{{ route('admin.category.create') }}" class="btn Explore">Add Category</a>
                                    </div>
                                    
                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category )
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $category->id }}</div>
                                                
                                                </td>
                                                <td>{{ $category->name }}</td>
                                            
                                                <td>
                                                {{ $category->status }}
                                                </td>
                                                <td>
                                                    
                                                    <div class="d-flex mt-4">
                                                    <div style="margin-top: -10px; " >
                                                        <a class="btn outline me-2" href="{{ route('admin.category.edit',$category->id) }}" type="submit">Edit</a>
                                                    </div>
                                                    <form action="{{ route('admin.category.delete',$category->id) }}" method="POST">
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
                        
                        </div> 
                        
        
            </div>
        </div>
    </div>
</section>

@endsection