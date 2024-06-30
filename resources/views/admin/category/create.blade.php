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
                    <form action="{{ route('admin.category.save') }}" method="post">
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Add Category</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="mb-2">Category Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Category Name" id="name" name="name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn Explore">Add Category</button>
                            </div>
                        </div>
                    </form>
            </div>
            </div>
        </div>
    </div>
</section>

@endsection