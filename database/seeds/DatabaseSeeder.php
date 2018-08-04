<?php

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
        //$this->call(Users::class);
        $this->call(RolePermissions::class);
        $this->call(SportSeeder::class);
        $this->call(CoachSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(FederationSeeder::class);
        //$this->call(PlanSeeder::class);
        $this->call(AccessoriesSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(OrphanProgram::class);


    }
}
