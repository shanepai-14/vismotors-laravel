<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDependent extends Model
{
    use HasFactory;

    protected $fillable = [
        '1dependent_name',
        '1year_or_grade',
        '2dependent_name',
        '2year_or_grade',
        '3dependent_name',
        '3year_or_grade',
    ];
}
