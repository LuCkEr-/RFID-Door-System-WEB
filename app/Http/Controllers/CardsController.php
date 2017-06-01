<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;

class CardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get to index
        $cards = Card::with('user') -> get();

        return view('pages.cards.index', compact('cards'));
    }

    public function create(Request $request)
    {
        $card = new Card;

        $card -> userID = -1;
        $card -> cardRFID = $request -> cardRFID;
        $card -> visualID = '';

        $card -> save();

        return redirect('/cards/' . $card -> cardID);
        //return view('pages.cards.edit', ['editCard' => $card]);
        //return redirect('/groups');
    }

    public function edit($id)
    {
        // GET on card
        // When you have clicked on a card
        $cards = Card::with('user') -> get();

        $editcard = Card::find($id);

        return view('pages.cards.edit', compact('cards', 'editcard'));
    }

    public function delete(Request $request)
    {
        Card::find($request -> cardID) -> delete();

        return redirect('/cards');
    }
}
