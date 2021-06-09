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
    }
}
