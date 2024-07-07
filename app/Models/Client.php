<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'marital_status_id',
        'age'
    ];

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatuses::class);
    }
}
