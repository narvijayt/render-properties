<?php

use Illuminate\Database\Seeder;
use App\HomePageBuilder;
use Carbon\Carbon;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $getHomePageDetails = HomePageBuilder::first();
        if (!is_null($getHomePageDetails)) {
            HomePageBuilder::truncate();
        }

        DB::table('home_page_builder')->insert([
            'userId' => 3,
            'banner' => HomePageBuilder::$banner,
            'section_1' => HomePageBuilder::$section1,
            'section_2' => HomePageBuilder::$section2,
            'section_3' => HomePageBuilder::$section3,
            'section_4' => HomePageBuilder::$section4,
            'section_5' => HomePageBuilder::$section5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
