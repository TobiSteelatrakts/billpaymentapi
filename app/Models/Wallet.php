<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    
    protected $primaryKey = 'id'; // or null

    public $incrementing = false;


    protected $fillable = [
        'id','user_id', 'balance'
    ];

    // relationship between user and transaction (a wallet belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
