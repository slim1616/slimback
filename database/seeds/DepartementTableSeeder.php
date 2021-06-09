<?php

use Illuminate\Database\Seeder;
use App\Departement;

class DepartementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departement::create(['title'=> 'Administratif']);
        Departement::create(['title'=> 'Commercial']);
        Departement::create(['title'=> 'Ouvrier']);
        Departement::create(['title'=> 'Lycée']);
        Departement::create(['title'=> 'Collège']);
        Departement::create(['title'=> 'Ouvriere']);
        Departement::create(['title'=> 'Cantine']);
        Departement::create(['title'=> 'Elementaire']);
        Departement::create(['title'=> 'Cuisine']);
        Departement::create(['title'=> 'autres']);
    }
}
