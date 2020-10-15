<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talks extends Model
{
    protected $table = 'talks';
    protected $primaryKey = 'tid';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['tid','uid','ttit','topicid','tcontent','tviews','treplies'];

    public function topic(){
        return $this->hasOne(Topics::class,'topicid','topicid');
    }

    public function user(){
        return $this->hasOne(UserInfo::class,'uid','uid');
    }
}
