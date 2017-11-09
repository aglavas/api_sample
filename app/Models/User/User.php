<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'birth_date', 'sex', 'verified', 'verification_last_sent', 'locale', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at', 'updated_at', 'locale', 'type'
    ];


    protected $casts = [
        'id' => 'integer',
        'verified' => 'boolean',
    ];

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value;
        // Set age
        $carbon = Carbon::parse($value);
        $this->attributes['age'] = Carbon::now()->diffInYears($carbon);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
