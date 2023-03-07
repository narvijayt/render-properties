<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnumToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')
            ->insert([
               [
                    'name' => 'vendor',
                    'title' => 'Vendor',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::table('roles')
            ->whereIn('name', ['vendor'])
            ->delete();
    }
}
