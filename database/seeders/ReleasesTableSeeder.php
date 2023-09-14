<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReleasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('releases')->delete();
        
        \DB::table('releases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'batch' => '00001',
                'attachment' => '[]',
                'dv_no' => NULL,
                'total' => '298000.00',
                'added_by' => 1,
                'status_id' => 11,
                'created_at' => '2023-06-07 09:02:30',
                'updated_at' => '2023-06-07 09:02:30',
            ),
        ));
        
        
    }
}