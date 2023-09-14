<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schools')->delete();
        
        \DB::table('schools')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'ANDRES BONIFACIO COLLEGE',
                'shortcut' => 'ABCollege',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:21:56',
                'updated_at' => '2023-05-21 10:21:56',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'ATENEO DE ZAMBOANGA UNIVERSITY',
                'shortcut' => 'ADZU',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:25:55',
                'updated_at' => '2023-05-21 10:25:55',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'BASILAN STATE COLLEGE',
                'shortcut' => 'BasSC',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:28:06',
                'updated_at' => '2023-05-21 10:28:06',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'DIPOLOG CITY INSTITUTE OF TECHNOLOGY',
                'shortcut' => 'DCIT',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:29:04',
                'updated_at' => '2023-05-21 10:29:04',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'DIPOLOG MEDICAL CENTER COLLEGE FOUNDATION, INC.',
                'shortcut' => 'DMC',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:30:35',
                'updated_at' => '2023-05-21 10:30:35',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'JH CERILLES STATE COLLEGE',
                'shortcut' => 'JHCSC',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:31:55',
                'updated_at' => '2023-05-21 10:31:55',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'JOSE RIZAL MEMORIAL STATE UNIVERSITY',
                'shortcut' => 'JRMSU',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:32:44',
                'updated_at' => '2023-05-21 10:32:44',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'MEDINA COLLEGE',
                'shortcut' => 'MC',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:33:52',
                'updated_at' => '2023-05-21 10:33:52',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'MINDANAO STATE UNIVERSITY',
                'shortcut' => 'MSU',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:34:16',
                'updated_at' => '2023-05-21 10:34:16',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'SAINT COLUMBAN COLLEGE',
                'shortcut' => 'SCC',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:34:54',
                'updated_at' => '2023-05-21 10:34:54',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'SAINT JOSEPH COLLEGE OF SINDANGAN',
                'shortcut' => 'SJCSI',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:35:42',
                'updated_at' => '2023-05-21 10:35:42',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'SAINT VINCENT\'S COLLEGE',
                'shortcut' => 'SVC',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:37:59',
                'updated_at' => '2023-05-21 10:37:59',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'SOUTHERN MINDANAO COLLEGES',
                'shortcut' => 'SMC',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:39:22',
                'updated_at' => '2023-05-21 10:39:22',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'UNIVERSIDAD DE ZAMBOANGA',
                'shortcut' => 'UZ',
                'avatar' => 'school.jpg',
                'class_id' => 2,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:40:52',
                'updated_at' => '2023-05-21 10:40:52',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'WESTERN MINDANAO STATE UNIVERSITY',
                'shortcut' => 'WMSU',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:41:08',
                'updated_at' => '2023-05-21 10:41:08',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'ZAMBOANGA PENINSULA POLYTECHNIC STATE UNIVERSITY',
                'shortcut' => 'ZPPSU',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:51:15',
                'updated_at' => '2023-05-21 10:51:15',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',
                'shortcut' => 'ZSCMST',
                'avatar' => 'school.jpg',
                'class_id' => 3,
                'is_upsystem' => 0,
                'is_active' => 1,
                'created_at' => '2023-05-21 10:51:53',
                'updated_at' => '2023-05-21 10:51:53',
            ),
        ));
        
        
    }
}