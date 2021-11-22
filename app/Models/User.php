<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sub_user()
    {
        return $this->belongsToMany(
            User::class,
            'relations',
            'admin_id',
            'sub_id'
        );
    }

    public function admin_user()
    {
        return $this->belongsToMany(
            User::class,
            'relations',
            'sub_id',
            'admin_id'
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function sendVerificationCode($phone_n)
    {
        $verif_code = mt_rand(100000, 999999);
        Session::put('verif_code', $verif_code);

        $client = new Client($_ENV['TWILIO_SID'], $_ENV['TWILIO_AUTH_TOKEN']);
        $to= '+212' . $phone_n;
        $sms = $client->messages->create($to,[
            'from'=> $_ENV['TWILIO_NUMBER'], 
            'body'=>"Your auth code is " . $verif_code
        ]);
        return [true, $verif_code];
    }

    public function validateCode($code)
    {   
        $validCode = Session::get('verif_code');
        if($code == $validCode) {
            Session::forget('code');
            Auth::login($this);
            return true;
        } else {
            return false;
        }
    }
}
