<?php

namespace App\Jobs;

use App\Mail\SendEmailWelcome;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Maillog;
use App\Bornesreponse;
use App\Borne;
// use Mail;
use Carbon\Carbon;
use PDF;

class SendDailyMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $abonnement;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($abonnement)
    {
        $this->abonnement = $abonnement;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info("Sending mail...");
        try{
            $company = $this->abonnement->Company;
            $emails = $company->Users->pluck('email')->toArray();
            $compagne = $company->Compagnes->where('start_at','<=', Carbon::now())
                                            ->where('end_at', '>=', Carbon::now())
                                            ->first();
            $bornesIds = $compagne->SelectedBornes->pluck('borne_id');
            $type = 'day';
            $start = Carbon::now()->format('Y-m-d').' 00:00:00';
            $end = Carbon::now()->format('Y-m-d').' 23:59:59';
            $donnes = Bornesreponse::where('company_id', $company->id)
                                            ->where('datetime','>=', $start)
                                            ->where('datetime', '<=', $end)
                                            ->whereIn('borne_id', $bornesIds)
                                            // ->groupBy('resp')
                                            ->get();
            
            $data = [];
            $filtred = $donnes->filter(function($item, $key)use ($compagne, $start){
                $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
                if (count(json_decode($compagne->emploie)[$dayweek])>0){
                    $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
                    $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
                    if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
                        return $item->datetime;
                    }
                }
            });
            $data = $filtred;
            $grouped = $data->groupBy('resp');
            $bornes = $data->groupBy('borne_id');
            $locations = array();
            foreach ($bornesIds as $br) {
            $borne = Borne::find($br);
            if (isset($bornes[$br])){
                $responses = $bornes[$br];
                $count = $responses->pluck('resp')->countBy();
            }else{
                $responses = collect([]);
                $count = [];
            }
            
            $stats = [];
            $details = [];
            $ind = 0;
            for ($i=1; $i <=4 ; $i++) { 
                if (isset($count[$i])){
                if ($i==1){ $ind+= $count[$i];}
                if ($i==2){ $ind+= $count[$i]*0.5;}
                if ($i==3){ $ind+= $count[$i]*-0.5;}
                if ($i==4){ $ind+= -$count[$i];}
                $stats[$i] = intval($count[$i]/$bornes[$br]->count()*100);
                }else{
                $stats[$i] = 0;
                }
            }
            if ($responses->count()>0){
                $indice = ((($ind/$responses->count())/2)*100)+50;
            }else{
                $indice = 0;
            }
            $locations[] = array('borne' => $borne,
                                'details' => $stats,
                                'indice' => round($indice,2),
                                'total' => $responses->count());
            }
    
            $locale = app()->getLocale();
            $hours = $data->groupBy(function ($item, $key) {
                return Carbon::parse($item['datetime'])->hour;
            });
            $hours = $hours->sortKeys();
            $horaires = array();
            if ($hours){
                $statresps = [];
                foreach ($hours as $key => $hour) {
                    $resps =  $hour->pluck('resp')->countBy();
                    // dd($resps);
                    $ind = 0;
                    for ($i=1; $i <=4 ; $i++) { 
                    if (isset($resps[$i])){
                        if ($i==1){ $ind+= $resps[$i];}
                        if ($i==2){ $ind+= $resps[$i]*0.5;}
                        if ($i==3){ $ind+= $resps[$i]*-0.5;}
                        if ($i==4){ $ind+= -$resps[$i];}
                        $statresps[$i] = $resps[$i];
                    }else{
                        $statresps[$i] = 0;
                    }
                    }
                    // $indice = $ind;
                    $indice = ((($ind/$hour->count())/2)*100)+50;
                    $statresps[5] = round($indice,2);
                    $horaires[Carbon::createFromFormat('H', $key)->format('H:i')] =  $statresps;
                }
            }
            $pdf = PDF::setOption('enable-local-file-access', true)
            ->loadView('pdf.day', compact('grouped','compagne','company','data','locations','horaires','start', 'end', 'type'))
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('images', true)
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm');
            $pdf->setOption('zoom', 0.75);
            $pdf->setOption('enable-javascript', true);
            $pdf->setOption('javascript-delay', 3000);
            $pdf->setOption('disable-smart-shrinking', true);
            $pdf->setOption('no-stop-slow-scripts', true);
            $pdf->setOption('window-status', 'ready');

            
            $donne["email"] = "slim.bz@hotmail.fr";
            $donne["title"] = "From satys.com";
            $donne["body"] = "Rapport quotidien";
            Mail::send('emails.journee', $donne, function($message) use ($donne, $pdf, $emails) {
                $message->to($donne["email"], $donne["email"])
                        ->subject($donne["title"])
                        ->bcc($emails)
                        ->attachData($pdf->output(), "rapport.pdf");
                    });
            Maillog::create(['mail' => 'rapport quotidient',
                            'sent' => true,
                            'company_id' => $company->id]);
            \Log::info("Mail Sent...");
            }catch(Exeption $e){
                Maillog::create(['mail' => 'rapport quotidient',
                            'sent' => false,
                            'company_id' => $company->id]);
                \Log::info("Mail Not Sent...");
        }
        

    }
}