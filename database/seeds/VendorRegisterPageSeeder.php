<?php

use Illuminate\Database\Seeder;
use App\VendorRegisterPageBuilder;
use Carbon\Carbon;

class VendorRegisterPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getVendorRegisterPageDetails = VendorRegisterPageBuilder::first();
        if (!is_null($getVendorRegisterPageDetails)) {
            VendorRegisterPageBuilder::truncate();
        }

        DB::table('vendor_register_page_builder')->insert([
            'userId' => 3,
            'banner' => VendorRegisterPageBuilder::$banner,
            'section_1_Header' => VendorRegisterPageBuilder::$section1Header,
            'section_1' => VendorRegisterPageBuilder::$section1,
            'section_2' => VendorRegisterPageBuilder::$section2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
