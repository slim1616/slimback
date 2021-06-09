<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Req;
use App\Acceslevel;
use App\Zone;
use App\Batiment;
use App\Timezone;
use App\Porte;
use App\Http\Resources\AccessleveResource;
use App\Http\Resources\SendTimezoneResource;
use App\Http\Resources\SendPorteResource;
use App\Http\Resources\AccessleveSendTZResource;
use App\Events\ErrorPorteEvent;
use App\Events\InfoPorteEvent;
use App\Events\SuccessPorteEvent;
use App\Http\Resources\PorteResources;
use App\Http\Resources\HistoriqueResource;

use Carbon\Carbon;
use App\Employe;
use App\Historique;
use App\Setting;

class AccessController extends Controller
{
    private $server_ip = "";
    public function __construct()
    {
        $this->server_ip = Setting::find(1)->adresse_serveur_zk;
    }
    // verifier si exist ne pas l'ajouter dans le access level sinon l'enlever
    public function massAffect(Request $request){
        // dd($request->all());
       $user = Auth::user() ?? Auth::guard("api")->user();
        try{
            if ($request->porte_id!=0){
                //effacer les users not selected
                $ids = [];
                foreach ($request->notselected as $employe_id) {
                    $trouve = Acceslevel::where('employe_id', $employe_id)
                                        ->where('porte_id',$request->porte_id)
                                        ->where('timezone_id',$request->timezone_id)
                                        ->first();
                    
                    if ($trouve){
                        // efface users from device
                        $ids[] = $employe_id;
                        $trouve->delete();
                    }
                }
                $this->effaceUsersFromDevice($ids, $request->porte_id);
                foreach ($request->employes as $employe_id) {
                    $trouve = Acceslevel::where('employe_id', $employe_id)
                                        ->where('porte_id',$request->porte_id)
                                        ->where('timezone_id',$request->timezone_id)
                                        ->first();
                    if (!$trouve){
                        $employe = Employe::find($employe_id);
                        if (!is_null($employe->cardNo) && $employe->active){
                            $acceslevel = new Acceslevel();
                            $acceslevel->employe_id = $employe_id;
                            $acceslevel->porte_id = $request->porte_id;
                            $acceslevel->timezone_id = $request->timezone_id;
                            $acceslevel->save();
                        }
                    }
                }
                $porte = Porte::find($request->porte_id);
                if ($porte->sdk=='pull'){
                    $this->SendTimezone($request->porte_id,$request->timezone_id);
                }
            }else{
                if ($request->zone_id!=0){
                    $zone = Zone::find($request->zone_id);

                    if ($zone){
                        $portes = $zone->Portes->pluck('id');
                        if ($portes->count()>0){
                            foreach ($portes as $porte_id) {
                                foreach ($request->notselected as $employe_id) {
                                    $trouve = Acceslevel::where('employe_id', $employe_id)
                                                        ->where('porte_id',$porte_id)
                                                        ->where('timezone_id',$request->timezone_id)
                                                        ->first();
                                    $ids = [];
                                    if ($trouve){
                                        // efface users from device
                                        $ids[] = $employe_id;
                                        $trouve->delete();
                                    }
                                }
                                foreach ($request->employes as $employe_id) {
                                    $trouve = Acceslevel::where('employe_id', $employe_id)
                                        ->where('porte_id',$porte_id)
                                        ->where('timezone_id',$request->timezone_id)
                                        ->first();
                                    if (!$trouve){
                                        $acceslevel = new Acceslevel();
                                        $acceslevel->employe_id = $employe_id;
                                        $acceslevel->porte_id = $porte_id;
                                        $acceslevel->timezone_id = $request->timezone_id;
                                        $acceslevel->save();
                                    }
                                }
                                $this->effaceUsersFromDevice($request->notselected, $porte_id,$request);
                                $porte = Porte::find($porte_id);
                                if ($porte->sdk=='pull'){
                                    $this->SendTimezone($porte_id,$request->timezone_id);
                                }
                            }
                        }
                    }
                }
            }
            
            return response(['status' => true]);
        } catch (Throwable $e) {
            return response(['status' => false]);
        }
    }

