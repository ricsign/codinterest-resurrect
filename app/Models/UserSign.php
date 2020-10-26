<?php

//Model for user_sign Table

namespace App\Models;


// model of user_sign table, which is the table recording
// user's basic sign up and sign in information
use Illuminate\Database\Eloquent\Model;

class UserSign extends Model
{
    protected $table = 'user_sign';
    protected $primaryKey = 'uid';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['username','password','email','usertoken','is_activated'];

    public function user_info(){
        return $this->hasOne(UserInfo::class,'uid','uid');
    }
}
