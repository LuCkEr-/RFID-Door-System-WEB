<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Door extends Model
{
    protected $table = 'doors';
    protected $primaryKey = 'doorID';
    protected $fillabel =[
        'name'
    ];

    // Gets the doors groups
    public function groups()
    {
        return $this -> belongsToMany('App\Group', 'groups_doors', 'doorID', 'groupID');
    }

    // Gets the doors groups
    public function logs()
    {
        return $this -> hasMany('App\Log', 'doorID', 'doorID');
    }
}
