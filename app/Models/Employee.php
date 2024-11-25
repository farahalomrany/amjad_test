<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'email', 'last_name', 'phone','company_id'];

    public function Company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
}

