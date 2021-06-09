<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('settings')) {
            $setting = DB::table('settings')->first();
            if ($setting) //checking if table is not empty
            {
                $config = array(
                    'driver'     => $setting->mail_driver,
                    'host'       => $setting->mail_host,
                    'port'       => $setting->mail_port,
                    'from'       => array('address' => $setting->from_address, 'name' => $setting->from_name),
                    'encryption' => $setting->mail_encrypt,
                    'username'   => $setting->mail_username,
                    'password'   => $setting->mail_password,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
        }
    }
}