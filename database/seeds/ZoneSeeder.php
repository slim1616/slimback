<?php

use Illuminate\Database\Seeder;
use App\Zone;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Zone::create(['title'=> 'etage 1', 'batiment_id' => 1]);
        Zone::create(['title'=> 'etage 2', 'batiment_id' => 1]);
        Zone::create(['title'=> 'Dépot 1', 'batiment_id' => 1]);
        Zone::create(['title'=> 'Dépot 2', 'batiment_id' => 1]);
        Zone::create(['title'=> 'Usine', 'batiment_id' => 1]);
        
    }
}
