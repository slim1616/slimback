<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\Emplacement;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company1 = Company::create(['title'=> 'Smelsy', 'type' => 'SUARL', 'user_id' => 1]);
        $emplacement = Emplacement::create(['title' => 'Siège '.$company1->title , 'company_id' => $company1->id, 'user_id' => 1]);
        $company2 = Company::create(['title'=> 'Trust Link', 'type' => 'SARL', 'user_id' => 2]);
        $emplacement = Emplacement::create(['title' => 'Siège '.$company2->title , 'company_id' => $company2->id, 'user_id' => 2]);
        $company3 = Company::create(['title'=> 'Condair', 'type' => 'SARL', 'user_id' => 3]);
        $emplacement = Emplacement::create(['title' => 'Siège '.$company3->title, 'company_id' => $company3->id, 'user_id' => 3]);
        $company4 = Company::create(['title'=> 'Clinique Ennasr', 'type' => 'SARL', 'user_id' => 5]);
        $emplacement = Emplacement::create(['title' => 'Siège '.$company4->title, 'company_id' => $company4->id, 'user_id' => 5]);
    }
}
