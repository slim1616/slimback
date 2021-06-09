<?php

use Illuminate\Database\Seeder;
use App\Batiment;

class BatimentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Batiment::create(['title'=> 'Siège']);
        
    }
}
