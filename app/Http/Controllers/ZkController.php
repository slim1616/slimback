<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\RtlEvent;
use App\Events\ErrorPorteEvent;
use App\Events\InfoPorteEvent;
use App\Events\SuccessPorteEvent;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Req;
use App\Porte;
use App\Timezone;
use App\Acceslevel;
use App\Employe;
use App\Zone;
use App\Historique;
use App\Setting;
use App\Http\Resources\SendTimezoneResource;
use App\Http\Resources\SendPorteResource;
use App\Http\Resources\PorteResources;
use Carbon\Carbon;

class ZkController extends Controller
{

    private $server_ip = "";
    public function __construct()
    {
        $this->server_ip = Setting::find(1)->adresse_serveur_zk;
    }

    public function Rtl(Request $request){
        
        
        event(new ErrorPorteEvent(array($request->user(), 'test error')));   
        // event(new RtlEvent(['rtl' => 'looooog']));   
        return response(['status' => true]);
    }

    /**
     * a partir de la page porte
     */
    //ok
    public function sendUsersToPorte(Request $request, $porte_id){
        $user = Auth::user() ?? Auth::guard("api")->user();
        $porte = Porte::find($porte_id);
        // $accesslevels = $porte->Acceslevels;
       if ($porte){
           $acceslevels = $porte->Acceslevels;
           if (count($acceslevels)>0){
               $users = [];
               foreach ($acceslevels as $acceslevel) {
                   if (!is_null($acceslevel->Employe->cardNo)&& $acceslevel->Employe->active){
                        if ($porte->sdk=='pull'){
                            
                            $users[] = array("pin" => strval($acceslevel->Employe->id),
                                            "name" => $acceslevel->Employe->nom . ' ' . $acceslevel->Employe->prenom,
                                            "password" => "1",
                                            "privilege" => "",
                                            "card_nb" => $acceslevel->Employe->cardNo,
                                            "group" => "0",
                                            "timezoneid" => strval($acceslevel->timezone_id),
                                            "starttime"=>"20200201",
                                            "endtime" => "20300101",
                                            "superauthorize" => "0",
                                            "fp_list" => [],
                                            "doorid"=> "1",

                            );
                        }else if ($porte->sdk=='standalone'){
                            $fp = [];
                            if ($acceslevel->Employe->fingerPrint1){
                                $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint1)?'' : $acceslevel->Employe->fingerPrint1, 'index' => '0');
                            }
                            if ($acceslevel->Employe->fingerPrint2){
                                $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint2)? '' : $acceslevel->Employe->fingerPrint2, 'index' => '1');
                            }
                            $users[] = array("id_management" => strval($acceslevel->Employe->id),
                                            "enroll_number" => strval($acceslevel->Employe->id),
                                            "name" => $acceslevel->Employe->nom . ' ' . $acceslevel->Employe->prenom,
                                            "password" => "1",
                                            "privilege" => "",
                                            "enabled" => "True",
                                            "fp_list" => $fp,
                                            "card_nb" => $acceslevel->Employe->cardNo,


                            );
                        }
                   }
               }
               $send = array("addr" => $porte->ip,
                             "password" => is_null($porte->password)? '' : $porte->password,
                             "device_id_management" => "1",
                             "users" => $users);
                            //  dd(json_encode($send));
                try {
                //echo 'device ' . $porte->ip;
                event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                $client = new Client();
                $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                // $body = $portetosend->toJson();
                $body = json_encode($send);
                // dd($body);
                $url = '';
                if ($porte->sdk=='pull'){
                    $url =  $this->server_ip.'/cli/pldsetusers';
                }else if ($porte->sdk=='standalone'){
                    $url =  $this->server_ip.'/cli/stdsetusers';
                }
                $request = new Req('POST', $url, $headers, $body);
                $response = $client->send($request, ['timeout' => 2000]);
                if ($response->hasHeader('Content-Length')) {
                    $resp = json_decode($response->getBody()->getContents());
                    // dd($resp);
                    if($resp->results=='error'){
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                        return response([ 'status' => false, 'msg' => 'erreur...']);
                    }else if ($resp->results=='Success'){
                        $porte->status = 'Ok';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                        return response([ 'status' => $response->getStatusCode()==200]);
                    }
                }else{
                    $porte->status = 'Error';
                    $porte->last_update_status = Carbon::now();
                    $porte->save();
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                    return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                }
            } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                    $porte->status = 'Error';
                    $porte->last_update_status = Carbon::now();
                    $porte->save();
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'erreur de connexion avec le lecteur')));   
                    return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
            }
           }else{
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Rien à envoyer')));   
            return response([ 'status' => false, 'msg' => 'Rien à envoyer']);   
           }

            
            
            
        }else{
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas")));   
            // return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }
    /*
    * à partir de la fiche employé
    */
    //ok
    public function sendUserToPortes(Request $request, $employe_id){
        $employe = Employe::find($employe_id);
        // $accesslevels = $porte->Acceslevels;
       if ($employe){
            if (!is_null($employe->cardNo)&& $employe->active){
                $acceslevels = Acceslevel::where('employe_id', $employe_id)->get();
                if (count($acceslevels)>0){
                    $porte_ids = $acceslevels->pluck('porte_id')->unique();
                    if (count($porte_ids)>0){
                        foreach ($porte_ids as $porte_id) {
                            $this->sendOneUserToOnePorte($porte_id, $employe);
                        }
                    }
        
                }
                return response(['status' => true]);
            }
        }

    }

    //ok
    public function AffectUsersToPorte(Request $request){
        $user = Auth::user() ?? Auth::guard("api")->user();
        
        if ($request->porte_id!=0){
            $porte = Porte::find($request->porte_id); 
            if ($porte){
                $acceslevels = Acceslevel::where('timezone_id', $request->timezone_id)
                                    ->where('porte_id', $request->porte_id)
                                    ->get();
                $this->sendUsersToOnePorte($request->porte_id, $acceslevels);
                // return response(['status' => true]);    
            }
        }else{
            if ($request->zone_id!=0){
                $zone = Zone::find($request->zone_id);
                $portes = $zone->Portes->pluck('id');
                if ($portes->count()>0){
                    foreach ($portes as $porte_id) {
                        $acceslevels = Acceslevel::where('timezone_id', $request->timezone_id)
                            ->where('porte_id', $porte_id)
                            ->get();
                        $this->sendUsersToOnePorte($porte_id, $acceslevels);
                    }
                }
            }
        }
        return response(['status' => true]);    

    }

    //ok
    public function getTimezonzsByPorte(Request $request, $porte_id){
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
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/pldgettz?address='.$porte->ip;
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stdgetalltz?address='.$porte->ip;
                        }
                        $request = new Req('GET', $url, $headers);
                        $response = $client->send($request, ['timeout' => 30]);
                        if ($response->hasHeader('Content-Length')) {
                            // echo $response->getStatusCode();
                            $resp = json_decode($response->getBody()->getContents());
                            if($resp->results=='error'){
                                $porte->status = 'Error';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                                return response([ 'status' => false, 'msg' => 'erreur...']);
                            }else if ($resp->results=='Success'){
                                $porte->status = 'Ok';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                return response([ 'status' => $response->getStatusCode()==200, 'timezones' => $resp->timezones]);
                            }
                        }else{
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                            return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                           // echo 'le lecteur ne repond pas';
                        }
                    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'erreur de connexion avec le lecteur')));   
                             return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                            //echo 'erreur de connexion avec le lecteur';
                    }
            
        }else{
            // echo "porte n'existe pas";
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas")));   
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }
    //ok
    public function getAttendaznceByPorte(Request $request, $porte_id){
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
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/pldattendance?address='.$porte->ip;
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stdattendance?address='.$porte->ip;
                        }
                        $request = new Req('GET', $url, $headers);
                        $response = $client->send($request, ['timeout' => 100]);
                        if ($response->hasHeader('Content-Length')) {
                            $resp = json_decode($response->getBody()->getContents());
                            
                                if($resp->results=='error'){
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "Erreur...")));   
                                    return response([ 'status' => false, 'msg' => $resp->type]);
                                }else if ($resp->results=='Success'){
                                    $porte->status = 'Ok';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    if (count($resp->logs)>0){
                                        $this->addToHistorique($porte->id, $resp->logs);
                                    }
                                    event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                                    return response([ 'status' => $response->getStatusCode()==200, 'logs' => $resp->logs]);
                                }
                        }else{
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas")));   
                            return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                           // echo 'le lecteur ne repond pas';
                        }
                    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur")));   
                        return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                            //echo 'erreur de connexion avec le lecteur';
                    }
            
        }else{
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas")));   
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
            // echo "porte n'existe pas";
        }
    }

    //ok
    public function CollectUsersFromPorte(Request $request, $porte_id){
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
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/pldgetusers?address='.$porte->ip;
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stdgetusers?address='.$porte->ip;
                        }
                        $request = new Req('GET', $url, $headers);
                        $response = $client->send($request, ['timeout' => 2000]);
                        if ($response->hasHeader('Content-Length')) {
                            $resp = json_decode($response->getBody()->getContents());
                            // dd($resp);
                            if($resp->results=='error'){
                                $porte->status = 'Error';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                                return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                            }else if ($resp->results=='Success'){
                                $porte->status = 'Ok';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                $usersnotindb = [];
                                $usersnotindevice = [];
                                // dd($resp);
                                if ($porte->sdk=='pull'){
                                    return response([ 'status' => $response->getStatusCode()==200, 'users' => $resp->users, 'auth' => $resp->auth, 'fps' => $resp->fps]);
                                }else if ($porte->sdk=='standalone'){
                                    $acceslevel = Acceslevel::where('porte_id', $porte->id)->get();
                                    // dd(collect($resp->users)->pluck('enroll_number'));
                                    if (count($resp->users)>0){
                                        if (count($resp->users)==count($acceslevel->pluck('employe_id')->unique())){
                                            $ok = true;
                                        }else if (count($resp->users)>count($acceslevel->pluck('employe_id')->unique())){
                                            // dd($acceslevel->pluck('employe_id')->unique());
                                            if (count($acceslevel->pluck('employe_id')->unique())>0){
                                                foreach ($resp->users as $userdevice) {
                                                    if (!in_array($userdevice->enroll_number,$acceslevel->pluck('employe_id')->unique())){
                                                        $emp = Employe::find($userdevice->enroll_number);
                                                        if ($emp){
                                                            $usersnotindb[] = $emp;
                                                        }
                                                    }
                                                }
                                            }
                                        }else{
                                            // dd(collect($resp->users)->pluck('enroll_number')->toArray());
                                            if (count($acceslevel->pluck('employe_id')->unique())>0){
                                                foreach($acceslevel->pluck('employe_id')->unique() as $employe_id) {
                                                    if (!in_array($employe_id, collect($resp->users)->pluck('enroll_number')->toArray())){
                                                        $emp = Employe::find($employe_id);
                                                        if ($emp){
                                                            $usersnotindevice[] = $emp;
                                                        }
                                                    }       
                                                }
                                            }
                                        }
                                    }
                                    event(new SuccessPorteEvent(array('user' => $resp->users, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                                    return response([ 'status' => $response->getStatusCode()==200, 'users' => $resp->users,
                                                                                                    // 'usersdb' => $acceslevel->pluck('employe_id')->unique(),
                                                                                                    'usersnotindb' => $usersnotindb,
                                                                                                    'usersnotindevice' => $usersnotindevice]);
                                }
                            }
                        }else{
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas"))); 
                            return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                           // echo 'le lecteur ne repond pas';
                        }
                    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                            return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                            //echo 'erreur de connexion avec le lecteur';
                    }
           
            
            
        }else{
            // echo "porte n'existe pas";
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }


    //
    public function SetTimeDevice(Request $request, $porte_id){
        $user = Auth::user() ?? Auth::guard("api")->user();
        $porte = Porte::find($porte_id);
        if ($porte){
            try {
                    //echo 'device ' . $porte->ip;
                    event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                    $client = new Client();
                    $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                    // print_r($portetosend->toJson());
                    $url = $this->server_ip.'/cli/settime';
                    
                    $body = json_encode(array('addr' => $porte->ip, 'password' => is_null($porte->password)? '' : $porte->password));
                    // dd($body);
                    $request = new Req('POST', $url, $headers, $body);
                    $response = $client->send($request, ['timeout' => 30]);
                    if ($response->hasHeader('Content-Length')) {

                        //dd(json_decode($response->getBody()->getContents()));
                        $resp = json_decode($response->getBody()->getContents());
                        if($resp->results=='error'){
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                            return response([ 'status' => false, 'msg' => 'erreur...']);
                        }else if ($resp->results=='Success'){
                            $porte->status = 'Ok';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();

                            return response([ 'status' => $response->getStatusCode()==200]);
                        }
                    }else{
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas"))); 
                        return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                        // echo 'le lecteur ne repond pas';
                    }
                } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                        return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                        //echo 'erreur de connexion avec le lecteur';
                }
        }else{
            // echo "porte n'existe pas";
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }

    
    public function TestConnection(Request $request){
        $user = Auth::user() ?? Auth::guard("api")->user();
        try {
                //echo 'device ' . $porte->ip;
                event(new InfoPorteEvent(array('user' => $user, 'porte' => Null, 'msg' => 'Connexion à ')));
                $client = new Client();
                $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                // print_r($portetosend->toJson());
                $url = $this->server_ip.'/cli/settime';
                
                $body = json_encode(array('addr' => $request->device_ip, 'password' => is_null($request->password)? '' : $request->password));
                // dd($body);
                $request = new Req('POST', $url, $headers, $body);
                $response = $client->send($request, ['timeout' => 30]);
                if ($response->hasHeader('Content-Length')) {
                    // echo $response->getStatusCode();
                    // dd( json_decode($response->getBody()->getContents()));
                    dd(json_decode($response->getBody()->getContents()));
                    $resp = json_decode($response->getBody()->getContents());
                    // dd(property_exists($resp,'error'));
                    if (property_exists($resp,'error')){
                        // $porte->status = 'Error';
                        // $porte->last_update_status = Carbon::now();
                        // $porte->save();
                        return response([ 'status' => false, 'msg' => 'erreur...']);
                    }else{
                        // $porte->status = 'Ok';
                        // $porte->last_update_status = Carbon::now();
                        // $porte->save();
                        return response([ 'status' => $response->getStatusCode()==200, 'result' => 'Ok']);

                    }
                    // echo 'Ok';
                    // $result = json_decode($response->getBody()->getContents());
                }else{
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => Null, 'msg' => "le lecteur ne repond pas"))); 
                    return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                    // echo 'le lecteur ne repond pas';
                }
            } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => Null, 'msg' => "erreur de connexion avec le lecteur"))); 
                    return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                    //echo 'erreur de connexion avec le lecteur';
            }
    }
    //ok
    public function EffaceTousLogs(Request $request, $porte_id){
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
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/plddelattendance';
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stddelatt';
                        }
                        $body = json_encode(array('addr' => $porte->ip, 'password' => is_null($porte->password)? '' : $porte->password));
                        $request = new Req('POST', $url, $headers, $body);
                        $response = $client->send($request, ['timeout' => 15]);
                        if ($response->hasHeader('Content-Length')) {
                            $resp = json_decode($response->getBody()->getContents());
                            // dd($resp);
                            if($resp->results=='error'){
                                $porte->status = 'Error';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                                return response([ 'status' => false, 'msg' => $resp->Type]);
                            }else if ($resp->results=='Success'){
                                $porte->status = 'Ok';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                
                                return response([ 'status' => $response->getStatusCode()==200]);
                            }
                        }else{
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas"))); 
                            return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                           // echo 'le lecteur ne repond pas';
                        }
                    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                            return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                            //echo 'erreur de connexion avec le lecteur';
                    }
           
            
            
        }else{
            // echo "porte n'existe pas";
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }


    //ok
    public function EffaceTousUsers(Request $request, $porte_id){
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
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/plddelallusers';
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stddelallusers';
                        }
                        $body = json_encode(array('addr' => $porte->ip, 'password' => is_null($porte->password)? '' : $porte->password));
                        $request = new Req('POST', $url, $headers, $body);
                        $response = $client->send($request, ['timeout' => 200]);
                        if ($response->hasHeader('Content-Length')) {
                            $resp = json_decode($response->getBody()->getContents());
                            // dd($resp);
                            if($resp->results=='error'){
                                $porte->status = 'Error';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                                return response([ 'status' => false, 'msg' => $resp->Type]);
                            }else if ($resp->results=='Success'){
                                $porte->status = 'Ok';
                                $porte->last_update_status = Carbon::now();
                                $porte->save();
                                return response([ 'status' => $response->getStatusCode()==200]);
                            }
                        }else{
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "le lecteur ne repond pas"))); 
                            return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                           // echo 'le lecteur ne repond pas';
                        }
                    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                            return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                            //echo 'erreur de connexion avec le lecteur';
                    }
           
            
            
        }else{
            // echo "porte n'existe pas";
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }
    //ok
    public function EffaceTousTimezones(Request $request, $porte_id){
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
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/plddelalltz';
                            $body = json_encode(array('addr' => $porte->ip, 'password' => is_null($porte->password)? '' : $porte->password));
                            $request = new Req('POST', $url, $headers, $body);
                            $response = $client->send($request, ['timeout' => 30]);
                            // dd($body);
                            if ($response->hasHeader('Content-Length')) {
                                $resp = json_decode($response->getBody()->getContents());
                                
                                if($resp->results=='error'){
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                                    return response([ 'status' => false, 'msg' => $resp->Type]);
                                }else if ($resp->results=='Success'){
                                    $porte->status = 'Ok';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();

                                    return response([ 'status' => $response->getStatusCode()==200]);
                                }
                            }
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stdelalltz';
                        }
                        
                    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "erreur de connexion avec le lecteur"))); 
                            return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                            //echo 'erreur de connexion avec le lecteur';
                    }
           
            
            
        }else{
            // echo "porte n'existe pas";
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas"))); 
            return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
        }
    }
    
    public function importelogsstandalone(Request $request){
        $portes = Porte::where('sdk','standalone')->get();
        if ($portes->count()>0){
            foreach ($portes as $porte) {
                $this->CollectLogsFromOneDevices($porte);
            }   
        }
        return response(['status' => true]);
    }
    public function importelogsdevices(Request $request){
        $portes = Porte::all();
        foreach ($portes as $porte) {
                $this->CollectLogsFromOneDevices($porte);
        }
        return response(['status' => true]);
    }



    //helper // ok
    public function sendUsersToOnePorte($porte_id, $acceslevels){
        // dd(count($acceslevels));
        $user = Auth::user() ?? Auth::guard("api")->user();
        $porte = Porte::find($porte_id);
        if (count($acceslevels)>0){
                $users = [];
                foreach ($acceslevels as $acceslevel) {
                    if (!is_null($acceslevel->Employe->cardNo)&& $acceslevel->Employe->active){
                                $fp = [];
                                if ($acceslevel->Employe->fingerPrint1){
                                    $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint1)?'' : $acceslevel->Employe->fingerPrint1, 'index' => '0');
                                }
                                if ($acceslevel->Employe->fingerPrint2){
                                    $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint2)? '' : $acceslevel->Employe->fingerPrint2, 'index' => '1');
                                }
                            if ($porte->sdk=='pull'){
                                $users[] = array("pin" => strval($acceslevel->Employe->id),
                                                "name" => $acceslevel->Employe->nom . ' ' . $acceslevel->Employe->prenom,
                                                "password" => "1",
                                                "privilege" => "",
                                                "card_nb" => $acceslevel->Employe->cardNo,
                                                "group" => "0",
                                                "timezoneid" => $acceslevel->timezone_id,
                                                "starttime"=>"20200201",
                                                "endtime" => "20300101",
                                                "superauthorize" => "0",
                                                "fp_list" => $fp,
                                                "doorid"=> "1",
    
                                );
                            }else if ($porte->sdk=='standalone'){
                                $fp = [];
                                if ($acceslevel->Employe->fingerPrint1){
                                    $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint1)?'' : $acceslevel->Employe->fingerPrint1, 'index' => '0');
                                }
                                if ($acceslevel->Employe->fingerPrint2){
                                    $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint2)? '' : $acceslevel->Employe->fingerPrint2, 'index' => '1');
                                }
                                $users[] = array("id_management" => strval($acceslevel->Employe->id),
                                                "enroll_number" => strval($acceslevel->Employe->id),
                                                "name" => $acceslevel->Employe->nom . ' ' . $acceslevel->Employe->prenom,
                                                "password" => "1",
                                                "privilege" => "0",
                                                "enabled" => "True",
                                                "fp_list" => $fp,
                                                "card_nb" => $acceslevel->Employe->cardNo,
    
    
                                );
                            }
                    }
                }
                $send = array("addr" => $porte->ip,
                                "password" => is_null($porte->password)? '' : $porte->password,
                                "device_id_management" => "1",
                                "users" => $users);
                try {
                    // echo 'device ' . $porte->ip;
                    event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                    $client = new Client();
                    $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                    // print_r($portetosend->toJson());
                    $body = json_encode($send);
                    $url = '';
                    if ($porte->sdk=='pull'){
                        $url =  $this->server_ip.'/cli/pldsetusers';
                    }else if ($porte->sdk=='standalone'){
                        $url =  $this->server_ip.'/cli/stdsetusers';
                    }
                    $request = new Req('POST',$url, $headers, $body);
                    $response = $client->send($request, ['timeout' => 2000]);
                    if ($response->hasHeader('Content-Length')) {
                        $resp = json_decode($response->getBody()->getContents());
                        if($resp->results=='error'){
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                            return response([ 'status' => false, 'msg' => $resp->Type]);
                        }else if ($resp->results=='Success'){
                            $porte->status = 'Ok';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            
                            event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Succes')));   
                            // return response([ 'status' => $response->getStatusCode()==200]);
                        }
                    }else{
                        // return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                        // echo 'le lecteur ne repond pas';
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                    }
                } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                        $porte->status = 'Error';
                        $porte->last_update_status = Carbon::now();
                        $porte->save();
                        // return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
                        // echo 'erreur de connexion avec le lecteur';
                        event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'erreur de connexion avec le lecteur')));   
                }  
        }else{
            return response([ 'status' => false, 'msg' => 'Rien à envoyer']);   
        } 
    }
    //ok
    public function sendOneUserToOnePorte($porte_id, $employe){
        $user = Auth::user() ?? Auth::guard("api")->user();
        $porte = Porte::find($porte_id);
        $acceslevels = $porte->Acceslevels->where('employe_id', $employe->id);
        // dd($acceslevels);
           if (count($acceslevels)>0){
               $users = [];
               foreach ($acceslevels as $acceslevel) {
                        $fp = [];
                        if ($acceslevel->Employe->fingerPrint1){
                            $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint1)?'' : $acceslevel->Employe->fingerPrint1, 'index' => '0');
                        }
                        if ($acceslevel->Employe->fingerPrint2){
                            $fp[] = array('fp_tp' => is_null($acceslevel->Employe->fingerPrint2)? '' : $acceslevel->Employe->fingerPrint2, 'index' => '1');
                        }
                        if ($porte->sdk=='pull'){
                            $users[] = array("pin" => strval($employe->id),
                                            "name" => $employe->nom . ' ' . $employe->prenom,
                                            "password" => "1",
                                            "privilege" => "",
                                            "card_nb" => $employe->cardNo,
                                            "group" => "0",
                                            "timezoneid" => $acceslevel->timezone_id,
                                            "starttime"=>"20200201",
                                            "endtime" => "20300101",
                                            "superauthorize" => "0",
                                            "fp_list" => $fp,
                                            "doorid"=> "1",
                            );
                        }else if ($porte->sdk=='standalone'){
                            $users[] = array("id_management" => strval($employe->id),
                                            "enroll_number" => strval($employe->id),
                                            "name" => $employe->nom . ' ' . $employe->prenom,
                                            "password" => "1",
                                            "privilege" => "",
                                            "enabled" => "True",
                                            "fp_list" => $fp,
                                            "card_nb" => $employe->cardNo,
                            );
                        }
               }
               $send = array("addr" => $porte->ip,
                             "password" => is_null($porte->password)? '' : $porte->password,
                             "device_id_management" => "1",
                             "users" => $users);
                try {
                // echo 'device ' . $porte->ip;
                event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                $client = new Client();
                $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                // $body = $portetosend->toJson();
                $body = json_encode($send);
                // dd($body);
                $url = '';
                if ($porte->sdk=='pull'){
                    $url =  $this->server_ip.'/cli/pldsetusers';
                }else if ($porte->sdk=='standalone'){
                    $url =  $this->server_ip.'/cli/stdsetusers';
                }
                $request = new Req('POST', $url, $headers, $body);
                $response = $client->send($request, ['timeout' => 2000]);
                if ($response->hasHeader('Content-Length')) {
                    $resp = json_decode($response->getBody()->getContents());
                    // dd($resp);
                        if($resp->results=='error'){
                            $porte->status = 'Error';
                            $porte->last_update_status = Carbon::now();
                            $porte->save();
                            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                            return response([ 'status' => false, 'msg' => $resp->Type]);
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
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'le lecteur ne repond pas')));   
                    // echo 'le lecteur ne repond pas';
                    return response([ 'status' => false, 'msg' => 'le lecteur ne repond pas']);
                } 
            } catch(\GuzzleHttp\Exception\GuzzleException $e) {
                    $porte->status = 'Error';
                    $porte->last_update_status = Carbon::now();
                    $porte->save();
                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'erreur de connexion avec le lecteur')));   
                    return response(['status' => false, 'msg' => 'erreur de connexion avec le lecteur']);
            }
           }else{
                event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Rien à envoyer')));   
           }    
    }

    public function CollectLogsFromOneDevices($porte){
        $user = Auth::user() ?? Auth::guard("api")->user();
        if ($porte){

                try {
                        //echo 'device ' . $porte->ip;
                        event(new InfoPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Connexion à ')));
                        $client = new Client();
                        $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
                        // print_r($portetosend->toJson());
                        $url = '';
                        if ($porte->sdk=='pull'){
                            $url =  $this->server_ip.'/cli/pldattendance?address='.$porte->ip;
                        }else if ($porte->sdk=='standalone'){
                            $url =  $this->server_ip.'/cli/stdattendance?address='.$porte->ip;
                        }
                        $request = new Req('GET', $url, $headers);
                        $response = $client->send($request, ['timeout' => 1000]);
                        if ($response->hasHeader('Content-Length')) {
                            $resp = json_decode($response->getBody()->getContents());
                                if($resp->results=='error'){
                                    $porte->status = 'Error';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "Erreur...")));   
                                    // return response([ 'status' => false, 'msg' => 'erreur...']);
                                }else if ($resp->results=='Success'){
                                    $porte->status = 'Ok';
                                    $porte->last_update_status = Carbon::now();
                                    $porte->save();
                                    if (count($resp->logs)>0){
                                        $this->addToHistorique($porte->id, $resp->logs);
                                        event(new SuccessPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => 'Liste importé avec succes')));
                                    }
                                    // return response([ 'status' => $response->getStatusCode()==200, 'logs' => $resp->logs]);
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
            event(new ErrorPorteEvent(array('user' => $user, 'porte' => new PorteResources($porte), 'msg' => "porte n'existe pas")));   
            // return response([ 'status' => false, 'msg' => "porte n'existe pas"]);
            // echo "porte n'existe pas";
        }
    }
    // To review
    public function addToHistorique($porte_id, $logs){
        $porte = Porte::find($porte_id);
        foreach ($logs as $log) {
            // dd($log);
            $datetime = Carbon::parse($log->dtetime);
            // dd($datetime->format('Y-m-d H:i:s'));
            $historique = Historique::where('porte_id', $porte_id)
                                    ->where('employe_id', $porte->sdk=='standalone'?$log->userID: $log->pin)
                                    ->where('datetime' , $datetime->format('Y-m-d H:i:s'))
                                    ->first();
            if(is_null($historique)){
                $hist = new Historique();
                $hist->porte_id = $porte_id;
                $hist->employe_id = $porte->sdk=='standalone'?$log->userID: $log->pin;
                $hist->datetime = $datetime->format('Y-m-d H:i:s');
                $hist->porte_id = $porte->id;
                $hist->zone_id = $porte->Zone->id;
                $hist->batiment_id = $porte->Zone->Batiment->id;
                $hist->nature_porte = $porte->nature;
                $employe = Employe::find($porte->sdk=='standalone'?$log->userID: $log->pin);
                if ($employe){
                    $hist->departement_id = $employe->Departement->id;
                    $hist->type_emp = $employe->type;
                    $hist->emploi = $employe->emploi;
                }

                //standalone
                if ($porte->sdk=='standalone'){
                    $hist->VerifyType = $log->VerifyType;
                    $hist->VerifyState = $log->VerifyState;
                    $hist->workcode = $log->workcode;
                }
                //pull
                if ($porte->sdk=='pull'){
                    $hist->eventtype = $log->eventtype;
                    $hist->verified = $log->verified;
                }
                $hist->save();
            }
        }
        
    }





}
