<?php

//Model for replies Table

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    protected $table = 'replies';
    protected $primaryKey = 'rid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['rid','uid','tid','rcontent'];

    // only enable created_at, not updated_at
    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function user(){
        return $this->belongsTo(UserInfo::class,'uid','uid');
    }

    public function talk(){
        return $this->belongsTo(Talks::class,'tid','tid');
    }
}
