<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'form';
    

    protected $fillable = [
        'name','form_type'
    ];
}
