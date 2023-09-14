<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'username' => 'administrator',
            'email' => 'kradjumli@gmail.com',
            'password' => bcrypt('123456789'),
            'role' => 'Administrator',
            'avatar' => 'administrator.png',
            'is_active' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);

        \DB::table('user_profiles')->insert([
            'firstname' => 'Ra-ouf',
            'lastname' => 'Jumli',
            'middlename' => 'Indanan',
            'gender' => 'Male',
            'user_id' => 1,
            'mobile' => '09171531652',
            'profileable_type' => 'App\Models\LocationRegion',
            'profileable_id' =>'090000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
       
        // $this->call(LocationRegionsTableSeeder::class);
        // $this->call(LocationProvincesTableSeeder::class);
        // $this->call(LocationMunicipalitiesTableSeeder::class);
        // $this->call(LocationBarangaysTableSeeder::class);
        // $this->call(ListAgenciesTableSeeder::class);
        // $this->call(ListPrivilegesTableSeeder::class);
        // $this->call(ListProgramsTableSeeder::class);
        // $this->call(ListDropdownsTableSeeder::class);
        // $this->call(SchoolsTableSeeder::class);
        // $this->call(SchoolCampusesTableSeeder::class);
        // $this->call(ListCoursesTableSeeder::class);
        // $this->call(ListStatusesTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(UserProfilesTableSeeder::class);
        
        // $this->call(ScholarsTableSeeder::class);
        // $this->call(ScholarAddressesTableSeeder::class);
        // $this->call(ScholarProfilesTableSeeder::class);
        // $this->call(ScholarEducationTableSeeder::class);


        // $this->call(SchoolCourseProspectusesTableSeeder::class);
        // $this->call(SchoolSemestersTableSeeder::class);
        // $this->call(EnrolleesTableSeeder::class);
        // $this->call(ReleasesTableSeeder::class);
        // $this->call(ScholarBenefitsTableSeeder::class);
        // $this->call(ScholarEnrollmentsTableSeeder::class);
        // $this->call(ScholarEnrollmentListsTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
    }
}
