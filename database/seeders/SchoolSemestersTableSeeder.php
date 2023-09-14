<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolSemestersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('school_semesters')->delete();
        
        \DB::table('school_semesters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'academic_year' => '2021-2022',
                'start_at' => '2021-01-01',
                'end_at' => '2021-05-31',
                'semester_id' => 11,
                'school_id' => 18,
                'is_active' => 0,
                'created_at' => '2023-06-06 16:07:02',
                'updated_at' => '2023-06-06 16:08:27',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_year' => '2021-2022',
                'start_at' => '2021-06-01',
                'end_at' => '2021-07-31',
                'semester_id' => 12,
                'school_id' => 18,
                'is_active' => 0,
                'created_at' => '2023-06-06 16:07:20',
                'updated_at' => '2023-06-06 16:08:27',
            ),
            2 => 
            array (
                'id' => 3,
                'academic_year' => '2022-2023',
                'start_at' => '2022-01-01',
                'end_at' => '2022-05-31',
                'semester_id' => 10,
                'school_id' => 18,
                'is_active' => 0,
                'created_at' => '2023-06-06 16:08:15',
                'updated_at' => '2023-06-06 16:08:27',
            ),
            3 => 
            array (
                'id' => 4,
                'academic_year' => '2022-2023',
                'start_at' => '2022-08-01',
                'end_at' => '2022-12-31',
                'semester_id' => 11,
                'school_id' => 18,
                'is_active' => 1,
                'created_at' => '2023-06-06 16:08:27',
                'updated_at' => '2023-06-06 16:08:27',
            ),
        ));
        
        
    }
}