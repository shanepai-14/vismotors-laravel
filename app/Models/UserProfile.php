<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fathers_name', //
        'mothers_name', //
        'gender_id',
        'civil_status_id',
        'transaction_id',
        'address_landmark',
        'address_lot',
        'address_brgy',
        'address_city',
        'address_prov',
        'home_ownership_id', //
        'previous_address', //
        'reason_of_transfer', //
        'years_stay', //
        'months_stay', //
        'occupation_id',
        'tin_id', //
        'phone_no', //
        'date_of_birth',
        'longitude',
        'latitude' ,
        'citizenship_id',
        'valid_one',
        'valid_two',
        'profile_picture',
        'desc',
        'income',
        'billing'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }
    public function civil_status()
    {
        return $this->belongsTo(CivilStatus::class, 'civil_status_id', 'id');
    }
    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id', 'id');
    }
    public function citizenship()
    {
        return $this->belongsTo(Citizenship::class, 'citizenship_id', 'id');
    }
}
