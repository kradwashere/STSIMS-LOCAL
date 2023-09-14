<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListBenefitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_benefits')->delete();
        
        \DB::table('list_benefits')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Stipend',
                'type' => 'Monthly',
                'amount' => '7000.00',
                'is_summer' => 0,
                'is_fixed' => 1,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Book Allowance',
                'type' => 'Term',
                'amount' => '10000.00',
                'is_summer' => 0,
                'is_fixed' => 1,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Tuition',
                'type' => 'Term',
                'amount' => '20000.00',
                'is_summer' => 0,
                'is_fixed' => 0,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Clothing',
                'type' => 'One-Time',
                'amount' => '2000.00',
                'is_summer' => 0,
                'is_fixed' => 0,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Thesis',
                'type' => 'One-Time',
                'amount' => '10000.00',
                'is_summer' => 0,
                'is_fixed' => 1,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Transportation',
                'type' => 'Academic Year',
                'amount' => '2000.00',
                'is_summer' => 0,
                'is_fixed' => 0,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Graduation Fee',
                'type' => 'Academic Year',
                'amount' => '1000.00',
                'is_summer' => 0,
                'is_fixed' => 1,
                'is_active' => 1,
                'information' => '[]',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
        ));
        
        
    }
}