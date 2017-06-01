<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'groupID';
    protected $fillabel =[
        'name'
    ];

    // Gets the groups members
    public function users()
    {
        return $this -> belongsToMany('App\Account', 'account_groups', 'groupID', 'userID');
    }

    // Gets the times
    public function times()
    {
        return $this -> hasMany('App\Time', 'groupID', 'groupID');
    }

    // Gets groups doors
    public function doors()
    {
        return $this -> belongsToMany('App\Door', 'groups_doors', 'groupID', 'doorID');
    }
}
