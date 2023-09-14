<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationRegionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_regions')->delete();
        
        \DB::table('location_regions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '010000000',
                'name' => 'Ilocos Region',
                'region' => 'Region I',
                'island' => 'luzon',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '020000000',
                'name' => 'Cagayan Valley',
                'region' => 'Region II',
                'island' => 'luzon',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '030000000',
                'name' => 'Central Luzon',
                'region' => 'Region III',
                'island' => 'luzon',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '040000000',
                'name' => 'CALABARZON',
                'region' => 'Region IV-A',
                'island' => 'luzon',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '170000000',
                'name' => 'MIMAROPA Region',
                'region' => 'MIMAROPA Region',
                'island' => 'luzon',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '050000000',
                'name' => 'Bicol Region',
                'region' => 'Region V',
                'island' => 'luzon',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '060000000',
                'name' => 'Western Visayas',
                'region' => 'Region VI',
                'island' => 'visayas',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '070000000',
                'name' => 'Central Visayas',
                'region' => 'Region VII',
                'island' => 'visayas',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '080000000',
                'name' => 'Eastern Visayas',
                'region' => 'Region VIII',
                'island' => 'visayas',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '090000000',
                'name' => 'Zamboanga Peninsula',
                'region' => 'Region IX',
                'island' => 'mindanao',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '100000000',
                'name' => 'Northern Mindanao',
                'region' => 'Region X',
                'island' => 'mindanao',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '110000000',
                'name' => 'Davao Region',
                'region' => 'Region XI',
                'island' => 'mindanao',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '120000000',
                'name' => 'SOCCSKSARGEN',
                'region' => 'Region XII',
                'island' => 'mindanao',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '130000000',
                'name' => 'National Capital Region',
                'region' => 'NCR',
                'island' => 'luzon',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '140000000',
                'name' => 'Cordillera Administrative Region',
                'region' => 'CAR',
                'island' => 'luzon',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '150000000',
                'name' => 'Bangasamoro Autonomous Region in Muslim Mindanao',
                'region' => 'BARMM',
                'island' => 'mindanao',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '160000000',
                'name' => 'Caraga',
                'region' => 'Region XIII',
                'island' => 'mindanao',
            ),
        ));
        
        
    }
}