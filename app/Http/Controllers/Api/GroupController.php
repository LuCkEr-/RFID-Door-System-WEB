<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Time;
use App\Group;
use App\Door;

class GroupController extends Controller
{
    public function updateName(Request $request) {

        $group = Group::find($request -> id);

        $group -> name = $request -> text;

        $group -> save();

        return response($group);
    }

    public function insertTime(Request $request) {
        $time = new Time;

        if ($request -> weekly) {
            $time -> day = $request -> day;
        }
        $time -> groupID = $request -> id;
        $time -> startTime = $request -> startTime;
        $time -> endTime = $request -> endTime;
        $time -> weekly = $request -> weekly;

        $time -> save();

        return response($time);
    }

    public function removeTime(Request $request) {

        $time = Time::find($request -> removeid);

        $time -> delete();

        return response($time);
    }

    public function updateDoor(Request $request)
    {
        return Door::find($request -> id) -> groups() -> attach($request -> newid);
    }

    public function removeDoor(Request $request)
    {
        return Door::find($request -> id) -> groups() -> detach($request -> removeid);
    }
}
