<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Account;
use App\Card;
use App\Elder;
use App\Group;
use App\Log;
use App\Time;
use App\Door;
use Carbon\Carbon;

class AutoCompleteController extends Controller
{
    // Get Cards Users
    public function getDefaultCardUser(Request $request) {
        $card = Card::find($request -> id);

        if (count($card)) {
            if (count($card -> user)) {
                $results[] = [ 'id' => $card -> user -> userID, 'text' => $card -> user -> firstName . ' ' . $card -> user -> lastName ];
            } else {
                return response() -> json([]);
            }
        }

        return response() -> json($results);
    }

    // Get Users Cards
    public function getDefaultUserCard(Request $request) {
        $user = Account::find($request -> id);

        $results = [];

        foreach ($user -> cards as $card) {
            $results[] = [ 'id' => $card -> cardID, 'text' => $card -> visualID ];
        }

        return response() -> json($results);
    }

    // Get User Groups
    public function getDefaultUserGroup(Request $request) {
        $user = Account::find($request -> id);

        $results = [];

        foreach ($user -> groups as $group) {
            $results[] = [ 'id' => $group -> groupID, 'text' => $group -> name ];

        }

        return response() -> json($results);
    }

    // Get Groups Doors
    public function getDefaultGroupDoor(Request $request) {
        $group = Group::find($request -> id);

        $results = [];

        foreach ($group -> doors as $door) {
            $results[] = [ 'id' => $door -> doorID, 'text' => $door -> name ];

        }

        return response() -> json($results);
    }

    // Get Groups Doors
    public function getDefaultGroupTime(Request $request) {
        $group = Group::find($request -> id);

        $results = [];

        foreach ($group -> times as $time) {
            $results[] = [ 'id' => $time -> timeID, 'text' => Carbon::createFromFormat('Y-m-d H:i:s', $time -> startTime) -> toDayDateTimeString() . ' kuni ' . Carbon::createFromFormat('Y-m-d H:i:s', $time -> endTime) -> toDayDateTimeString() ];

        }

        return response() -> json($results);
    }
}