    public function getEmployesAffectes(Request $request){
        // dd($request->all());
        $accesslevels = [];
        if ($request->zone_id==0){
            $batiment = Batiment::find($request->batiment_id);
            $zones = $batiment->zones;
            if ($zones->count()>0){
                
                foreach ($zones as $zone) {
                    if ($zone->portes->count()>0){
                        foreach ($zone->portes as $porte) {
                            $accesslevels[] = $porte->Acceslevels;
                        }
                    }
                }
            }
        }else{
            $zone = Zone::find($request->zone_id);
            if ($zone->portes->count()>0){
                foreach ($zone->portes as $porte) {
                    if ($request->porte_id!=0){
                            if ($porte->id==$request->porte_id){
                                $accesslevels[] = $porte->Acceslevels;
                            }

                    }else{
                        $accesslevels[] = $porte->Acceslevels;
                    }
                }
            }

            
        }
        
        $filtreds = [];
        if ($request->timezone_id!=0){
            foreach ($accesslevels[0] as $accesslevel) {
                if ($accesslevel->timezone_id==$request->timezone_id){
                    $filtreds[] = $accesslevel;
                }
            }
        }else{
            $filtreds = $accesslevels;
        }
        // dd(count($filtreds));
        if (count($filtreds)>0){
            $finals = [];
            if ($request->departement_id!=0){
                foreach ($filtreds[0] as $accesslevel) {
                    // dd($accesslevel);
                    if ($accesslevel->Employe->Departement->id==$request->departement_id){
                        $finals[] = $accesslevel;
                    }
                }
            }else{
                $finals = $filtreds;
            }
        }else{
            $finals = [];
        }
        // dd(AccessleveResource::collection($finals));
        // dd(count($finals));
        // dd(AccessleveResource::collection($finals[0]));
        if (count($finals)==1){
            return response(['status' => true, 'employes' => AccessleveResource::collection($finals[0])]);
        }else if (count($finals)>0){
            return response(['status' => true, 'employes' => AccessleveResource::collection(collect($finals))]);       
        }else{
            return response(['status' => true, 'employes' => AccessleveResource::collection($finals)]);
        }
        
    }
    //Ok
    public function effaceEmployesAccess(Request $request){
        $acceslevel = Acceslevel::where('employe_id', $request->employe_id)
                                        ->where('porte_id',$request->porte_id)
                                        ->where('timezone_id',$request->timezone_id)
                                        ->first();
        if ($acceslevel){
            // effacer des devices
            $user = Auth::user() ?? Auth::guard("api")->user();
                $porte = Porte::find($request->porte_id);
                if ($porte){
                        try {
                                //echo 'device ' . $porte->ip;
                                event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                                $client = new Client();
                                $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                                // print_r($portetosend->toJson());
                                $url = '';
                                if ($porte->sdk=='pull'){
                                    $url =  $this->server_ip.'/cli/plddelusers';
                                    $users[] = array("pin" => strval($acceslevel->employe_id), "index" => "12");
                                    $body = json_encode(array('addr' => $porte->ip,
                                                              'password' => is_null($porte->password)? '' : $porte->password,
                                                              "users" => $users));
                                }else if ($porte->sdk=='standalone'){
                                    $url =  $this->server_ip.'/cli/stddelusers';
                                    $users[] = array("enroll_number" => strval($acceslevel->employe_id), "index" => "12");
                                    $body = json_encode(array('addr' => $porte->ip,
                                                              'password' => is_null($porte->password)? '' : $porte->password,
                                                              "users" => $users));
                                }
                                $request = new Req('POST', $url, $headers, $body);
                                $response = $client->send($request, ['timeout' => 15]);
                                if ($response->hasHeader('Content-Length')) {
                                    // echo $response->getStatusCode();
                                    // dd( json_decode($response->getBody()->getContents()));
                                // echo 'Ok';
                                    $acceslevel->delete();
                                    $resp = json_decode($response->getBody()->getContents());
                                    

                                    if($resp->results=='error'){
                                        $porte->status = 'Error';
                                        $porte->last_update_status = Carbon::now();
                                        $porte->save();
                                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "Erreur..."))); 
                                        // return response([ 'status' => false, 'msg' => $resp->Type]);
                                    }else if ($resp->results=='Success'){
                                        $porte->status = 'Ok';
                                        $porte->last_update_status = Carbon::now();
                                        $porte->save();
                                        event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                                        // return response([ 'status' => $response->getStatusCode()==200]);
                                    }
                                    return response(['status' => true]);
                                }else{
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas"))); 
                                    return response(['status' => false]);
                                    // return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                                // echo 'le lecteur ne repond pas';
                                }
                            } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                                    return response(['status' => false]);
                                    // return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                                    //echo 'erreur de connexion avec le lecteur';
                            }
                
                    
                    
                }else{
                    // echo "porte n'existe pas";
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
                    return response(['status' => false]);
                    // return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
                }
            


            //return response(['status' => true]);
        }else{
            return response(['status' => false]);
        }
    }

    public function getSingleEmployeAccess(Request $request, $id){
        $acceslevels = Acceslevel::where('employe_id', $id)
                                        ->get();
        if ($acceslevels){
            return response(['status' => true,  'access' => AccessleveResource::collection($acceslevels)]);
        }else{
            return response(['status' => false, 'access' => [] ]);
        }
    }
    
    public function getCurrentAffectaions(Request $request){
        // dd($request->all());
        if ($request->porte_id!=0){
            $acceslevels = Acceslevel::where('porte_id', $request->porte_id)
                                        ->where('timezone_id', $request->timezone_id)
                                        ->get();
            return response(['status' => true,  'selectedEmployes' => $acceslevels->pluck('employe_id')]);
        }else{
            return response(['status' => false]);
        }
    }


    public function filterHistorique(Request $request){
        // dd($request->all());

        $historiques = Historique::where('datetime','>=',$request->date_deb)
                                    ->where('datetime','<=', $request->date_fin);

        if ($request->batiment_id!=0){
            $historiques = $historiques->where('batiment_id', $request->batiment_id);
        }
        if ($request->zone_id!=0){
            $historiques = $historiques->where('zone_id', $request->zone_id);
        }
        if ($request->porte_id!=0){
            $historiques = $historiques->where('porte_id', $request->porte_id);
        }
        if ($request->departement_id!=0){
            $historiques = $historiques->where('departement_id', $request->departement_id);
        }
        if ($request->nature!=""){
            $historiques = $historiques->where('nature_porte', $request->nature);
        }
        if ($request->type_carte!=""){
            $historiques = $historiques->where('type_emp', $request->type_carte);
        }
        // dd($historiques->pluck('employe_id'));
        return response(['status' => true, 'historiques' => HistoriqueResource::collection($historiques->get()->reverse()->values())]);
    }

    public function filterHistoriqueByEmploye(Request $request){
        // dd($request->all());

        $historiques = Historique::where('datetime','>=',$request->date_deb)
                                    ->where('datetime','<=', $request->date_fin);

        
        if ($request->nature!=""){
            $historiques = $historiques->where('nature_porte', $request->nature);
        }
        // dd($historiques->pluck('employe_id'));
        
        $h = $historiques->orderByDesc('id')->paginate();
        // $send = $h->paginate(5);
        // dd($h);
        return response(['status' => true, 
                         'historiques' => HistoriqueResource::collection($h),
                         'next_page_url' => $h->nextPageUrl()
                         ]);
    }
    
    //helpers
    public function SendTimezone($porte_id, $timezone_id){
        $porte = Porte::find($porte_id);
        // dd($porte);
        if ($porte->sdk=='pull'){
            $this->sendTimezoneToOnePorte($porte_id, $timezone_id);
        }
    }
    //ok
    public function sendTimezoneToOnePorte($porte_id, $timezone_id){
        // echo $porte_id;
        $user = Auth::user() ?? Auth::guard("api")->user();
        $acceslevel = Acceslevel::where('timezone_id', $timezone_id)
                                    ->where('porte_id', $porte_id)
                                    ->first();

                                    
        $timezone = new AccessleveSendTZResource($acceslevel);
        $porte = Porte::find($porte_id);
        // dd($porte);
        // return response(['status' => true,'timezone' => $timezone]);
            // $accesslevels = $porte->Acceslevels;
            if (is_null($acceslevel)){
                return response(['status' => true]);
            }
        if ($porte){
            
                // echo $porte->ip . ' ' . $porte->titre;
                try {
                    event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                    $client = new Client();
                    $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                    // print_r($portetosend->toJson());
                    
                    $body = $timezone->toJson();
                    // dd($body);
                    $request = new Req('POST',  $this->server_ip.'/cli/pldsettz', $headers, $body);
                    $response = $client->send($request, ['timeout' => 15]);
                    if ($response->hasHeader('Content-Length')) {
                        $resp = json_decode($response->getBody()->getContents());
                        // dd($resp);
                        if($resp->results=='error'){
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            // return response([ 'status' => false, 'msg' => 'erreur...']);
                        }else if ($resp->results=='Success'){
                            $porte->status = 'Ok';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                            // return response([ 'status' => $response->getStatusCode()==200]);
                        }
                    }else{
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => $porte, 'msg' => 'le lecteur ne repond pas')));   
                        // return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                        // echo 'le lecteur ne repond pas';
                    }
                } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                        //  dd(Psr7\Message::toString($e->getRequest()));
                        // dd(Psr7\Message::toString($e->getResponse()));
                        // dd($e->getResponse());
                        
                        // return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                        // echo 'erreur de connexion avec le lecteur';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => $porte, 'msg' => 'erreur de connexion avec le lecteur')));   
                }
                
                
            }else{
                event(new ErrorPorteEvent(array('user' => $user, 'porte' => $porte, 'msg' => "porte n'existe pas")));   
                // echo "porte n'existe pas";
                // return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
            }
            
    }

    //Ok
    public function effaceUsersFromDevice($employe_ids, $porte_id){
                $user = Auth::user() ?? Auth::guard("api")->user();
                $porte = Porte::find($porte_id);
                if ($porte){
                        try {
                                //echo 'device ' . $porte->ip;
                                event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                                $client = new Client();
                                $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                                // print_r($portetosend->toJson());
                                $url = '';
                                $users = [];
                                if ($porte->sdk=='pull'){
                                    $url =  $this->server_ip.'/cli/plddelusers';
                                    foreach ($employe_ids as $employe_id) {
                                        $users[] = array("pin" => strval($employe_id), "index" => "12");
                                    }
                                    $body = json_encode(array('addr' => $porte->ip,
                                                              'password' => is_null($porte->password)? '' : $porte->password,
                                                              "users" => $users));
                                }else if ($porte->sdk=='standalone'){
                                    $url =  $this->server_ip.'/cli/stddelusers';
                                    foreach ($employe_ids as $employe_id) {
                                        $users[] = array("enroll_number" => strval($employe_id), "index" => "12");
                                    }
                                    $body = json_encode(array('addr' => $porte->ip,
                                                              'password' => is_null($porte->password)? '' : $porte->password,
                                                              "users" => $users));
                                }
                                // dd($body);
                                $request = new Req('POST', $url, $headers, $body);
                                $response = $client->send($request, ['timeout' => 200]);
                                if ($response->hasHeader('Content-Length')) {
                                    // echo $response->getStatusCode();
                                    // dd( json_decode($response->getBody()->getContents()));
                                    $resp = json_decode($response->getBody()->getContents());
                                    if($resp->results=='error'){
                                        $porte->status = 'Error';
                                        $porte->last_update_status = Carbon::now();
                                        $porte->save();
                                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "Erreur..."))); 
                                        // return response([ 'status' => false, 'msg' => $resp->Type]);
                                    }else if ($resp->results=='Success'){
                                        $porte->status = 'Ok';
                                        $porte->last_update_status = Carbon::now();
                                        $porte->save();
                                        event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                                        // return response([ 'status' => $response->getStatusCode()==200]);
                                    }
                                }else{
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas"))); 
                                    // return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                                // echo 'le lecteur ne repond pas';
                                }
                            } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                                    // return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                                    //echo 'erreur de connexion avec le lecteur';
                            }
                
                    
                    
                }else{
                    // echo "porte n'existe pas";
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
                    // return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
                }
            


            return response(['status' => true]);
   
    }



    //
    public function DeleteUserFromOnePorte($porte_id, $user_id){
        // echo $porte_id;
        $porte = Porte::find($porte_id);
            // $accesslevels = $porte->Acceslevels;
        if ($porte){
                $portetosend = new SendPorteResource($porte);
                try {
                    $client = new Client();
                    $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                    // print_r($portetosend->toJson());
                    $body = $portetosend->toJson();
                    $request = new Req('POST', $porte->ip . '/cli/stdsetusers', $headers, $body);
                    $response = $client->send($request, ['timeout' => 5]);
                    if ($response->hasHeader('Content-Length')) {
                        // echo $response->getStatusCode();
                        // dd( json_decode($response->getBody()->getContents()));
                        echo 'Ok';
                        // return response([ 'status' => $response->getStatusCode()==200, 'result' => json_decode($response->getBody()->getContents())]);
                    }else{
                        // return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                        echo 'le lecteur ne repond pas';
                    }
                } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                        // return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                        echo 'erreur de connexion avec le lecteur';
                }
                
                
            }else{
                echo "porte n'existe pas";
                // return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
            }
    }
}
