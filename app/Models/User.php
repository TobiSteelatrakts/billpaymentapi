<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password'
    ];


    protected function casts(): array
    {
        return [

            'password' => 'hashed',
        ];
    }


     // relationship between user and wallet (user has one wallet only)
    public function wallet()
    {
       return $this->hasOne(Wallet::class);
    }


     // relationship between user and transaction (user has many transactions)
    public function transaction()
    {
       return $this->hasMany(Transaction::class);
    }

}
