<?php

//Model for problems Table

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Problems extends Model
{

    protected $table = 'problems';
    protected $primaryKey = 'pid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
}
