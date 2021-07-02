<?php

use Illuminate\Database\Seeder;
use App\Formule;
class FormuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Formule::create(['title'=> 'Basic', 'online' => 1, 'nbsurvey' => 1, 'nbmois' => 0, 'nbsemplacements' => 1, 'price' => 0.000]);
        Formule::create(['title'=> 'Silver', 'online' => 1, 'nbsurvey' => 5, 'nbmois' => 1, 'nbsemplacements' => 1, 'price' => 10.000]);
        Formule::create(['title'=> 'Gold', 'online' => 1, 'nbsurvey' => 10, 'nbmois' => 1, 'nbsemplacements' => 5, 'price' => 16.000]);
        Formule::create(['title'=> 'Promo', 'online' => 0, 'nbsurvey' => 1, 'nbmois' => 1, 'nbsemplacements' => 1, 'price' => 7.000]);
        
    }
}
