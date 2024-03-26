<?php

use Illuminate\Database\Seeder;
use App\RealtorRegisterPageBuilder;
use Carbon\Carbon;

class RealtorRegisterPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getRealtorRegisterPageDetails = RealtorRegisterPageBuilder::first();
        if (!is_null($getRealtorRegisterPageDetails)) {
            RealtorRegisterPageBuilder::truncate();
        }

        DB::table('realtor_register_page_builder')->insert([
            'userId' => 3,
            'banner' => RealtorRegisterPageBuilder::$banner,
            'section_1_Header' => RealtorRegisterPageBuilder::$section1Header,
            'section_1' => RealtorRegisterPageBuilder::$section1,
            'section_2' => RealtorRegisterPageBuilder::$section2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
