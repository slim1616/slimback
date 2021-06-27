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
        Formule::create(['title'=> 'Basic', 'online' => 1, 'price' => 0.000]);
        Formule::create(['title'=> 'Silver', 'online' => 1, 'price' => 10.000]);
        Formule::create(['title'=> 'Gold', 'online' => 1, 'price' => 16.000]);
        Formule::create(['title'=> 'Promo', 'online' => 0, 'price' => 7.000]);
        
    }
}
