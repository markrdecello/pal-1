<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submitted extends Model
{
    
    protected $table = 'submitted';

    protected $fillable = [
        'user_id','form_id','status'
    ];
}
