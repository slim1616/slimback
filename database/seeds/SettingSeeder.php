<?php

use Illuminate\Database\Seeder;
use App\Setting;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'societe' => 'ISC',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => '465',
            'mail_username' => 'bouazizmedslim@gmail.com',
            'mail_password' => 'samsungsgh250',
            'mail_encrypt' => 'ssl',
            'from_address' => 'contact@trustlink.com',
            'from_name' => 'trustlink',

        ]);
    }
}
