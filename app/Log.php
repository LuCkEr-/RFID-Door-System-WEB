<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'logID';
    protected $fillabel =[
        'cardRFID',
        'doorID'
    ];

    // Gets the logs owner
    public function user()
    {
        return $this -> belongsTo('App\Account', 'userID');
    }

    // Get the logs door
    public function door()
    {
        return $this -> belongsTo('App\Door', 'doorID', 'doorID');
    }
}
