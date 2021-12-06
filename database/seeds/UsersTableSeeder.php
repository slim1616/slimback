<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'slim1616',
            'email' => 'slim.bz@hotmail.fr',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'Slim',
            'nom' => 'BOUAZIZ',
            'role_id' => 1,
            'company_id' => 1,
            'password' => bcrypt('000000'),
        

        ]);
        // $media = $user->addMediaFromUrl(asset('img/avatar.jpg'))->toMediaCollection('avatar');
        // $user->avatar_id = $media->id;
        $user->save();
        $user1 = User::create([
            'name' => 'slimk',
            'email' => 's.kallel@hotmail.fr',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'Slim',
            'nom' => 'Kallel',
            'role_id' => 2,
            'company_id' => 2,
            'password' => bcrypt('000000'),
        

        ]);
        // $user1->avatar_id = $media->id;
        $user1->save();
        $user2 = User::create([
            'name' => 'med',
            'email' => 'yangui@gmail.com',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'med',
            'nom' => 'yangui',
            'role_id' => 2,
            'company_id' => 3,
            'password' => bcrypt('000000'),
        

        ]);

        // $user2->avatar_id = $media->id;
        $user2->save();
        $user3 = User::create([
            'name' => 'hafed',
            'email' => 'hafed@gmail.com',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'hafed',
            'nom' => 'amara',
            'role_id' => 3,
            'company_id' => 3,
            'password' => bcrypt('000000'),
        

        ]);

        // $user3->avatar_id = $media->id;
        $user3->save();
        $user4 = User::create([
            'name' => 'mouna',
            'email' => 'mouna@gmail.com',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'mouna',
            'nom' => 'hamadi',
            'role_id' => 2,
            'company_id' => 4,
            'password' => bcrypt('000000'),
        

        ]);

        // $user4->avatar_id = $media->id;
        $user4->save();

    }
}
