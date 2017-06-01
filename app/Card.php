<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $primaryKey = 'cardID';
    protected $fillabel =[
        'cardRFID',
        'visualID'
    ];

    // Gets the cards owner
    public function user()
    {
        return $this -> belongsTo('App\Account', 'userID');
    }
}
