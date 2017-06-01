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
use App\Log;
use App\Time;
use App\Door;
use Carbon\Carbon;

class MiscController extends Controller
{
    public function insertlog(Request $request)
    {

        $account = Account::whereHas('cards', function($query) use ($request) {
            $query -> where('cardRFID', 'like', $request -> cardRFID);
        }) -> first();

        $door = Door::where('doorHash', 'like', $request -> doorHash) -> first();

        if(!count($door)) {
            $door = new Door;

            $door -> doorHash = $request -> doorHash;
            $door -> name = "Ukse nimi";

            $door -> save();
        }

        $log = new Log;

        $log -> doorID = $door -> doorID;
        $log -> cardRFID = $request -> cardRFID;
        // Status codes:
        // 404 - Card not found
        // 200 - Access Granted
        // 401 - Access Denied
        if (!count($account)) {
            //$log -> userID = -1;
            $log -> status = 404;
        } else if($this -> CheckCardPermission($request -> cardRFID)) {
            //$log -> userID = $account -> userID;
            $log -> status = 200;
        } else if(!$this -> CheckCardPermission($request -> cardRFID)) {
            //$log -> userID = $account -> userID;
            $log -> status = 401;
        }

        $log -> save();

        return response() -> json($log);
    }

    public function insertDoor(Request $request)
    {

        $door = new Door;

        $door -> userID = $account -> userID;

        $door -> save();
        return response() -> json($log);

        return response() -> json(['status' => 'Not found'], 404);
    }

