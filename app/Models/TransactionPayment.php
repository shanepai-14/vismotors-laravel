<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'or_number',
        'ref_no',
        'transaction_id',
        'amount',
        'cashier_id',
        'description',
        'status',
        'payment_method',
        'balance'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function ref_no()
    {
        return $this->belongsTo(Transaction::class, 'ref_no', 'ref_no');
    }
    public function cashier()   {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}
