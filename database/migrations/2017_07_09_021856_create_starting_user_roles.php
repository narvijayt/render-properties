<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStartingUserRoles extends Migration
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
                    'name' => 'admin',
                    'display_name' => 'Admin',
                    'description' => 'Admin Role',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'realtor',
                    'display_name' => 'Realtor',
                    'description' => 'Realtor Role',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'broker',
                    'display_name' => 'Broker',
                    'description' => 'Broker Role',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
            ]);
        DB::table('permissions')
            ->insert([
                [
                    'name' => 'inbox',
                    'display_name' => 'Inbox',
                    'description' => 'Inbox Permission',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]
            ]);
        DB::table('permission_role')
            ->insert([
                [
                    'permission_id' => DB::table('permissions')->select('id')->where('name', 'inbox')->first()->id,
                    'role_id' => DB::table('roles')->select('id')->where('name', 'admin')->first()->id
                ],
                [
                    'permission_id' => DB::table('permissions')->select('id')->where('name', 'inbox')->first()->id,
                    'role_id' => DB::table('roles')->select('id')->where('name', 'realtor')->first()->id
                ],
                [
                    'permission_id' => DB::table('permissions')->select('id')->where('name', 'inbox')->first()->id,
                    'role_id' => DB::table('roles')->select('id')->where('name', 'broker')->first()->id
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
            ->whereIn('name', ['admin', 'realtor', 'broker'])
            ->delete();
    }
}
