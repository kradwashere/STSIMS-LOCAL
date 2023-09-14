<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListPrivilegesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_privileges')->delete();
        
        \DB::table('list_privileges')->insert(array (
            0 => 
            array (
                'created_at' => '2022-07-25 09:54:00',
                'id' => 1,
                'is_active' => 1,
                'is_fixed' => 1,
                'is_reimburseable' => 0,
                'name' => 'Stipend',
                'regular_amount' => '7000.00',
                'summer_amount' => '7000.00',
                'type' => 'Monthly',
                'updated_at' => '2022-07-25 09:54:00',
            ),
            1 => 
            array (
                'created_at' => '2022-07-25 09:55:16',
                'id' => 2,
                'is_active' => 1,
                'is_fixed' => 0,
                'is_reimburseable' => 1,
                'name' => 'Tuition & Other School Fees',
                'regular_amount' => '40000.00',
                'summer_amount' => '10000.00',
                'type' => 'Term',
                'updated_at' => '2022-07-25 09:55:16',
            ),
            2 => 
            array (
                'created_at' => '2022-07-25 09:58:29',
                'id' => 3,
                'is_active' => 1,
                'is_fixed' => 1,
                'is_reimburseable' => 0,
                'name' => 'Learning Materials / Connectivity Allowance',
                'regular_amount' => '10000.00',
                'summer_amount' => '2000.00',
                'type' => 'Term',
                'updated_at' => '2022-07-25 09:58:29',
            ),
            3 => 
            array (
                'created_at' => '2022-07-25 09:59:41',
                'id' => 4,
                'is_active' => 1,
                'is_fixed' => 0,
                'is_reimburseable' => 1,
                'name' => 'Transportation Allowance',
                'regular_amount' => '0.00',
                'summer_amount' => '0.00',
                'type' => 'Academic Year',
                'updated_at' => '2022-07-25 09:59:41',
            ),
            4 => 
            array (
                'created_at' => '2022-07-25 10:01:50',
                'id' => 5,
                'is_active' => 1,
                'is_fixed' => 1,
                'is_reimburseable' => 0,
                'name' => 'Clothing Allowance',
                'regular_amount' => '1000.00',
                'summer_amount' => '0.00',
                'type' => 'One-Time',
                'updated_at' => '2022-07-25 10:01:50',
            ),
            5 => 
            array (
                'created_at' => '2022-07-25 10:02:29',
                'id' => 6,
                'is_active' => 1,
                'is_fixed' => 1,
                'is_reimburseable' => 1,
                'name' => 'Thesis Allowance',
                'regular_amount' => '10000.00',
                'summer_amount' => '0.00',
                'type' => 'One-Time',
                'updated_at' => '2022-07-25 10:02:29',
            ),
            6 => 
            array (
                'created_at' => '2022-07-25 10:03:21',
                'id' => 7,
                'is_active' => 1,
                'is_fixed' => 1,
                'is_reimburseable' => 1,
                'name' => 'Graduation Allowance',
                'regular_amount' => '1000.00',
                'summer_amount' => '0.00',
                'type' => 'One-Time',
                'updated_at' => '2022-07-25 10:03:21',
            ),
            7 => 
            array (
                'created_at' => '2022-07-25 10:03:51',
                'id' => 8,
                'is_active' => 1,
                'is_fixed' => 0,
                'is_reimburseable' => 1,
                'name' => 'Group Accident Insurance',
                'regular_amount' => '0.00',
                'summer_amount' => '0.00',
                'type' => 'Premium',
                'updated_at' => '2022-07-25 10:03:51',
            ),
            8 => 
            array (
                'created_at' => '2022-07-25 10:03:51',
                'id' => 9,
                'is_active' => 0,
                'is_fixed' => 0,
                'is_reimburseable' => 1,
                'name' => 'Others',
                'regular_amount' => '0.00',
                'summer_amount' => '0.00',
                'type' => 'Optional',
                'updated_at' => '2022-07-25 10:03:51',
            ),
        ));
        
        
    }
}