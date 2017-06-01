<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elder extends Model
{
    protected $table = 'elders';
    protected $primaryKey = 'parentID';
    protected $fillabel =[
        'firstName',
        'lastName',
        'email',
        'personalCode'
    ];
}
