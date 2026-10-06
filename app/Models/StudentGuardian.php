<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentGuardian extends Pivot
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'student_guardians';

    protected $guarded = [];
}
