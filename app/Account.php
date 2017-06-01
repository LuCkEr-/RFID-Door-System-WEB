<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'userID';
    protected $fillabel =[
        'firstName',
        'lastName',
        'extraName',
        'email',
        'personalCode',
        'homeAddress',
        'workAddress',
        'homePhone',
        'mobilePhone',
        'jobTitle',
        'employer',
        'comments',
        'pan',
        'businessName'
    ];


    // Gets users cards
    public function cards()
    {
        return $this -> hasMany('App\Card', 'userID', 'userID');
    }

    // Gets users groups
    public function groups()
    {
        return $this -> belongsToMany('App\Group', 'account_groups', 'userID', 'groupID');
    }

    // Gets users parents
    public function parents()
    {
        return $this -> belongsToMany('App\Elder', 'account_elders', 'userID', 'parentID');
    }

    // Gets users logs
    public function logs()
    {
        return $this -> belongsToMany('App\Log', 'account_logs', 'userID', 'logID');
    }
}
