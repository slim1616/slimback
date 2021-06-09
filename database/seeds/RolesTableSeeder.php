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
        Role::create(['name'=> 'Administrateur', 'slug' => 'admin']);
        Role::create(['name'=> 'RH', 'slug' => 'rh']);
        Role::create(['name'=> 'Admin appareils', 'slug' => 'adminapp']);
        Role::create(['name'=> 'Admin Contrôle Accès', 'slug' => 'admincontracces']);
        
    }
}
