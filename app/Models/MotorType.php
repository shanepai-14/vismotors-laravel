<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function motors()
    {
        return $this->hasMany(MotorColorKey::class, 'motor_type_id', 'id');
    }
}
