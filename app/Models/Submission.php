<?php

//Model for submission Table

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submission';
    protected $primaryKey = 'sid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['sid','uid','pid','status'];

    // only enable created_at, not updated_at
    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

}
