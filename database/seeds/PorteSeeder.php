<?php

use Illuminate\Database\Seeder;
use App\Porte;

class PorteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Porte::create(['titre'=> 'Accueil principale Pointage', 
                        'marque' => 'ZK',
                        'model' => 'K80',
                        'password' => '',
                        'sdk' => 'standalone',
                        'ip' => '192.168.2.84',
                        'port' => 4370,
                        'type' => 'inout',
                        'rtlogshow' => 0,
                        'nature' => 'pointage',
                        'zone_id' => 1,
                        'batiment_id' => 1
                        ]);
        Porte::create(['titre'=> 'Amphi', 
                        'marque' => 'ZK',
                        'model' => 'F16',
                        'password' => '',
                        'sdk' => 'pull',
                        'ip' => '192.168.2.86',
                        'port' => 4370,
                        'type' => 'in',
                        'nature' => 'access',
                        'rtlogshow' => 0,
                        'zone_id' => 1,
                        'batiment_id' => 1
                        ]);
        Porte::create(['titre'=> 'Porte Service entrée', 
                        'marque' => 'ZK',
                        'model' => 'F16',
                        'password' => '',
                        'sdk' => 'pull',
                        'ip' => '192.168.2.87',
                        'port' => 4370,
                        'type' => 'in',
                        'nature' => 'access',
                        'rtlogshow' => 0,
                        'zone_id' => 1,
                        'batiment_id' => 1
                        ]);
        Porte::create(['titre'=> 'Porte Service sortie', 
                        'marque' => 'ZK',
                        'model' => 'F16',
                        'password' => '',
                        'sdk' => 'pull',
                        'ip' => '192.168.2.88',
                        'port' => 4370,
                        'type' => 'out',
                        'nature' => 'access',
                        'rtlogshow' => 0,
                        'zone_id' => 1,
                        'batiment_id' => 1
                        ]);
        Porte::create(['titre'=> 'Porte Service Pointage', 
                        'marque' => 'ZK',
                        'model' => 'K80',
                        'password' => '',
                        'sdk' => 'standalone',
                        'ip' => '192.168.2.89',
                        'port' => 4370,
                        'type' => 'inout',
                        'nature' => 'pointage',
                        'rtlogshow' => 0,
                        'zone_id' => 1,
                        'batiment_id' => 1
                        ]);
        Porte::create(['titre'=> 'Porte inconnue', 
                        'marque' => 'ZK',
                        'model' => 'F16',
                        'password' => '',
                        'sdk' => 'pull',
                        'ip' => '192.168.2.91',
                        'port' => 4370,
                        'type' => 'in',
                        'nature' => 'access',
                        'rtlogshow' => 0,
                        'zone_id' => 1,
                        'batiment_id' => 1
                        ]);
    }
}
