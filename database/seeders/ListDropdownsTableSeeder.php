<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListDropdownsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_dropdowns')->delete();
        
        \DB::table('list_dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'N/a',
                'classification' => 'n/a',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Private',
                'classification' => 'Class',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Public',
                'classification' => 'Class',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Semester',
                'classification' => 'Term Type',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Trimester',
                'classification' => 'Term Type',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Quarter Term',
                'classification' => 'Term Type',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Transmutation',
                'classification' => 'Grading System',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Percent Grading',
                'classification' => 'Grading System',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Per Grade',
                'classification' => 'Grading System',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'First Semester',
                'classification' => 'Semester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Second Semester',
                'classification' => 'Semester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Summer Class',
                'classification' => 'Semester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'summer',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'First Quarter',
                'classification' => 'Trimester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Second Quarter',
                'classification' => 'Trimester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Third Quarter',
                'classification' => 'Trimester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Summer',
                'classification' => 'Trimester',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'summer',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'First Quarter',
                'classification' => 'Quarter Term',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Second Quarter',
                'classification' => 'Quarter Term',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Third Quarter',
                'classification' => 'Quarter Term',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Fourth Quarter',
                'classification' => 'Quarter Term',
                'type' => 'term',
                'color' => 'n/a',
                'others' => 'regular',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Full',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Special',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Partial',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => '1st',
                'classification' => 'Level',
                'type' => '1',
                'color' => 'n/a',
                'others' => 'First Year',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => '2nd',
                'classification' => 'Level',
                'type' => '2',
                'color' => 'n/a',
                'others' => 'Second Year',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => '3rd',
                'classification' => 'Level',
                'type' => '3',
                'color' => 'n/a',
                'others' => 'Third Year',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => '4th',
                'classification' => 'Level',
                'type' => '4',
                'color' => 'n/a',
                'others' => 'Fourth Year',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => '5th',
                'classification' => 'Level',
                'type' => '5',
                'color' => 'n/a',
                'others' => 'Fifth Year',
            ),
        ));
        
        
    }
}