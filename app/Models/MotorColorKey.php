<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorColorKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'motor_id',
        'color',
        'motor_type_id',
        'quantity',
        'price_cash',
        'price_installment',
        'interest_rate'
    ];

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'motor_id', 'id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'motor_id', 'id');
    }
    public function motor_type()
    {
        return $this->belongsTo(MotorType::class, 'motor_type_id', 'id');
    }
}
