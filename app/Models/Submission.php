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

    protected $fillable = ['sid','uid','pid','status'];
}
