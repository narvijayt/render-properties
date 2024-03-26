<?php

use Illuminate\Database\Seeder;
use App\LenderRegisterPageBuilder;
use Carbon\Carbon;

class LenderRegisterPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getLenderRegisterPageDetails = LenderRegisterPageBuilder::first();
        if (!is_null($getLenderRegisterPageDetails)) {
            LenderRegisterPageBuilder::truncate();
        }

        DB::table('lender_register_page_builder')->insert([
            'userId' => 3,
            'banner' => LenderRegisterPageBuilder::$banner,
            'section_1_Header' => LenderRegisterPageBuilder::$section1Header,
            'section_1' => LenderRegisterPageBuilder::$section1,
            'section_2' => LenderRegisterPageBuilder::$section2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
