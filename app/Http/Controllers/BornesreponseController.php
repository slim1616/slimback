<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Bornesreponse;
use App\Compagne;
use App\Http\Resources\BornesreponseResource;
use App\Borne;
use PDF;
use Carbon\Carbon;

class BornesreponseController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['bornesreponse'] = new BornesreponseResource(Bornesreponse::findOrFail($id));
                
                        
        
        $response['companies'] = \App\Company::all();
                        
        
        $response['bornes'] = \App\Borne::all();
                        
                        
                        
                        
                
        return response($response);
    }

     public function data(Request $request){
        $response = [];
        $response['companies'] = \App\Company::all();
        $response['bornes'] = \App\Borne::all();
        return response($response);
    }
    
    public function list(Request $request){
      return response(BornesreponseResource::collection(Bornesreponse::get()));
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'borne_id' => 'required |max:20 ',
        'resp' => 'required |max:10 ',
      ],[
        'borne_id.required' => 'borne_id est obligatoire.',
        'borne_id.max' => 'borne_id doit avoir aux max 20 characters.',
        'resp.required' => 'resp est obligatoire.',
        'resp.max' => 'resp doit avoir aux max 10 characters.',
      ]);

        $bornesreponses = Bornesreponse::create($request->all());    
        return $bornesreponses;
    }

    public function filter(Request $request){
        $response = [];
        $compagne = Compagne::findOrFail($request->compagne_id);
        $company = $compagne->Company;
        $bornesIds = $compagne->SelectedBornes->pluck('borne_id');
        setlocale(LC_TIME, "fr_FR");
        $start = "";
        $end = "";
        $type = $request->type; 
        if ($request->type=='day'){
          $start = $request->date.' 00:00:00';
          $end = $request->date.' 23:59:59';
        }
        if ($request->type=='week'){
          $endDate = new Carbon($request->date);
          // dd($endDate->addDays(7)->format("Y-m-d"));
          $start = $request->date.' 00:00:00';
          $end = $endDate->addDays(7)->format("Y-m-d").' 23:59:59';
        }


        $donnes = Bornesreponse::where('company_id', $request->company_id)
                                                ->where('datetime','>=', $start)
                                                ->where('datetime', '<=', $end)
                                                ->whereIn('borne_id', $bornesIds)
                                                // ->groupBy('resp')
                                                ->get();
        $data = [];
        // if ($type=='day'){
          //0 => dimanche
          //1 => Lundi
          // dd(Carbon::parse($start)->dayOfWeek);
          // dd(json_decode($compagne->emploie)[$dayweek][0]);
          $filtred = $donnes->filter(function($item, $key)use ($compagne, $start){
            // dd(Carbon::parse($item->datetime)->dayOfWeek);
            $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
            if (count(json_decode($compagne->emploie)[$dayweek])>0){
              $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
              $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
              if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
      
                return $item->datetime;
              }
            }
          });
      // }
        $data = $filtred;
        $grouped = $data->groupBy('resp');
        $bornes = $data->groupBy('borne_id');
        // dd($request->all());
        // dd($data);
       
        // dd($bornes['1']->pluck('resp')->countBy());
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
        Carbon::setlocale($locale);
        $jours = [];
        $alljours = [];
        if ($type=='week'){
          $days = $data->groupBy(function ($item, $key) {
            return Carbon::parse($item['datetime'])->dayOfWeek;
          });
          $days = $days->sortKeys();
          $jours = array();
          if ($days){
            $statresps = [];
            foreach ($days as $key => $jour) {
              $resps =  $jour->pluck('resp')->countBy();
              $ind = 0;
              for ($i=1; $i <=4 ; $i++) { 
                if (isset($resps[$i])){
                  if ($i==1){ $ind+= $resps[$i];}
                  if ($i==2){ $ind+= $resps[$i]*0.5;}
                  if ($i==3){ $ind+= $resps[$i]*-0.5;}
                  if ($i==4){ $ind+= -$resps[$i];}
                  $statresps[$i] = round($resps[$i]/$jour->count()*100,2);
                }else{
                  $statresps[$i] = 0;
                }
              }
              // $indice = $ind;
              $indice = ((($ind/$jour->count())/2)*100)+50;
              $statresps[5] = round($indice,2);
              // dd($key);
              $jours[$key] =  $statresps;
            }
            $weekdays = Carbon::getDays();
            
            for ($i=0; $i < 7 ; $i++) { 
              if (isset($jours[$i])){
                $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = $jours[$i];
              }else{
                $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = array('1' => 0, '2' => 0, '3' =>  0, '4' => 0 , '5' => 50);
              }
            }
            $tmp = $alljours['dimanche'];
          }
          $j = array_shift($alljours);
          $alljours['dimanche'] = $tmp;
          $jours = $alljours;
        }
         // semaines precedentes
        $wks = array();
        if ($type=='week'){
          $lastweeks = Bornesreponse::where('company_id', 4)
                                ->where('datetime','>=', Carbon::now()->subMonths(2))
                                ->where('datetime', '<=', $end.' 23:59:59')
                                ->whereIn('borne_id', $bornesIds)
                                // ->groupBy('resp')
                                ->get();

          $filtred = $lastweeks->filter(function($item, $key)use ($compagne, $start){
              $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
              if (count(json_decode($compagne->emploie)[$dayweek])>0){
                  $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
                  $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
                  if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
          
                    return $item->datetime;
                  }
              }
            });
            $weeks = $filtred->groupBy(function ($item, $key) {
              return Carbon::parse($item['datetime'])->weekOfYear;
            });
            
            if ($weeks){
              $statresps = [];
              foreach ($weeks as $key => $week) {
                $resps =  $week->pluck('resp')->countBy();

                $ind = 0;
                for ($i=1; $i <=4 ; $i++) { 
                  if (isset($resps[$i])){
                    if ($i==1){ $ind+= $resps[$i];}
                    if ($i==2){ $ind+= $resps[$i]*0.5;}
                    if ($i==3){ $ind+= $resps[$i]*-0.5;}
                    if ($i==4){ $ind+= -$resps[$i];}
                    $statresps[$i] = round($resps[$i]/$week->count()*100);
                  }else{
                    $statresps[$i] = 0;
                  }
                }
                // $indice = $ind;
                $indice = ((($ind/$week->count())/2)*100)+50;
                $statresps[5] = round($indice,2);
                // dd(Carbon::parse($week->first()->datetime)->format('Y'));
                $year = Carbon::parse($week->first()->datetime)->format('Y');
                $date = Carbon::now();
                $date->setISODate($year,$key);
                // dd($date->startOfWeek()->format('Y-m-d'));
                // echo $date->endOfWeek();
                $wks[Carbon::createFromFormat('Y-m-d', $date->startOfWeek()->format('Y-m-d'))->translatedFormat('d/m')] =  $statresps;
              }
            }
            $wks = array_reverse($wks);
        }
        // diffusion horaire
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
        // return response($wks);
        // $pdf = PDF::loadHTML("<p>Mon contenu HTML ici</p>");
        $pdf = PDF::setOption('enable-local-file-access', true)
                  ->loadView('pdf.day', compact('grouped','compagne','company','data','locations','horaires','start', 'end', 'type','jours','wks'));
        // $pdf = PDF::loadView('pdf.day', compact('grouped','compagne','company','data'));
        $pdf->setPaper('a4')
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

        
        return $pdf->stream();
        
        
    }


    public function chart(Request $request){
      $response = [];
      $compagne = Compagne::findOrFail(1);
      $company = $compagne->Company;
      $bornesIds = $compagne->SelectedBornes->pluck('borne_id');
      setlocale(LC_TIME, "fr_FR");
      $type = "week";
      $start = $compagne->start_at;
      $end = $compagne->end_at;
      $date = "2021-12-04";

      $donnes = Bornesreponse::where('company_id', 4)
                              ->where('datetime','>=', $compagne->start_at.' 00:00:00')
                              ->where('datetime', '<=', $compagne->end_at.' 23:59:59')
                              ->whereIn('borne_id', $bornesIds)
                              // ->groupBy('resp')
                              ->get();
      // if ($type=='day'){
          //0 => dimanche
          //1 => Lundi
          // dd(Carbon::parse($start)->dayOfWeek);
          // dd(json_decode($compagne->emploie)[$dayweek][0]);
          $filtred = $donnes->filter(function($item, $key)use ($compagne, $start){
            // dd(Carbon::parse($item->datetime)->dayOfWeek);
            $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
            if (count(json_decode($compagne->emploie)[$dayweek])>0){
                $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
                $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
                if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
        
                  return $item->datetime;
                }
            }
          });
      // }
      $data = $filtred;

      $grouped = $filtred->groupBy('resp');
      $bornes = $filtred->groupBy('borne_id');
      // dd($grouped);
     
      // dd($bornes['1']->pluck('resp')->countBy());
      $locations = array();
      foreach ($bornesIds as $br) {
        // dd($bornes[$br]);
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
      // dd($filtred);
      $locale = app()->getLocale();
      Carbon::setlocale($locale);
      $jours = [];
      if ($type=='week'){
        $days = $data->groupBy(function ($item, $key) {
          return Carbon::parse($item['datetime'])->dayOfWeek;
        });
        $days = $days->sortKeys();
        $jours = array();
        if ($days){
          $statresps = [];
          foreach ($days as $key => $jour) {
            $resps =  $jour->pluck('resp')->countBy();

            $ind = 0;
            for ($i=1; $i <=4 ; $i++) { 
              if (isset($resps[$i])){
                if ($i==1){ $ind+= $resps[$i];}
                if ($i==2){ $ind+= $resps[$i]*0.5;}
                if ($i==3){ $ind+= $resps[$i]*-0.5;}
                if ($i==4){ $ind+= -$resps[$i];}
                $statresps[$i] = round($resps[$i]/$jour->count()*100);
              }else{
                $statresps[$i] = 0;
              }
            }
            // $indice = $ind;
            $indice = ((($ind/$jour->count())/2)*100)+50;
            $statresps[5] = round($indice,2);
            $jours[$key] =  $statresps;
          }

            $weekdays = Carbon::getDays();
            $alljours = [];
            for ($i=0; $i < 7 ; $i++) { 
              if (isset($jours[$i])){
                $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = $jours[$i];
              }else{
                $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = array('1' => 0, '2' => 0, '3' =>  0, '4' => 0 , '5' => 50);
              }
            }
            $tmp = $alljours['dimanche'];
          }
        }
        $j = array_shift($alljours);
        $alljours['dimanche'] = $tmp;
        $jours = $alljours;
        // dd($alljours);
      // semaines precedentes
      $wks = array();
      if ($type=='week'){
        $lastweeks = Bornesreponse::where('company_id', 4)
                              ->where('datetime','>=', Carbon::now()->subMonths(2))
                              // ->where('datetime', '<=', $compagne->end_at.' 23:59:59')
                              ->whereIn('borne_id', $bornesIds)
                              // ->groupBy('resp')
                              ->get();

        $filtred = $lastweeks->filter(function($item, $key)use ($compagne, $start){
            $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
            if (count(json_decode($compagne->emploie)[$dayweek])>0){
                $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
                $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
                if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
        
                  return $item->datetime;
                }
              }
          });
          $weeks = $filtred->groupBy(function ($item, $key) {
            return Carbon::parse($item['datetime'])->weekOfYear;
          });
          
          if ($weeks){
            $statresps = [];
            foreach ($weeks as $key => $week) {
              $resps =  $week->pluck('resp')->countBy();

              $ind = 0;
              for ($i=1; $i <=4 ; $i++) { 
                if (isset($resps[$i])){
                  if ($i==1){ $ind+= $resps[$i];}
                  if ($i==2){ $ind+= $resps[$i]*0.5;}
                  if ($i==3){ $ind+= $resps[$i]*-0.5;}
                  if ($i==4){ $ind+= -$resps[$i];}
                  $statresps[$i] = round($resps[$i]/$week->count()*100);
                }else{
                  $statresps[$i] = 0;
                }
              }
              // $indice = $ind;
              $indice = ((($ind/$week->count())/2)*100)+50;
              $statresps[5] = round($indice,2);
              // dd(Carbon::parse($week->first()->datetime)->format('Y'));
              $year = Carbon::parse($week->first()->datetime)->format('Y');
              $date = Carbon::now();
              $date->setISODate($year,$key);
              // dd($date->startOfWeek()->format('Y-m-d'));
              // echo $date->endOfWeek();
              $wks[Carbon::createFromFormat('Y-m-d', $date->startOfWeek()->format('Y-m-d'))->translatedFormat('d/m')] =  $statresps;
            }
          }
          $wks = array_reverse($wks);
      }

      $hours = $filtred->groupBy(function ($item, $key) {
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
      // $pdf = PDF::loadHTML("<p>Mon contenu HTML ici</p>");
      return view('pdf.day', compact('grouped','compagne','company','data','locations','horaires','start', 'end', 'type','jours','wks'));
      $pdf = PDF::setOption('enable-local-file-access', true)
                ->loadView('pdf.day', compact('grouped','compagne','company','data','locations'));
      // $pdf = PDF::loadView('pdf.day', compact('grouped','compagne','company','data'));
      $pdf->setPaper('a4')
      ->setOrientation('portrait')
      ->setOption('images', true);
      $pdf->setOption('enable-javascript', true);
      $pdf->setOption('javascript-delay', 5000);
      $pdf->setOption('disable-smart-shrinking', true);

      $pdf->setOption('no-stop-slow-scripts', true);
      $pdf->setOption('window-status', 'ready');

      
      return $pdf->stream();
      // return response($locations);
  }
    
    public function MassAdd(Request $request){
      

        $data = [];
        $borne = Borne::find($request->data[0]['borne_id']);
        if ($request->ip){
          $borne = $request->ip;
        }
        if ($request->gps){
          $borne = $request->ip;
        }
        if ($borne){
          foreach ($request->data as $reponse) {
            $date = explode("/", $reponse['date']);
            $d = $date[0];
            $m = $date[1];
            $y = $date[2];
            $time = explode(":", $reponse['time']);
            $h = $time[0];
            $mm = $time[1];
            $ss = $time[2];
            $date = $y .'-'.$m.'-'.$d.' '.$h.':'.$mm.':'.$ss;

            $reponse['datetime'] = $date;
            unset($reponse['date']);
            unset($reponse['time']);
            // dd($reponse['datetime']);
            $reponse['company_id'] = $borne->Company->id;
            // if ($reponse['Latitude']){
            //   unset($reponse['Latitude']);
            // }
            // if ($reponse['Longitude']){
            //   unset($reponse['Longitude']);
            // }
            $borne->battery = $reponse['Battery'];
            $borne->save();
            if ($reponse['Battery']){
              unset($reponse['Battery']);
            }
            $data[] = $reponse;
          }
        }
        $bornesreponses = Bornesreponse::insert($data);    
        if ($bornesreponses){
          // return response(['status' => true, 'data' => $data]);
          return true;
        }else{
          return response(['status' => false]);
        }
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'company_id' => 'required |max:20 ',
        'borne_id' => 'required |max:20 ',
        'resp' => 'required |max:10 ',
      ],[
        'company_id.required' => 'company_id est obligatoire.',
        'company_id.max' => 'company_id doit avoir aux max 20 characters.',
        'borne_id.required' => 'borne_id est obligatoire.',
        'borne_id.max' => 'borne_id doit avoir aux max 20 characters.',
        'resp.required' => 'resp est obligatoire.',
        'resp.max' => 'resp doit avoir aux max 10 characters.',
      ]);

        $bornesreponses = Bornesreponse::findOrFail($id);
        $input = $request->all();
        $bornesreponses->fill($input)->save();
        return $bornesreponses;
    }
    
    public function delete(Request $request, $id){
        $bornesreponses = Bornesreponse::findOrFail($id);
        $bornesreponses->delete();
    }

    public function getDataMonth(Request $request){
        $response = [];
        $date = new Carbon($request->date);
        // dd($date->addDays(7)->format("Y-m-d"));
        $start = $date->startOfMonth()->format("Y-m-d").' 00:00:00';
        $end = $date->endOfMonth()->format("Y-m-d").' 23:59:59';
        $compagne = Compagne::findOrFail($request->compagne_id);
        // $compagne = Compagne::findOrFail(1);
        $company = $compagne->Company;
        $bornesIds = $compagne->SelectedBornes->pluck('borne_id');
        // $date = new Carbon("2021-12-04");
        // dd($date->addDays(7)->format("Y-m-d"));
        // $start = $date->startOfMonth()->format("Y-m-d").' 00:00:00';
        // $end = $date->endOfMonth()->format("Y-m-d").' 23:59:59';
        // $donnes = Bornesreponse::where('company_id', 4)
        $donnes = Bornesreponse::where('company_id', $request->company_id)
                                                ->where('datetime','>=', $start)
                                                ->where('datetime', '<=', $end)
                                                ->whereIn('borne_id', $bornesIds)
                                                // ->groupBy('resp')
                                                ->get();
        $company = $compagne->Company;
        $bornesIds = $compagne->SelectedBornes->pluck('borne_id');
        setlocale(LC_TIME, "fr_FR");
        
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
        // repartition horaire
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
        // jours du semaine
        $jours = [];
        $days = $data->groupBy(function ($item, $key) {
          return Carbon::parse($item['datetime'])->dayOfWeek;
        });
        $days = $days->sortKeys();
        $jours = array();
        if ($days){
          $statresps = [];
          foreach ($days as $key => $jour) {
            $resps =  $jour->pluck('resp')->countBy();
            $ind = 0;
            for ($i=1; $i <=4 ; $i++) { 
              if (isset($resps[$i])){
                if ($i==1){ $ind+= $resps[$i];}
                if ($i==2){ $ind+= $resps[$i]*0.5;}
                if ($i==3){ $ind+= $resps[$i]*-0.5;}
                if ($i==4){ $ind+= -$resps[$i];}
                $statresps[$i] = round($resps[$i]/$jour->count()*100,2);
              }else{
                $statresps[$i] = 0;
              }
            }
            // $indice = $ind;
            $indice = ((($ind/$jour->count())/2)*100)+50;
            $statresps[5] = round($indice,2);
            // dd($key);
            $jours[$key] =  $statresps;
          }
          $weekdays = Carbon::getDays();
          $alljours = [];
          for ($i=0; $i < 7 ; $i++) { 
            if (isset($jours[$i])){
              $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = $jours[$i];
            }else{
              $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = array('1' => 0, '2' => 0, '3' =>  0, '4' => 0 , '5' => 50);
            }
          }
          $tmp = $alljours['dimanche'];
        }
        // dd($alljours);
        $j = array_shift($alljours);
        $alljours['dimanche'] = $tmp;
        $jours = $alljours;
        
        $tousjours = [];
        $days = $data->groupBy(function ($item, $key) {
          return Carbon::parse($item['datetime'])->format('d/m');
        });
        $tousjours = array();
        if ($days){
          $statresps = [];
          foreach ($days as $key => $jour) {
            $resps =  $jour->pluck('resp')->countBy();
            $ind = 0;
            for ($i=1; $i <=4 ; $i++) { 
              if (isset($resps[$i])){
                if ($i==1){ $ind+= $resps[$i];}
                if ($i==2){ $ind+= $resps[$i]*0.5;}
                if ($i==3){ $ind+= $resps[$i]*-0.5;}
                if ($i==4){ $ind+= -$resps[$i];}
                $statresps[$i] = round($resps[$i]/$jour->count()*100,2);
              }else{
                $statresps[$i] = 0;
              }
            }
            // $indice = $ind;
            $indice = ((($ind/$jour->count())/2)*100)+50;
            $statresps[5] = round($indice,2);
            $tousjours[Carbon::createFromFormat('d/m', $key)->translatedFormat('d/m')] =  $statresps;
          }
        }
        // $tousjours = array_reverse($tousjours);
        
        // mois precedents
        $mois = array();
        $lastmonth = Bornesreponse::where('company_id', 4)
                              ->where('datetime','>=', Carbon::now()->subMonths(12))
                              ->where('datetime', '<=', $end.' 23:59:59')
                              ->whereIn('borne_id', $bornesIds)
                              // ->groupBy('resp')
                              ->get();

        $filtred = $lastmonth->filter(function($item, $key)use ($compagne, $start){
            $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
            if (count(json_decode($compagne->emploie)[$dayweek])>0){
              $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
              $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
              if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
      
                return $item->datetime;
              }
            }
          });
          $months = $filtred->groupBy(function ($item, $key) {
            return Carbon::parse($item['datetime'])->format('F');
          });
          
          if ($months){
            $statresps = [];
            foreach ($months as $key => $month) {
              $resps =  $month->pluck('resp')->countBy();

              $ind = 0;
              for ($i=1; $i <=4 ; $i++) { 
                if (isset($resps[$i])){
                  if ($i==1){ $ind+= $resps[$i];}
                  if ($i==2){ $ind+= $resps[$i]*0.5;}
                  if ($i==3){ $ind+= $resps[$i]*-0.5;}
                  if ($i==4){ $ind+= -$resps[$i];}
                  $statresps[$i] = round($resps[$i]/$month->count()*100);
                }else{
                  $statresps[$i] = 0;
                }
              }
              // $indice = $ind;
              $indice = ((($ind/$month->count())/2)*100)+50;
              $statresps[5] = round($indice,2);
              // dd(Carbon::parse($month->first()->datetime)->format('d-m-Y'));
              $date = Carbon::parse($month->first()->datetime)->format('Y-m-d');
              // $date = Carbon::now();
              // $date->setISODate($year,$key);
              // dd($date->startOfWeek()->format('Y-m-d'));
              // echo $date->endOfWeek();
              // dd($date);
              $mois[Carbon::createFromFormat('Y-m-d', $date)->translatedFormat('F')] =  $statresps;
            }
          }
          // $mois = array_reverse($mois);
        
        $mois = array();
        $lastmonth = Bornesreponse::where('company_id', 4)
                              ->where('datetime','>=', Carbon::now()->subMonths(12))
                              ->where('datetime', '<=', $end.' 23:59:59')
                              ->whereIn('borne_id', $bornesIds)
                              // ->groupBy('resp')
                              ->get();

        $filtred = $lastmonth->filter(function($item, $key)use ($compagne, $start){
            $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
            if (count(json_decode($compagne->emploie)[$dayweek])>0){
                $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
                $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
                if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
        
                  return $item->datetime;
                }
            }
          });
          $months = $filtred->groupBy(function ($item, $key) {
            return Carbon::parse($item['datetime'])->format('F');
          });
          
          if ($months){
            $statresps = [];
            foreach ($months as $key => $month) {
              $resps =  $month->pluck('resp')->countBy();

              $ind = 0;
              for ($i=1; $i <=4 ; $i++) { 
                if (isset($resps[$i])){
                  if ($i==1){ $ind+= $resps[$i];}
                  if ($i==2){ $ind+= $resps[$i]*0.5;}
                  if ($i==3){ $ind+= $resps[$i]*-0.5;}
                  if ($i==4){ $ind+= -$resps[$i];}
                  $statresps[$i] = round($resps[$i]/$month->count()*100);
                }else{
                  $statresps[$i] = 0;
                }
              }
              // $indice = $ind;
              $indice = ((($ind/$month->count())/2)*100)+50;
              $statresps[5] = round($indice,2);
              // dd(Carbon::parse($month->first()->datetime)->format('d-m-Y'));
              $date = Carbon::parse($month->first()->datetime)->format('Y-m-d');
              $mois[Carbon::createFromFormat('Y-m-d', $date)->translatedFormat('F')] =  $statresps;
            }

          }

        // declin / progression
        $monthss = array();
        $lastmonth = Bornesreponse::where('company_id', 4)
                              ->where('datetime','>=', Carbon::now()->subMonths(2))
                              ->where('datetime', '<=', $end.' 23:59:59')
                              ->whereIn('borne_id', $bornesIds)
                              // ->groupBy('resp')
                              ->get();

        $filtred = $lastmonth->filter(function($item, $key)use ($compagne, $start){
            $dayweek = Carbon::parse($item->datetime)->dayOfWeek;
            if (count(json_decode($compagne->emploie)[$dayweek])>0){
              $h1 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][0]));
              $h2 = strtotime(Carbon::parse(json_decode($compagne->emploie)[$dayweek][0][1]));
              if ( in_array(strtotime(Carbon::parse($item->datetime)->format('H:i')), range($h1,$h2))) {
      
                return $item->datetime;
              }
            }
          });
          $monthss = $filtred->groupBy(function ($item, $key) {
            return Carbon::parse($item['datetime'])->format('F');
          });
          
          if ($monthss){
            $ms = [];
            foreach ($monthss as $keky => $month) {
                $bornes = $month->groupBy('borne_id');
                $bs = [];
                foreach ($bornes as $key => $borne) {
                  $resps =  $borne->pluck('resp')->countBy();
                  $ind = 0;
                  $statresps = [];
                  for ($i=1; $i <=4 ; $i++) { 
                    if (isset($resps[$i])){
                      if ($i==1){ $ind+= $resps[$i];}
                      if ($i==2){ $ind+= $resps[$i]*0.5;}
                      if ($i==3){ $ind+= $resps[$i]*-0.5;}
                      if ($i==4){ $ind+= -$resps[$i];}
                      $statresps[$i] = round($resps[$i]/$month->count()*100);
                    }else{
                      $statresps[$i] = 0;
                    }
                  }
                  $indice = ((($ind/$month->count())/2)*100)+50;
                  $statresps[5] = round($indice,2);
                  $date = Carbon::parse($month->first()->datetime)->format('Y-m-d');
                  $bs[$key] = $statresps;
                }
                $ms[] = $bs;
            }
            // dd($ms);
            $declins = [];
            $progressions = [];
            if (count($ms)>1){
              foreach ($ms[1] as $borne_id => $m) {
                $borne = Borne::find($borne_id);
                if (isset($ms[0][$borne_id])){
                    if ($ms[0][$borne_id][5]>$ms[1][$borne_id][5]){
                      $declins[] = array('borne' => $borne->title, 
                                                        'perc' => 100-round($ms[1][$borne_id][5]/$ms[0][$borne_id][5]*100),
                                                        'indice' => $ms[1][$borne_id][5]);
                    }else{
                      $progressions[] = array('borne' => $borne->title, 
                                                'perc' => round($ms[1][$borne_id][5]/$ms[0][$borne_id][5]*100)-100, 
                                                'indice' => $ms[1][$borne_id][5]);
                    }
                }
                // foreach ($m as $borne_id => $values) {
                  //   dd($values);
                  // }
                }
              }
            }
            

        
        // return response($progressions);
        // return view('pdf.month', compact('grouped','compagne','company','data','locations','horaires','start','end','jours','tousjours','mois', 'progressions', 'declins'));
        $pdf = PDF::setOption('enable-local-file-access', true)
                  ->loadView('pdf.month', compact('grouped','compagne','company','data','locations','horaires','start','end','jours','tousjours','mois', 'progressions', 'declins'));
        // $pdf = PDF::loadView('pdf.day', compact('grouped','compagne','company','data'));
        $pdf->setPaper('a4')
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

        
        return $pdf->stream();
        
    }
}
 ?>