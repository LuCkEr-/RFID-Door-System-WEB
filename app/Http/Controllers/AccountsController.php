<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Card;
use App\Elder;
use App\Group;
use Illuminate\Support\Facades\Storage;
use Excel;

class AccountsController extends Controller
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
        $accounts = Account::orderBy('firstName') -> get();
        return view('pages.accounts.index', ['accounts' => $accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Account::create(request([
            'firstName',
            'lastName',
            'extraName',
            'email',
            'personalCode',
            'homeAddress',
            'workAddress',
            'homePhone',
            'mobilePhone',
            'jobTitle',
            'employer',
            'comments',
            'pan',
            'businessName'
        ]));

        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accounts = Account::orderBy('firstName') -> get();

        $editAccount = Account::find($id);

        $cards = Card::get();

        return view('pages.accounts.edit', ['accounts' => $accounts, 'editAccount' => $editAccount, "cards" => $cards]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect('/accounts/{id}');
    }

    public function delete(Request $request)
    {
        Account::find($request -> userID) -> delete();

        return redirect('/accounts');
    }

    public function insert(Request $request)
    {
        $account = new Account;

        $account -> firstName = $request -> firstName;
        $account -> lastName = $request -> lastName;
        $account -> active = true;

        $account -> save();

        return redirect('/accounts/' . $account -> userID);
        return view('pages.accounts.edit', ['editAccount' => $account]);
    }

    /**
     * Import the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $file = $request -> file('importFile');
        if ($file -> isValid())
        {
            Excel::load($file, function($reader) {
                $reader -> each(function($row) {

                    if ($row -> first_name) {
                        // Save user to the database
                        $account = new Account;

                        $account -> active = str_replace('"', "", $row -> active);
                        $account -> firstName = str_replace('"', "", $row -> first_name);
                        $account -> lastName = str_replace('"', "", $row -> last_name);
                        $account -> extraName = str_replace('"', "", $row -> extra_name);
                        $account -> email = str_replace('"', "", $row -> email);
                        $account -> personalCode = str_replace('"', "", $row -> personal_code);
                        $account -> homeAddress = str_replace('"', "", $row -> address);
                        $account -> workAddress = str_replace('"', "", $row -> work_address);
                        $account -> homePhone = str_replace('"', "", $row -> home_phone);
                        $account -> mobilePhone = str_replace('"', "", $row -> mobile_phone);
                        $account -> jobTitle = str_replace('"', "", $row -> job_title);
                        $account -> employer = str_replace('"', "", $row -> employer);
                        $account -> comments = str_replace('"', "", $row -> comments);
                        $account -> pan = str_replace('"', "", $row -> pan);
                        $account -> businessName = str_replace('"', "", $row -> business_name);

                        $account -> save();

                        $accountID = $account -> userID;


                        // Add users cards to the database
                        // One card can have only one user
                        if (count($row -> cards) && count($row -> card_visuals)) {
                            $cardsRFID = explode(",", str_replace('"', "", $row -> cards));
                            $cardsVisualID = explode(",", str_replace('"', "", $row -> card_visuals));

                            for( $i = 0; $i < count($cardsRFID); $i++ ) {
                                $card = new Card;

                                $card -> userID = $accountID;
                                $card -> cardRFID = $cardsRFID[$i];
                                $card -> visualID = $cardsVisualID[$i];

                                $card -> save();
                            }
                        }

                        // Add users groups to the database
                        // One user can have many groups
                        $groups = explode(",", str_replace('"', "", $row -> groups));

                        for( $i = 0; $i < count($groups); $i++ ) {
                            // Need to check if the group already exists
                            $getGroup = Group::where("name", $groups[$i]) -> first();
                            if (!$getGroup) {
                                $newGroup = new Group;

                                $newGroup -> name = $groups[$i];

                                $newGroup -> save();

                                //echo "Added | " . $row -> first_name . $row -> last_name . " | " . $newGroup -> name . "<br>";
                                $account -> groups() -> attach($newGroup);
                            } else {
                                //echo "Added | " . $row -> first_name . $row -> last_name . " | " . $getGroup -> name . "<br>";
                                $account -> groups() -> attach($getGroup);
                            }
                        }

                        // Add users parents to the database
                        // one user can only have 2 parents

                        if ($row -> parent1_first_name) {
                            $elder1 = new Elder;

                            $elder1 -> firstName = str_replace('"', "", $row -> parent1_first_name);
                            $elder1 -> lastName = str_replace('"', "", $row -> parent1_last_name);
                            $elder1 -> personalCode = str_replace('"', "", $row -> parent1_personal_code);
                            $elder1 -> email = str_replace('"', "", $row -> parent1_email);

                            $elder1 -> save();
                        }

                        if ($row -> parent2_first_name) {
                            $elder2 = new Elder;

                            $elder2 -> firstName = str_replace('"', "", $row -> parent2_first_name);
                            $elder2 -> lastName = str_replace('"', "", $row -> parent2_last_name);
                            $elder2 -> personalCode = str_replace('"', "", $row -> parent2_personal_code);
                            $elder2 -> email = str_replace('"', "", $row -> parent2_email);

                            $elder2 -> save();
                        }
                    } else {
                        echo "<pre>";
                        var_dump($row);
                        echo "</pre>";
                    }
                });
            }, 'ISO-8859-15');
            return redirect('/accounts');
        } else {
            return redirect('/accounts/create');
        }
    }
}
