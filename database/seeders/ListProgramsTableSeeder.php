<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListProgramsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_programs')->delete();
        
        \DB::table('list_programs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'RA 7687',
                'others' => 'n/a',
                'is_sub' => 1,
                'is_active' => 1,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'RA 10612',
                'others' => 'n/a',
                'is_sub' => 1,
                'is_active' => 1,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'MERIT',
                'others' => 'n/a',
                'is_sub' => 1,
                'is_active' => 1,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'SFA',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'CSF',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'NSDB',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'INTAPS',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'PROJECT 7405 ED.',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'PROJECT 8102 ED.',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'PROJECT 7707 ED.',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'IPSED',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'NSTA',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'REPLACEMENT',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'MERIT-ALT',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'PROJECT 8901 ED.',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'PROJECT 9001 ED.',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'JLAP',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'NAPOCOR',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'PROJECT 884-121D',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'SSSG',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'JLAP-RA',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'JLAP-MERIT',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'GREAT-M',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'PROJECT 2004-01 ED.',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'GIFTS',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'JLSS',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'RA-SS',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'MERIT-SS',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'BRIDGING',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'LADDERIZED',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'MERIT-B',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'IP',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'MERIT-SSSG',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'RA-SSSG',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'MAINSTREAM',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'JLSS-BS MET',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'SOPHOMORE',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'BANGON MARAWI',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'GRANT',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 0,
                'created_at' => '2023-05-22 02:23:56',
                'updated_at' => '2023-05-22 02:23:56',
            ),
        ));
        
        
    }
}