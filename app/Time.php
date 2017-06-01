<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Time extends Model
{
    protected $table = 'times';
    protected $primaryKey = 'timeID';

    // Gets the times parent group
    public function group()
    {
        return $this -> belongsTo('App\Group', 'groupID');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
