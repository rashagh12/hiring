<?php

namespace App\Models;

use App\Enums\MaritalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'profile_picture', 'phone', 'address',
        'birth_date', 'age', 'marital_status', 'role_id'
    ];
    protected $casts = [
        'marital_status' => MaritalStatus::class,
    ];

    protected $hidden = ['password'];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Check if the user has an admin role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    /**
     * Check if the user has an employer role.
     *
     * @return bool
     */
    public function isEmployer()
    {
        return $this->role->name === 'employer';
    }

    /**
     * Check if the user has a seeker role.
     *
     * @return bool
     */
    public function isSeeker()
    {
        return $this->role->name === 'seeker';
    }

    public function companies()
    {
        return $this->hasMany(company::class);
    }
}

