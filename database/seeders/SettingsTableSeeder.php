<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'year' => 2022,
                'api_key' => NULL,
            'information' => '{"fax": "(062) 992-1114", "mobile": "", "address": "Pettit Barracks, Barangay Zone IV, Zamboanga City", "facebook": "https://www.facebook.com/DOSTRegion9", "telephone": "(062) 991-1024"}',
                'signatories' => '{"Approved By": {"name": "", "position": ""}, "Prepared By": {"name": "", "position": ""}, "Reviewed By": {"name": "", "position": ""}, "Verified Correct": {"name": "", "position": ""}, "Certified Correct": {"name": "", "position": ""}}',
                'agency_id' => 10,
                'created_at' => '2023-07-26 13:44:02',
                'updated_at' => '2023-07-26 13:45:47',
            ),
        ));
        
        
    }
}