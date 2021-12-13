<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borne;
use App\Http\Resources\BorneResource;
use Carbon\Carbon;
use App\Bornesreponse;
use App\Compagneborne;

class BorneController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['borne'] = new BorneResource(Borne::findOrFail($id));
                
                        
                        
                        
                        
                        
                        
        
        $response['companies'] = \App\Company::all();
                        
                        
                
        return response($response);
    }

     public function data(Request $request){
        $response = [];
                
                        
                        
                        
                        
                        
                        
        
        $response['companies'] = \App\Company::all();
                        
                        
                
        return response($response);
    }
    
    public function list(Request $request){
      $user = $request->user();
      if ($user->Role->slug=='superadmin'){
        return response(BorneResource::collection(Borne::get()));
      }else{
        return response(BorneResource::collection( $user->Company->Bornes));
      }
      
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'title' => 'required |max:255 '
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.'
      ]);
      $bornes = Borne::create($request->all());    
      // $user = $request->user();
      // if (in_array($user->Role->slug,array('admin', 'superadmin'))){
      //   request()->merge(['company_id' => $user->Company->id]);
      //   return $bornes;
      // }else{
      //   return false;
      // }
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 '
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.'
      ]);

        $bornes = Borne::findOrFail($id);
        if ($bornes->company_id==$request->company_id){
          $input = $request->all();
          $bornes->fill($input)->save();
          return $bornes;
        }else{
          $input = $request->all();
          
          $Compagneborne = Compagneborne::where('borne_id',$request->id)
                                        ->where('company_id',$bornes->company_id)
                                        ->delete();
          $bornes->fill($input)->save();
          return $bornes;
        }
    }
    
    public function delete(Request $request, $id){
        $borne = Borne::findOrFail($id);
        if ($borne->Bornesreponses->count()){
          return response(['status' => false, 'msg' => 'Cette borne possède déjà des réponses']);
        }else{
          if ($borne->Comapagnes->count()>0){
            return response(['status' => false, 'msg' => 'Cette borne est déjà affecté à un client']);
          }else{
            $borne->delete();
            return response(['status' => true]);
          }
        }
    }

    public function HomeStats(Request $request){
      $user = $request->user();
      $response = [];
      $company = $user->Company;
      setlocale(LC_TIME, "fr_FR");
      $type = "week";
      $date = Carbon::now(); // or $date = new Carbon();
      // dd($date->endOfWeek()->format('Y-m-d H:i:s'));
      $start = $date->startOfWeek()->format('Y-m-d H:i:s');
      $end = $date->endOfWeek()->format('Y-m-d H:i:s');

      $data = Bornesreponse::where('company_id', $company->id)
                              ->where('datetime','>=', $start)
                              ->where('datetime', '<=', $end)
                              // ->groupBy('resp')
                              ->get();
  

      $grouped = $data->groupBy('resp');
      $bornes = $data->groupBy('borne_id');
      $counts = $data->pluck('resp')->countBy();
      
      $resps = [];
      $totals = [];
      $total = $data->count();
      for ($i=1; $i <=4 ; $i++) { 
        // dd($counts[$i]);
        if (isset($counts[$i])){
          $resps[$i] = round($counts[$i]/$total*100,0);
          $totals[$i] = round($counts[$i]);
        }else{
          $totals[$i] = 0;
        }
      }
      // return response(['status' => true, 'resps' => $resps]);
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
          foreach ($days as $key => $jour) {
            // dd($jour);
            $jours[$key] = $jour->count(); 
          }
            // $indice = $ind;
        }

            $weekdays = Carbon::getDays();
            $alljours = [];
            for ($i=0; $i < 7 ; $i++) { 
              if (isset($jours[$i])){
                $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = $jours[$i];
              }else{
                $alljours[Carbon::create($weekdays[$i])->locale('fr_FR')->dayName] = 0;
              }
            }
            $tmp = $alljours['dimanche'];
          }
        
        $j = array_shift($alljours);
        $alljours['dimanche'] = $tmp;
        $jours = $alljours;

        return response(['status' => true, 
                         'resps' => $resps,
                         'totals' => $totals,
                         'semaine' => $alljours
                      ]);
     

     
     
     
  }
}
 ?>