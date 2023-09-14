<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScholarEnrollmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('scholar_enrollments')->delete();
        
        \DB::table('scholar_enrollments')->insert(array (
            0 => 
            array (
                'id' => 9,
                'is_clear' => 1,
                'is_locked' => 1,
                'is_given' => 0,
                'attachment' => '{"grades": [{"file": "uploads/AQ7xge9aL6/Grades/grades_3rd-2021-2022-Second Semester.pdf", "name": "grades_3rd-2021-2022-Second Semester.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:10 pm"}], "enrollments": {"file": "uploads/AQ7xge9aL6/Enrollments/3rd-2021-2022-Second Semester.pdf", "name": "3rd-2021-2022-Second Semester.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:10 pm"}}',
                'semester_id' => 1,
                'level_id' => 26,
                'scholar_id' => 914,
                'added_by' => 1,
                'created_at' => '2023-06-06 18:10:05',
                'updated_at' => '2023-06-06 18:10:31',
            ),
            1 => 
            array (
                'id' => 10,
                'is_clear' => 1,
                'is_locked' => 1,
                'is_given' => 0,
                'attachment' => '{"grades": [{"file": "uploads/AQ7xge9aL6/Grades/grades_3rd-2021-2022-Summer Class.pdf", "name": "grades_3rd-2021-2022-Summer Class.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:11 pm"}], "enrollments": {"file": "uploads/AQ7xge9aL6/Enrollments/3rd-2021-2022-Summer Class.pdf", "name": "3rd-2021-2022-Summer Class.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:11 pm"}}',
                'semester_id' => 2,
                'level_id' => 26,
                'scholar_id' => 914,
                'added_by' => 1,
                'created_at' => '2023-06-06 18:11:06',
                'updated_at' => '2023-06-06 18:11:28',
            ),
            2 => 
            array (
                'id' => 11,
                'is_clear' => 1,
                'is_locked' => 1,
                'is_given' => 0,
                'attachment' => '{"grades": [{"file": "uploads/AQ7xge9aL6/Grades/grades_4th-2022-2023-First Semester.pdf", "name": "grades_4th-2022-2023-First Semester.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:12 pm"}], "enrollments": {"file": "uploads/AQ7xge9aL6/Enrollments/4th-2022-2023-First Semester-1.pdf", "name": "4th-2022-2023-First Semester-1.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:12 pm"}}',
                'semester_id' => 3,
                'level_id' => 27,
                'scholar_id' => 914,
                'added_by' => 1,
                'created_at' => '2023-06-06 18:12:06',
                'updated_at' => '2023-06-06 18:12:34',
            ),
            3 => 
            array (
                'id' => 12,
                'is_clear' => 1,
                'is_locked' => 0,
                'is_given' => 0,
                'attachment' => '{"grades": [{"file": "uploads/AQ7xge9aL6/Grades/grades_4th-2022-2023-Second Semester.pdf", "name": "grades_4th-2022-2023-Second Semester.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:13 pm"}], "enrollments": {"file": "uploads/AQ7xge9aL6/Enrollments/4th-2022-2023-Second Semester.pdf", "name": "4th-2022-2023-Second Semester.pdf", "added_by": 1, "created_at": "Jun 06, 2023 6:12 pm"}}',
                'semester_id' => 4,
                'level_id' => 27,
                'scholar_id' => 914,
                'added_by' => 1,
                'created_at' => '2023-06-06 18:12:53',
                'updated_at' => '2023-06-06 18:13:11',
            ),
            4 => 
            array (
                'id' => 13,
                'is_clear' => 0,
                'is_locked' => 0,
                'is_given' => 0,
                'attachment' => '{"grades": [], "enrollments": {"file": "uploads/DLjxlqYoBY/Enrollments/2nd-2022-2023-Second Semester.pdf", "name": "2nd-2022-2023-Second Semester.pdf", "added_by": 1, "created_at": "Jun 07, 2023 7:51 am"}}',
                'semester_id' => 4,
                'level_id' => 25,
                'scholar_id' => 965,
                'added_by' => 1,
                'created_at' => '2023-06-07 07:51:53',
                'updated_at' => '2023-06-07 07:51:53',
            ),
            5 => 
            array (
                'id' => 14,
                'is_clear' => 0,
                'is_locked' => 0,
                'is_given' => 0,
                'attachment' => '{"grades": [], "enrollments": {"file": "uploads/47VXwK1XMA/Enrollments/1st-2022-2023-Second Semester.pdf", "name": "1st-2022-2023-Second Semester.pdf", "added_by": 1, "created_at": "Jun 07, 2023 7:56 am"}}',
                'semester_id' => 4,
                'level_id' => 24,
                'scholar_id' => 937,
                'added_by' => 1,
                'created_at' => '2023-06-07 07:56:16',
                'updated_at' => '2023-06-07 07:56:16',
            ),
        ));
        
        
    }
}