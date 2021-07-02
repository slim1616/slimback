<?php

use Illuminate\Database\Seeder;
use App\Abonnement;

class AbonnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Abonnement::create(['formule_id'=> 1, 'company_id' => 1, 'user_id' => 1]);
        Abonnement::create(['formule_id'=> 2, 'company_id' => 2, 'user_id' => 2]);
        Abonnement::create(['formule_id'=> 3, 'company_id' => 3, 'user_id' => 3]);
        Abonnement::create(['formule_id'=> 1, 'company_id' => 4, 'user_id' => 5]);
    }
}
