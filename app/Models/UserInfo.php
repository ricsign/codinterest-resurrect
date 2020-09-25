<?php

//Model for user_info Table

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{

    protected $table = 'user_info';
    protected $primaryKey = 'uid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = [];

    public function submission(){
        return $this->hasMany(Submission::class,'uid','uid');
    }
}
