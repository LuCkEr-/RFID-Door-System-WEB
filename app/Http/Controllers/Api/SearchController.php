<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Account;
use App\Card;
use App\Elder;
use App\Group;
use App\Door;

class SearchController extends Controller
{
    // Find account
    public function account(Request $request)
    {
        $searchTerm = trim($request -> search);
        $searchLimit = trim($request -> limit);

        $results = [];

        if(!empty($searchLimit)) {
            if(!is_numeric($searchLimit)) {
                return response("Unknown limit");
            }
        } else {
            $searchLimit = 10;
        }

        $searchTerm = str_replace('%20', ' ', $searchTerm);

        if(empty($searchTerm)) {
            $accounts = Account::limit($searchLimit) -> get();

            foreach ($accounts as $account)
        	{
        	    $results[] = [ 'id' => $account -> userID, 'text' => $account -> firstName.' '.$account -> lastName ];
        	}
            return response() -> json($results);
        } else {
        	$accounts = Account::where(DB::raw('CONCAT(firstName," ",lastName)'), 'RLIKE', $searchTerm)
                -> orWhere('firstName', "RLIKE", $searchTerm)
                -> orWhere('lastName', "RLIKE", $searchTerm)
        		-> take($searchLimit) -> get();

        	foreach ($accounts as $account)
        	{
        	    $results[] = [ 'id' => $account -> userID, 'text' => $account -> firstName.' '.$account -> lastName ];
        	}
            return response() -> json($results);
        }
        return response() -> json([]);
    }

    // Find group
    public function group(Request $request)
    {
        $searchTerm = trim($request -> search);
        $searchLimit = trim($request -> limit);

        $results = [];

        if(!empty($searchLimit)) {
            if(!is_numeric($searchLimit)) {
                return response("Unknown limit");
            }
        } else {
            $searchLimit = 10;
        }

        $searchTerm = str_replace('%20', ' ', $searchTerm);

        if(empty($searchTerm)) {
            $groups = Group::limit($searchLimit) -> get();

            foreach ($groups as $group)
            {
                $results[] = [ 'id' => $group -> groupID, 'text' => $group -> name ];
            }
            return response() -> json($results);
        } else {
            $groups = Group::Where('name', "RLIKE", $searchTerm)
                -> take($searchLimit) -> get();

            foreach ($groups as $group)
            {
                $results[] = [ 'id' => $group -> groupID, 'text' => $group -> name ];
            }
            return response() -> json($results);
        }

        return response() -> json([]);
    }

    // Find card
    public function card(Request $request)
    {
        $searchTerm = trim($request -> search);
        $searchLimit = trim($request -> limit);

        $results = [];

        if(!empty($searchLimit)) {
            if(!is_numeric($searchLimit)) {
                return response("Unknown limit");
            }
        } else {
            $searchLimit = 10;
        }

        $searchTerm = str_replace('%20', ' ', $searchTerm);

        if(empty($searchTerm)) {
            $cards = Card::limit($searchLimit) -> get();

            foreach ($cards as $card)
            {
                $results[] = [ 'id' => $card -> cardID, 'text' => $card -> visualID ];
            }
            return response() -> json($results);
        } else {
            $cards = Card::Where('visualID', "RLIKE", $searchTerm)
                -> take($searchLimit) -> get();

            foreach ($cards as $card)
            {
                $results[] = [ 'id' => $card -> cardID, 'text' => $card -> visualID ];
            }
            return response() -> json($results);
        }

        return response() -> json([]);
    }

    // Find Door
    public function door(Request $request)
    {
        $searchTerm = trim($request -> search);
        $searchLimit = trim($request -> limit);

        $results = [];

        if(!empty($searchLimit)) {
            if(!is_numeric($searchLimit)) {
                return response("Unknown limit");
            }
        } else {
            $searchLimit = 10;
        }

        $searchTerm = str_replace('%20', ' ', $searchTerm);

        if(empty($searchTerm)) {
            $doors = Door::limit($searchLimit) -> get();

            foreach ($doors as $door)
            {
                $results[] = [ 'id' => $door -> doorID, 'text' => $door -> name ];
            }
            return response() -> json($results);
        } else {
            $doors = Door::Where('name', "RLIKE", $searchTerm)
                -> take($searchLimit) -> get();

            foreach ($doors as $door)
            {
                $results[] = [ 'id' => $door -> doorID, 'text' => $door -> name ];
            }
            return response() -> json($results);
        }

        return response() -> json([]);
    }
}
