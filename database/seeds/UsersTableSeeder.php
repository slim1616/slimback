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
            'password' => bcrypt('000000'),

        ]);
        $media = $user->addMediaFromUrl(asset('img/avatar.jpg'))->toMediaCollection('avatar');
        $user->avatar_id = $media->id;
        $user->save();
        $user1 = User::create([
            'name' => 'selima',
            'email' => 'selim.bz@hotmail.fr',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'Slima',
            'nom' => 'BOUAZIZ',
            'role_id' => 2,
            'password' => bcrypt('000000'),

        ]);
        $user1->avatar_id = $media->id;
        $user1->save();
        $user2 = User::create([
            'name' => 'minou',
            'email' => 'minou.bz@gmail.com',
            // 'title' => 'Prof et formateur web fullStack',
            'prenom' => 'Minou',
            'nom' => 'BOUAZIZ',
            'role_id' => 3,
            'password' => bcrypt('000000'),

        ]);

        $user2->avatar_id = $media->id;
        $user2->save();
    }
}
