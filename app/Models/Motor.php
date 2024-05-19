<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'model_name',
        'model_year',
        'specifications'
    ];

    public function modelnameyear()
    {
        return "{$this->model_name} {$this->model_year}";
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function colors()
    {
        return $this->hasMany(MotorColorKey::class, 'motor_id', 'id');
    }
}
