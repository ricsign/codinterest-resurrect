<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'aid';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
}
