<?php

use Illuminate\Database\Seeder;
use App\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=> 'Super Administrateur', 'slug' => 'superadmin']);
        Role::create(['name'=> 'Admin', 'slug' => 'admin']);
        Role::create(['name'=> 'User', 'slug' => 'user']);
        
    }
}