    public function CheckCardPermission($cardRFID)
    {
        $startTimesCheck = [];
        $finishTimesCheck = [];

        $card = Card::where('cardRFID', $cardRFID) -> first();

        if (!count($card)) {
            return false;
        }

        $cardGroups = $card -> user -> groups;

        if (!count($cardGroups)) {
            return false;
        }

        $currentDate = new Carbon();

        foreach ($cardGroups as $group) {
            $groupTimes = $group -> times;
            if (count($groupTimes)) {
                foreach ($groupTimes as $groupTime) {
                    if ($groupTime -> weekly) {
                        $newDate = new $currentDate;

                        switch ($groupTime -> day) {
                            case 0: {
                                if ($currentDate -> dayOfWeek !== Carbon::SUNDAY) {
                                    $newDate -> next(Carbon::SUNDAY);
                                }
                                break;
                            }
                            case 1: {
                                if ($currentDate -> dayOfWeek !== Carbon::MONDAY) {
                                    $newDate -> next(Carbon::MONDAY);
                                }
                                break;
                            }
                            case 2: {
                                if ($currentDate -> dayOfWeek !== Carbon::TUESDAY) {
                                    $newDate -> next(Carbon::TUESDAY);
                                }
                                break;
                            }
                            case 3: {
                                if ($currentDate -> dayOfWeek !== Carbon::WEDNESDAY) {
                                    $newDate -> next(Carbon::WEDNESDAY);
                                }
                                break;
                            }
                            case 4: {
                                if ($currentDate -> dayOfWeek !== Carbon::THURSDAY) {
                                    $newDate -> next(Carbon::THURSDAY);
                                }
                                break;
                            }
                            case 5: {
                                if ($currentDate -> dayOfWeek !== Carbon::FRIDAY) {
                                    $newDate -> next(Carbon::FRIDAY);
                                }
                                break;
                            }
                            case 6: {
                                if ($currentDate -> dayOfWeek !== Carbon::SATURDAY) {
                                    $newDate -> next(Carbon::SATURDAY);
                                }
                                break;
                            }
                        }

                        $startTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> startTime) -> setDate($newDate -> year, $newDate -> month, $newDate -> day);

                        $newDate = new $currentDate;
                        switch ($groupTime -> day) {
                            case 0: {
                                if ($currentDate -> dayOfWeek !== Carbon::SUNDAY) {
                                    $newDate -> next(Carbon::SUNDAY);
                                }
                                break;
                            }
                            case 1: {
                                if ($currentDate -> dayOfWeek !== Carbon::MONDAY) {
                                    $newDate -> next(Carbon::MONDAY);
                                }
                                break;
                            }
                            case 2: {
                                if ($currentDate -> dayOfWeek !== Carbon::TUESDAY) {
                                    $newDate -> next(Carbon::TUESDAY);
                                }
                                break;
                            }
                            case 3: {
                                if ($currentDate -> dayOfWeek !== Carbon::WEDNESDAY) {
                                    $newDate -> next(Carbon::WEDNESDAY);
                                }
                                break;
                            }
                            case 4: {
                                if ($currentDate -> dayOfWeek !== Carbon::THURSDAY) {
                                    $newDate -> next(Carbon::THURSDAY);
                                }
                                break;
                            }
                            case 5: {
                                if ($currentDate -> dayOfWeek !== Carbon::FRIDAY) {
                                    $newDate -> next(Carbon::FRIDAY);
                                }
                                break;
                            }
                            case 6: {
                                if ($currentDate -> dayOfWeek !== Carbon::SATURDAY) {
                                    $newDate -> next(Carbon::SATURDAY);
                                }
                                break;
                            }
                        }


                        $finishTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> endTime) -> setDate($newDate -> year, $newDate -> month, $newDate -> day);

                    } else {
                        $startTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> startTime);
                        $finishTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> endTime);
                    }
                }
            }
        }

        if (!count($startTimesCheck) || !count($finishTimesCheck)) {
            return false;
        }

        $cardStatus = false;

        for ($i = 0; $i < count($startTimesCheck); $i++) {
            if (!$cardStatus) {
                $cardStatus = $currentDate -> between($startTimesCheck[$i], $finishTimesCheck[$i]);
            }
        }

        return true;
    }

    public function getCardPermission(Request $request)
    {
        $startTimesCheck = [];
        $finishTimesCheck = [];

        $card = Card::where('cardRFID', $request -> cardRFID) -> first();

        if (!count($card)) {
            return response() -> json(['status' => 'Card not found'], 404);
        }

        $cardGroups = $card -> user -> groups;

        if (!count($cardGroups)) {
            return response() -> json(['status' => 'Cards user doesnt belong to any groups'], 404);
        }

        $currentDate = new Carbon();

        foreach ($cardGroups as $group) {
            $groupTimes = $group -> times;
            if (count($groupTimes)) {
                foreach ($groupTimes as $groupTime) {
                    if ($groupTime -> weekly) {
                        $newDate = new $currentDate;

                        switch ($groupTime -> day) {
                            case 0: {
                                if ($currentDate -> dayOfWeek !== Carbon::SUNDAY) {
                                    $newDate -> next(Carbon::SUNDAY);
                                }
                                break;
                            }
                            case 1: {
                                if ($currentDate -> dayOfWeek !== Carbon::MONDAY) {
                                    $newDate -> next(Carbon::MONDAY);
                                }
                                break;
                            }
                            case 2: {
                                if ($currentDate -> dayOfWeek !== Carbon::TUESDAY) {
                                    $newDate -> next(Carbon::TUESDAY);
                                }
                                break;
                            }
                            case 3: {
                                if ($currentDate -> dayOfWeek !== Carbon::WEDNESDAY) {
                                    $newDate -> next(Carbon::WEDNESDAY);
                                }
                                break;
                            }
                            case 4: {
                                if ($currentDate -> dayOfWeek !== Carbon::THURSDAY) {
                                    $newDate -> next(Carbon::THURSDAY);
                                }
                                break;
                            }
                            case 5: {
                                if ($currentDate -> dayOfWeek !== Carbon::FRIDAY) {
                                    $newDate -> next(Carbon::FRIDAY);
                                }
                                break;
                            }
                            case 6: {
                                if ($currentDate -> dayOfWeek !== Carbon::SATURDAY) {
                                    $newDate -> next(Carbon::SATURDAY);
                                }
                                break;
                            }
                        }

                        $startTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> startTime) -> setDate($newDate -> year, $newDate -> month, $newDate -> day);

                        $newDate = new $currentDate;
                        switch ($groupTime -> day) {
                            case 0: {
                                if ($currentDate -> dayOfWeek !== Carbon::SUNDAY) {
                                    $newDate -> next(Carbon::SUNDAY);
                                }
                                break;
                            }
                            case 1: {
                                if ($currentDate -> dayOfWeek !== Carbon::MONDAY) {
                                    $newDate -> next(Carbon::MONDAY);
                                }
                                break;
                            }
                            case 2: {
                                if ($currentDate -> dayOfWeek !== Carbon::TUESDAY) {
                                    $newDate -> next(Carbon::TUESDAY);
                                }
                                break;
                            }
                            case 3: {
                                if ($currentDate -> dayOfWeek !== Carbon::WEDNESDAY) {
                                    $newDate -> next(Carbon::WEDNESDAY);
                                }
                                break;
                            }
                            case 4: {
                                if ($currentDate -> dayOfWeek !== Carbon::THURSDAY) {
                                    $newDate -> next(Carbon::THURSDAY);
                                }
                                break;
                            }
                            case 5: {
                                if ($currentDate -> dayOfWeek !== Carbon::FRIDAY) {
                                    $newDate -> next(Carbon::FRIDAY);
                                }
                                break;
                            }
                            case 6: {
                                if ($currentDate -> dayOfWeek !== Carbon::SATURDAY) {
                                    $newDate -> next(Carbon::SATURDAY);
                                }
                                break;
                            }
                        }


                        $finishTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> endTime) -> setDate($newDate -> year, $newDate -> month, $newDate -> day);

                    } else {
                        $startTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> startTime);
                        $finishTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> endTime);
                    }
                }
            }
        }

        if (!count($startTimesCheck) || !count($finishTimesCheck)) {
            return response() -> json(['status' => 'Cards users group doesnt have any times'], 404);
        }

        $cardStatus = false;

        for ($i = 0; $i < count($startTimesCheck); $i++) {
            if (!$cardStatus) {
                $cardStatus = $currentDate -> between($startTimesCheck[$i], $finishTimesCheck[$i]);
            }
        }

        return response() -> json(['status' => $cardStatus], 200);
    }

    // This sends back all of the cards with valid time peridos
    public function getCards(Request $request)
    {
        $startTimesCheck = [];
        $finishTimesCheck = [];

        $card = Card::get();

        if (!count($card)) {
            return response() -> json(['error' => 'Card not found'], 404);
        }

        $cardGroups = $card -> user -> groups;

        if (!count($cardGroups)) {
            return response() -> json(['error' => 'Cards user doesnt belong to any groups'], 404);
        }

        foreach ($cardGroups as $group) {
            $groupTimes = $group -> times;
            if (count($groupTimes)) {
                foreach ($groupTimes as $groupTime) {
                    $startTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> startTime);
                    $finishTimesCheck[] = Carbon::createFromFormat('Y-m-d H:i:s', $groupTime -> finishTime);
                }
            }
        }

        if (!count($startTimesCheck) || !count($finishTimesCheck)) {
            return response() -> json(['error' => 'Cards users group doesnt have any times'], 404);
        }

        $cardStatus = false;

        for ($i = 0; $i < count($startTimesCheck); $i++) {
            if (!$cardStatus) {
                $cardStatus = Carbon::now() -> between($startTimesCheck[$i], $finishTimesCheck[$i]);
            }
        }

        return response() -> json(['status' => $cardStatus], 200);
    }

    // Accept: token
    // return true/false
    public function checkControllerToken(Request $request)
    {
        $door = Door::where('doorHash', $request -> token) -> get();

        if (!count($door)) {
            $newDoor = new Door;

            $newDoor -> doorHash = $request -> token;
            $newDoor -> name = "Ukse nimi";

            $newDoor -> save();

            return response() -> json(['status' => true], 200);
            //return "{status:true}";
        } else {
            return response() -> json(['status' => false], 200);
        }
    }
}
