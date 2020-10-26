<?php

//Model for comments Table

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'cid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['cid','uid','aid','ccontent'];

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

    public function article(){
        return $this->belongsTo(Articles::class,'aid','aid');
    }
}
