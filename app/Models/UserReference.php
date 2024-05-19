<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReference extends Model
{
    use HasFactory;

    protected $fillable = [
        '1reference_name',
        '1relationship',
        '1address',
        '1source_of_income',
        '2cellphone_number',
        '2reference_name',
        '2relationship',
        '2address',
        '2source_of_income',
        '2cellphone_number',
    ];
}
