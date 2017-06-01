<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Account;
use App\Card;

class AccountController extends Controller
{
    public function updateFName(Request $request)
    {

        $account = Account::find($request -> id);

        $account -> firstName = $request -> text;

        $account -> save();

        return $account;
    }

    public function updateLName(Request $request)
    {

        $account = Account::find($request -> id);

        $account -> lastName = $request -> text;

        $account -> save();

        return $account;
    }

    public function updateEmail(Request $request)
    {

        $account = Account::find($request -> id);

        $account -> email = $request -> text;

        $account -> save();

        return $account;
    }

    public function updateMobilePhone(Request $request)
    {
        
        $account = Account::find($request -> id);

        $account -> mobilePhone = $request -> text;

        $account -> save();

        return $account;
    }

    public function updatePersonalCode(Request $request)
    {

        $account = Account::find($request -> id);

        $account -> personalCode = $request -> text;

        $account -> save();

        return $account;
    }

    public function updateCard(Request $request)
    {

        $card = Card::find($request -> newid);

        $card -> userID = $request -> id;

        $card -> save();

        return $card;
    }

    public function removeCard(Request $request)
    {

        $card = Card::find($request -> removeid);

        $card -> userID = -1;

        $card -> save();

        return $card;
    }

    public function updateGroup(Request $request)
    {
        return Account::find($request -> id) -> groups() -> attach($request -> newid);
    }

    public function removeGroup(Request $request)
    {
        return Account::find($request -> id) -> groups() -> detach($request -> removeid);
    }
}
