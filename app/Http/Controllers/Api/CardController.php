<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Card;

class CardController extends Controller
{
    public function updateAccount(Request $request)
    {

        $card = Card::find($request -> id);

        $card -> userID = $request -> newid;

        $card -> save();

        return $card;
    }

    public function removeAccount(Request $request)
    {

        $card = Card::find($request -> id);

        $card -> userID = -1;

        $card -> save();

        return $card;
    }

    public function updateVID(Request $request)
    {

        $card = Card::find($request -> id);

        $card -> visualID = $request -> text;

        $card -> save();

        return $card;
    }

    public function updateRFID(Request $request)
    {

        $card = Card::find($request -> id);

        $card -> cardRFID = $request -> text;

        $card -> save();

        return $card;
    }
}
