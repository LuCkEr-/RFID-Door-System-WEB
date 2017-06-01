<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Account;
use App\Card;
use App\Elder;
use App\Group;
use App\Log;
use App\Time;
use App\Door;

class DataTablesController extends Controller
{
    public function account(Request $request)
    {
        return Datatables::eloquent(Account::with('cards', 'groups', 'parents'))
        -> addColumn('cards', function(Account $account) {
            return $account -> cards -> map(function($card) {
                return $card -> visualID;
            }) -> implode(' ');
        })
        -> addColumn('groups', function(Account $account) {
            return $account -> groups -> map(function($groups) {
                return $groups -> name;
            }) -> implode(' ');
        })
        -> addColumn('parents', function(Account $account) {
            return $account -> parents -> map(function($elder) {
                return $elder -> firstName . ' ' . $elder -> lastName;
            }) -> implode(' ');
        })
        -> make(true);
    }

    public function card(Request $request)
    {
        return Datatables::eloquent(Card::with('user'))
        -> addColumn('userFirstName', function(Card $card) {
            return $card -> user['firstName'];
        })
        -> addColumn('userLastName', function(Card $card) {
            return $card -> user['lastName'];
        })
        -> make(true);
    }

    public function group(Request $request)
    {
        return Datatables::eloquent(Group::withCount('users')) -> make(true);
    }

    public function log(Request $request)
    {
        return Datatables::eloquent(Log::with('user'))
        -> addColumn('userFirstName', function(Log $log) {

            $account = Account::whereHas('cards', function($query) use ($log) {
                $query -> where('cardRFID', 'like', $log -> cardRFID);
            }) -> first();

            if (!count($account)) {
                return "";
            } else {
                return $account -> firstName;
            }
        })
        -> addColumn('userLastName', function(Log $log) {

            $account = Account::whereHas('cards', function($query) use ($log) {
                $query -> where('cardRFID', 'like', $log -> cardRFID);
            }) -> first();

            if (!count($account)) {
                return "";
            } else {
                return $account -> lastName;
            }
        })
        -> addColumn('doorName', function(Log $log) {
            return $log -> door -> name;
        })
        -> addColumn('created_at_date', function(Log $log) {
            return explode(' ', $log -> created_at)[0];
        })
        -> addColumn('created_at_time', function(Log $log) {
            return explode(' ', $log -> created_at)[1];
        })
        -> orderBy('created_at', 'desc')
        -> make(true);
    }

    public function elder(Request $request)
    {
        return Datatables::eloquent(Elder::query()) -> make(true);
    }
}
