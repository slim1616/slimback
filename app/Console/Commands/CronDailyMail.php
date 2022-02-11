<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendDailyMailJob;
use Illuminate\Database\Eloquent\Builder;
use App\Mail\PdfJournee;
use App\User;
use App\Abonnement;
use Carbon\Carbon;

class CronDailyMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily send report mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is Start...");
        $abonnements = Abonnement::where('start_at','<=', Carbon::now())
                                ->where('end_at','>=', Carbon::now())
                                ->whereHas('Formule', function(Builder $query){
                                    $query->whereIn('type', array('borne','multiple'));
                                })->get();
        if ($abonnements){
            foreach ($abonnements as $key => $abonnement) {
                dispatch(new SendDailyMailJob($abonnement));
            }
        } 
        \Log::info("Cron is working.");
        return 0;
    }
}
