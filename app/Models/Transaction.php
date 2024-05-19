<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'trans_type_id',
        'motor_id',
        'downpayment',
        'monthly_due',
        'loan_tenure_months',
        'status_id',
        'due_date'
    ];

    public function customers()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
    public function transaction_types()
    {
        return $this->belongsTo(TransactionType::class, 'trans_type_id', 'id');
    }
    public function motors()
    {
        return $this->belongsTo(MotorColorKey::class, 'motor_id', 'id');
    }
    public function statuses()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(TransactionPayment::class,'ref_no','ref_no');
    }
    public function getTotalAmountAttribute()
    {
        return $this->payments->sum('amount');
    }
}
