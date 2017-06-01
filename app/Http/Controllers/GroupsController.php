<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = Group::withCount('users') -> get();

        return view('pages.groups.index', compact('groups'));
    }

    public function edit($id)
    {
        $groups = Group::get();
        $editGroup = Group::find($id);

        return view('pages.groups.edit', compact('groups', 'editGroup'));
    }

    public function destroy(Request $request)
    {
        $group = Group::find($request -> id);

        $group -> delete();

        return redirect('/groups');
    }

    public function create(Request $request)
    {
        $group = new Group;

        $group -> name = $request -> name;

        $group -> save();

        return redirect('/groups/' . $group -> groupID);
    }
}
