<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table -> increments('userID');
            $table -> boolean('active');

            $table -> string('firstName') -> nullable();
            $table -> string('lastName') -> nullable();
            $table -> string('extraName') -> nullable();
            $table -> string('email') -> nullable();

            $table -> string('personalCode') -> nullable();

            $table -> string('homeAddress') -> nullable();
            $table -> string('workAddress') -> nullable();

            $table -> string('homePhone') -> nullable();
            $table -> string('mobilePhone') -> nullable();

            $table -> string('jobTitle') -> nullable();
            $table -> string('employer') -> nullable();
            $table -> text('comments') -> nullable();

            $table -> string('pan') -> nullable(); // ???
            $table -> string('businessName') -> nullable(); // ???

            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
