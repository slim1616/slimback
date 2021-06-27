<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(['title'=> 'Smelsy', 'type' => 'SUARL', 'user_id' => 1]);
        Company::create(['title'=> 'Trust Link', 'type' => 'SARL', 'user_id' => 1]);
        Company::create(['title'=> 'Print Secure', 'type' => 'SARL', 'user_id' => 1]);
        Company::create(['title'=> 'Condair', 'type' => 'SARL', 'user_id' => 1]);
    }
}
