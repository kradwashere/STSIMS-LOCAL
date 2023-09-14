<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profiles')->delete();
        
        \DB::table('user_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Ra-ouf',
                'lastname' => 'Jumli',
                'middlename' => 'Indanan',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09171531652',
                'agency_id' => NULL,
                'user_id' => 1,
                'created_at' => '2023-05-23 14:09:38',
                'updated_at' => '2023-05-23 14:09:38',
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'Dost-i',
                'lastname' => 'R1',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345671',
                'agency_id' => 1,
                'user_id' => 2,
                'created_at' => '2023-05-23 14:10:19',
                'updated_at' => '2023-05-23 14:10:19',
            ),
            2 => 
            array (
                'id' => 3,
                'firstname' => 'Dost-ii',
                'lastname' => 'R2',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345672',
                'agency_id' => 2,
                'user_id' => 3,
                'created_at' => '2023-05-23 14:12:10',
                'updated_at' => '2023-05-23 14:12:10',
            ),
            3 => 
            array (
                'id' => 4,
                'firstname' => 'Dost-iii',
                'lastname' => 'R3',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345673',
                'agency_id' => 3,
                'user_id' => 4,
                'created_at' => '2023-05-23 14:12:17',
                'updated_at' => '2023-05-23 14:12:17',
            ),
            4 => 
            array (
                'id' => 5,
                'firstname' => 'Dost-iva',
                'lastname' => 'Calabarzon',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345674',
                'agency_id' => 4,
                'user_id' => 5,
                'created_at' => '2023-05-23 14:12:56',
                'updated_at' => '2023-05-23 14:12:56',
            ),
            5 => 
            array (
                'id' => 6,
                'firstname' => 'Dost-ivb',
                'lastname' => 'Mimaropa',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345675',
                'agency_id' => 5,
                'user_id' => 6,
                'created_at' => '2023-05-23 14:13:00',
                'updated_at' => '2023-05-23 14:13:00',
            ),
            6 => 
            array (
                'id' => 7,
                'firstname' => 'Dost-v',
                'lastname' => 'R5',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345676',
                'agency_id' => 6,
                'user_id' => 7,
                'created_at' => '2023-05-23 14:13:05',
                'updated_at' => '2023-05-23 14:13:05',
            ),
            7 => 
            array (
                'id' => 8,
                'firstname' => 'Dost-vi',
                'lastname' => 'R6',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345677',
                'agency_id' => 7,
                'user_id' => 8,
                'created_at' => '2023-05-23 14:13:09',
                'updated_at' => '2023-05-23 14:13:09',
            ),
            8 => 
            array (
                'id' => 9,
                'firstname' => 'Dost-vii',
                'lastname' => 'R7',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345678',
                'agency_id' => 8,
                'user_id' => 9,
                'created_at' => '2023-05-23 14:13:17',
                'updated_at' => '2023-05-23 14:13:17',
            ),
            9 => 
            array (
                'id' => 10,
                'firstname' => 'Dost-viii',
                'lastname' => 'R8',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '0912345679',
                'agency_id' => 9,
                'user_id' => 10,
                'created_at' => '2023-05-23 14:13:22',
                'updated_at' => '2023-05-23 14:13:22',
            ),
            10 => 
            array (
                'id' => 11,
                'firstname' => 'Dost-ix',
                'lastname' => 'R9',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456710',
                'agency_id' => 10,
                'user_id' => 11,
                'created_at' => '2023-05-23 14:13:26',
                'updated_at' => '2023-05-23 14:13:26',
            ),
            11 => 
            array (
                'id' => 12,
                'firstname' => 'Dost-x',
                'lastname' => 'R10',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456711',
                'agency_id' => 11,
                'user_id' => 12,
                'created_at' => '2023-05-23 14:13:31',
                'updated_at' => '2023-05-23 14:13:31',
            ),
            12 => 
            array (
                'id' => 13,
                'firstname' => 'Dost-xi',
                'lastname' => 'R11',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456712',
                'agency_id' => 12,
                'user_id' => 13,
                'created_at' => '2023-05-23 14:13:36',
                'updated_at' => '2023-05-23 14:13:36',
            ),
            13 => 
            array (
                'id' => 14,
                'firstname' => 'Dost-xii',
                'lastname' => 'R12',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456713',
                'agency_id' => 13,
                'user_id' => 14,
                'created_at' => '2023-05-23 14:13:41',
                'updated_at' => '2023-05-23 14:13:41',
            ),
            14 => 
            array (
                'id' => 15,
                'firstname' => 'Dost-caraga',
                'lastname' => 'Caraga',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456714',
                'agency_id' => 14,
                'user_id' => 15,
                'created_at' => '2023-05-23 14:13:45',
                'updated_at' => '2023-05-23 14:13:45',
            ),
            15 => 
            array (
                'id' => 16,
                'firstname' => 'Dost-car',
                'lastname' => 'Car',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456715',
                'agency_id' => 15,
                'user_id' => 16,
                'created_at' => '2023-05-23 14:13:49',
                'updated_at' => '2023-05-23 14:13:49',
            ),
            16 => 
            array (
                'id' => 17,
                'firstname' => 'Dost-barmm',
                'lastname' => 'Barmm',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456716',
                'agency_id' => 16,
                'user_id' => 17,
                'created_at' => '2023-05-23 14:13:54',
                'updated_at' => '2023-05-23 14:13:54',
            ),
            17 => 
            array (
                'id' => 18,
                'firstname' => 'Dost-ncr',
                'lastname' => 'Ncr',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123456717',
                'agency_id' => 17,
                'user_id' => 18,
                'created_at' => '2023-05-23 14:13:58',
                'updated_at' => '2023-05-23 14:13:58',
            ),
        ));
        
        
    }
}