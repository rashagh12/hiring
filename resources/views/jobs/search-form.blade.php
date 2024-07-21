<div class="col-md-4 col-lg-3 sidebar mb-4">
    <form action="{{ route('public.jobs.search') }}" method="POST" id="searchForm" name="searchForm">
        @csrf
        <div class="card border-0 shadow p-4">
            <div class="mb-4">
                <h2>Keywords</h2>
                <input type="text" value="{{ request()->get('keywords') }}" placeholder="Keywords" id="keywords" name="keywords" class="form-control">
            </div>

            <div class="mb-4">
                <h2>Location</h2>
                <input type="text" value="{{ request()->get('location') }}" placeholder="Location" name="location" id="location" class="form-control">
            </div>

            <div class="mb-4">
                <h2>Category</h2>
                <select name="category" id="category" class="form-control">
                    <option value="">Select a Category</option>
                    @if ($categories)
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->get('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="mb-4">
                <h2>Job Type</h2>
                @foreach (App\Enums\WorkingTime::getValues() as $jobType)
                    <div class="form-check mb-2">
                        <input class="form-check-input" name="job_type[]" type="checkbox" value="{{ $jobType }}" id="job_type_{{ $jobType }}"
                            {{ is_array(request()->get('job_type')) && in_array($jobType, request()->get('job_type')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="job_type_{{ $jobType }}">{{ $jobType }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                <h2>Experience</h2>
                <select name="experience" id="experience" class="form-control">
                    <option value="">Select Experience</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request()->get('experience') == $i ? 'selected' : '' }}>{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10_plus" {{ request()->get('experience') == '10_plus' ? 'selected' : '' }}>10+ Years</option>
                </select>
            </div>

            <button class="btn Explore btn-lg" type="submit">Search</button>
            <a href="{{ route('public.jobs.index') }}" class="btn outline mt-3">Reset</a>
        </div>
    </form>
</div>
