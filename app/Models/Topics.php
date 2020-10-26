<?php

//Model for topics Table

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table = 'topics';
    protected $primaryKey = 'topicid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['topicid','topicname','topiccolor','uid','topicbelongsto'];

    // only enable created_at, not updated_at
    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
