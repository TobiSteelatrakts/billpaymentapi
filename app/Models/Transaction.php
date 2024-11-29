<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{


    protected $primaryKey = 'id';

    public $incrementing = false;
    
    protected $fillable = [
        'id','user_id', 'amount','payment_type','transaction_type','network_id','phone_number'
    ];


    // relationship between user and transaction ( a transaction belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
