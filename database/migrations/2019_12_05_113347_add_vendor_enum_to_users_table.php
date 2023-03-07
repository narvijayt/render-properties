<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorEnumToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('users', function (Blueprint $table) {
            /*DB::statement("alter type user_account_type rename to _user_account_type");
            DB::statement("create type user_account_type as enum ('vendor', 'realtor', 'broker')");
            DB::statement("alter table users rename column user_type to _user_type");
            DB::statement("alter table users add user_type user_account_type");
            DB::statement("update users set user_type = _user_type::text::user_account_type");
            DB::statement("alter type _user_account_type rename to user_account_type");
            DB::statement("alter type _user_type rename to user_type");*/
            
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // DB::statement("alter table users rename column _user_type to user_type");
        // DB::statement("create type user_account_type as enum ('realtor', 'broker')");
           // DB::statement("alter type _user_account_type rename to user_account_type");
            
        });
    }
}
