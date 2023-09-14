<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnrolleesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('enrollees')->delete();
        
        \DB::table('enrollees')->insert(array (
            0 => 
            array (
                'id' => 9,
                'is_grades_completed' => 1,
                'is_benefits_released' => 0,
                'school_semester_id' => 1,
                'scholar_id' => 914,
                'created_at' => '2023-06-06 18:10:05',
                'updated_at' => '2023-06-06 18:10:31',
            ),
            1 => 
            array (
                'id' => 10,
                'is_grades_completed' => 1,
                'is_benefits_released' => 0,
                'school_semester_id' => 2,
                'scholar_id' => 914,
                'created_at' => '2023-06-06 18:11:06',
                'updated_at' => '2023-06-06 18:11:28',
            ),
            2 => 
            array (
                'id' => 11,
                'is_grades_completed' => 1,
                'is_benefits_released' => 0,
                'school_semester_id' => 3,
                'scholar_id' => 914,
                'created_at' => '2023-06-06 18:12:06',
                'updated_at' => '2023-06-06 18:12:34',
            ),
            3 => 
            array (
                'id' => 12,
                'is_grades_completed' => 1,
                'is_benefits_released' => 0,
                'school_semester_id' => 4,
                'scholar_id' => 914,
                'created_at' => '2023-06-06 18:12:53',
                'updated_at' => '2023-06-06 18:13:11',
            ),
            4 => 
            array (
                'id' => 13,
                'is_grades_completed' => 0,
                'is_benefits_released' => 0,
                'school_semester_id' => 4,
                'scholar_id' => 965,
                'created_at' => '2023-06-07 07:51:53',
                'updated_at' => '2023-06-07 07:51:53',
            ),
            5 => 
            array (
                'id' => 14,
                'is_grades_completed' => 0,
                'is_benefits_released' => 0,
                'school_semester_id' => 4,
                'scholar_id' => 937,
                'created_at' => '2023-06-07 07:56:16',
                'updated_at' => '2023-06-07 07:56:16',
            ),
        ));
        
        
    }
}