<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriesToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('category')
            ->insert([
                [
                    'name' => 'Auto',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Flooring',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Mortgage',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Appliance',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Home Warranty',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Moving',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Builder',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Inspection',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Photography',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Carpet Cleaning',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                 [
                    'name' => 'Insurance',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Property Management',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Cleaning',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Landscaping',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Roofing',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Crawl Spacing',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Locks',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Staging',
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ],
                [
                    'name' => 'Other',
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
          DB::table('category')
            ->whereIn('name',
            ['Auto',
            'Flooring',
            'Mortgage',
            'Appliance',
            'Home Warranty',
            'Moving',
            'Builder',
            'Inspection',
            'Photography',
            'Carpet Cleaning',
            'Insurance',
            'Property Management',
            'Cleaning',
            'Landscaping',
            'Roofing',
            'Crawl Spacing',
            'Locks',
            'Staging',
            'Other'
            ])
            ->delete();
    }
}
