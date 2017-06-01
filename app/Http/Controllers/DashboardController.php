<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Log;
use App\Account;
use App\Card;
use App\Group;
use App\Door;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Some simple stats
        $doorOpenCount = Log::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $userCount = Account::count();
        $cardCount = Card::count();
        $groupsCount = Group::count();

        // Get 10 latest logs
        $lastLogs = Log::where('created_at', '>=', Carbon::now()->subDay())-> limit(6) -> latest() -> get();

        // Get doors in system
        $doors = Door::with(['logs' => function ($q) {
            $q -> latest() -> take(5);
        }]) -> get();

        return view('pages.dashboard.index', compact('doorOpenCount', 'userCount', 'cardCount', 'groupsCount', 'lastLogs', 'doors'));
    }
}
