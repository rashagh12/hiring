@extends('layouts.app')

@section('main')

<section class="section-5 bg-2 ">
    <div class="container py-5 mt-1 pt-1">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit job</li>
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
                <form action="{{ route('admin.category.update',$category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1"> Edit Category </h3>
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="name" class="mb-2">Category Name</label>
                                        <input type="text" id="name" name="name"  class="form-control" value="{{ $category->name }}">
                                    </div>
                            </div> 
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>               
                    </div>
                </form>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection