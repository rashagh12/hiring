<?php

namespace App\Models;

use App\Enums\JobStatus;
use App\Enums\WorkingTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'experience', 'benefits', 'responsibilities',
        'keywords', 'is_featured', 'status', 'working_time', 'vacancies',
        'salary', 'company_id', 'category_id'
    ];

    protected $casts = [
        'working_time' => WorkingTime::class,
        'status' => JobStatus::class,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

