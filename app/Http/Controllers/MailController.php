<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Jobs\SendDailyMailJob;
use App\Mail\PdfJournee;
use App\User;
use App\Abonnement;
use Carbon\Carbon;

class MailController extends Controller
{
    public function myDemoMail()
    {
        $myEmail = 'slim.bz@hhotmail.fr';
        $user = User::find(1);
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
    	// Mail::to('slim.bz@hotmail.fr')->send(new PdfJournee());

    	
    	dd("Mail Send Successfully");
    }
}
