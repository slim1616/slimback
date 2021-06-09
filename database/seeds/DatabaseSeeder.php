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
        $this->call(DepartementTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        // $this->call(EmployesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BatimentsSeeder::class);
        $this->call(ZoneSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(PorteSeeder::class);
        
        
        
    }
}
