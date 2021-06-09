<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EmployesResources;
use App\Http\Resources\PointageResource;
use App\Http\Resources\pointageEmployeResource;
use App\Http\Resources\pointageResources;
use App\Employe;
use App\Departement;
use App\Historique;
use Carbon\Carbon;

class EmployeController extends Controller
{
    public function getList(Request $request){
        $employes = Employe::all();
        return response(['status' => true, 'employes' => EmployesResources::collection($employes)]);
    }

    public function getEmployesByDepartement(Request $request, $departement_id){
        if ($departement_id!="0"){
            $departement = Departement::find($departement_id);
            if ($departement){
                $employes = $departement->Employes->where('active',true);
                return response(['status' => true, 'employes' => EmployesResources::collection($employes)]);
            }else{
                return response(['status' => true, 'employes' => [] ]);
            }
        }else{
            $employes = Employe::where('active',true)->get();
            return response(['status' => true, 'employes' => EmployesResources::collection($employes)]);
        }
    }

    public function getEmploye(Request $request, $id){
        $employe = Employe::find($id);
        $departements = Departement::all();

        if ($employe){
            return response(['status' => true, 
                             'employe' => new EmployesResources($employe),
                             'departements' => $departements]);
        }else{
            return response(['status' => false]);
        }
    }

    
    public function filterPointage(Request $request){
        if($request->employe_id){
            $employe = Employe::find($request->employe_id);
            
            $startDate = new Carbon($request->date_deb);
            $endDate = new Carbon($request->date_fin);
            $all_dates = array();
            while ($startDate->lte($endDate)){
                $all_dates[] = $startDate->toDateString();
                $startDate->addDay();
            }
            Carbon::setLocale('fr');
            // print_r($all_dates);
            
            $pointages = [];
            if ($employe->emploi){
            foreach ($all_dates as $jour) {
                $day =  new Carbon($jour);
                $weekday = Carbon::parse($jour)->dayOfWeek;
                // dd($employe);
                    if(count(json_decode($employe->emploi)[$weekday])>0){
                        $pointagesJour = Historique::where('datetime','>=',new Carbon($jour))
                                                    ->where('datetime','<=', $day->endOfDay())
                                                    ->where('nature_porte','pointage')
                                                    ->where('employe_id', $request->employe_id)
                                                    ->where('type_emp', 'employe')->pluck('datetime');
                        
                        $pointage = $this->getDataByPointages($employe->emploi, $pointagesJour, $jour);
                        $pointages[] = array('employe' => $employe, 'pointages' => $pointage);
                    }        
                }
            }else{
                $pointages[] = array('employe' => $employe, 'pointages' => []);
            }
            return response(['status' => true, 'pointages' => $pointages, 'typereport' => 'employe']);
            // return response(['status' => true, 'pointages' => $pointages,'typereport' => 'employe']);
        }else{
            $startDate = new Carbon($request->date_deb);
            $endDate = new Carbon($request->date_fin);
            $all_dates = array();
            while ($startDate->lte($endDate)){
                $all_dates[] = $startDate->toDateString();
                $startDate->addDay();
            }
            Carbon::setLocale('fr');
            

            if($request->departement_id!='0'){
                $listemployes = Employe::where('active',true)
                                        ->where('departement_id',$request->departement_id)->get();
            }else{
                $listemployes = Employe::where('active',true)->get();
            }
            $pointagesJour=[];
            foreach ($all_dates as $jour) {
                $weekday = Carbon::parse($jour)->dayOfWeek;
                $employespresents = [];
                foreach ($listemployes as $employe) {
                    if ($employe->emploi){
                        
                        // if(json_decode($employe->emploi)){
                            if(count(json_decode($employe->emploi)[$weekday])>0){
                                $employespresents[] = $employe;
                            }
                        // }
                    }
                }
                foreach ($employespresents as $employe) {
                    // $employe = Employe::find($employe_id);
                    $pointages = $employe->Historiques->where('datetime','<=', $jour . ' 23:59:59')
                    ->where('datetime','>=', $jour . ' 00:00:00')
                    ->where('nature_porte','pointage')->pluck('datetime');
                    // dd($pointages->first()->datetime);
                    // echo $employe->id .'<br>';
                    $pointages = $this->getDataByPointages($employe->emploi, $pointages , $jour);
                    $pointagesJour[] = array('employe' => new EmployesResources($employe), 
                                            'pointages' => $pointages,
                                            'date' => $jour
                                                                
                                                                );
                }
            }
            
            return response(['status' => true, 'pointages' => $pointagesJour, 'typereport' => 'all']);
        }
        
    }

    public function getDataByPointages($emploi, $pointages, $jour){
        $pointageslist = collect([]);
        if ($pointages->count()>0){
            $weekday = Carbon::parse($pointages->first())->dayOfWeek;
            // dd($weekday);
            $nbseances = count(json_decode($emploi)[$weekday]);
            $seances = json_decode($emploi)[$weekday];
            // print_r(json_decode($emploi));
            $m = 0;
            $h = 0;
            $min = 0;
            $startpointage = 0;
            $endpointage = 0;
            $retardmatin = 0;
            $retartdapMidi = 0;
            $avheurmat = 0;
            $avhapmidi = 0;
            if (!is_null($emploi)){
                if($nbseances>0){
                    $debmatin = json_decode($emploi)[$weekday][0][0];
                    $finmatin = json_decode($emploi)[$weekday][0][1];
                    // print_r(json_decode($emploi)[$weekday][0][1]) .'<br>';
                    // echo $debmatin.'<br>';
                    // echo $finmatin.'<br>';
                    
                    $alerte = "";
                    if ($nbseances==1){
                        $pause = 0;
                        $startpointage = Carbon::parse($pointages->first())->format('H:i');
                        if(Carbon::parse($debmatin)>Carbon::parse($startpointage)){
                            $startpointage =  $debmatin;
                        }else{
                            $retardmatin = Carbon::parse($startpointage)->diffInMinutes(Carbon::parse($debmatin));
                            $alerte.= "Retard Matin ".$retardmatin." min <br/>";
                        }
                        $avheurmat = 0;
                        if ($pointages->count()>1){
                            if (Carbon::parse($finmatin)>Carbon::parse(Carbon::parse($pointages[1])->format('H:i'))){
                                $sortieMatinavHeure = Carbon::parse($pointages[1])->format('H:i');
                                
                                $avheurmat = Carbon::parse(Carbon::parse($pointages[1])->format('H:i'))->diffInMinutes(Carbon::parse($finmatin));
                                $alerte.= "Sortie avant l'heure Matin ". $avheurmat . " min <br/>";
                            }
                        }
                        $endpointage = Carbon::parse($pointages->last())->format('H:i');
                        if(Carbon::parse($finmatin)<Carbon::parse($endpointage)){
                            $endpointage =  $finmatin;
                        }
                        // dd($alerte);
                        // dd(Carbon::parse($endpointage));
                        $m = Carbon::parse($endpointage)->diffInMinutes(Carbon::parse($startpointage));
                    }

                    if ($nbseances==2){
                        $debapresmidi = json_decode($emploi)[$weekday][1][0];
                        $finapresmidi = json_decode($emploi)[$weekday][1][1];
                        
                        $startpointage = Carbon::parse($pointages->first())->format('H:i');
                        if(Carbon::parse($debmatin)>Carbon::parse($startpointage)){
                            $startpointage =  $debmatin;
                        }else{
                            $retardmatin = Carbon::parse($startpointage)->diffInMinutes(Carbon::parse($debmatin));
                            $alerte.= "Retard Matin ".$retardmatin." min <br/>";
                        }
                        //
                        // dd(Carbon::parse(Carbon::parse($pointages[1])->format('H:i')));
                        $avheurmat = 0;
                        if (isset($pointages[1])){
                            if ($pointages->count()>1){
                                if (Carbon::parse($finmatin)>Carbon::parse(Carbon::parse($pointages[1])->format('H:i'))){
                                    $sortieMatinavHeure = Carbon::parse($pointages[1])->format('H:i');
                                    
                                    $avheurmat = Carbon::parse(Carbon::parse($pointages[1])->format('H:i'))->diffInMinutes(Carbon::parse($finmatin));
                                }
                            }
                        }
                        //
                        // dd(Carbon::parse($debapresmidi));
                        $retartdapMidi = 0;
                        if (isset($pointages[2])){
                            if (Carbon::parse($debapresmidi)>Carbon::parse(Carbon::parse($pointages[2])->format('H:i'))){
                                $entreapMidi = Carbon::parse($pointages[2])->format('H:i');
                            }else{
                                $entreapMidi = Carbon::parse($debapresmidi);
                                $retartdapMidi = Carbon::parse(Carbon::parse($pointages[2])->format('H:i'))->diffInMinutes(Carbon::parse($entreapMidi));
                                $alerte.= "Retard apres midi ". $retartdapMidi . " min <br/>";
                            }
                        }
                        // dd($entreapMidi);
                        if (isset($pointages[3])){
                            $endpointage = Carbon::parse($pointages->last())->format('H:i');
                            if(Carbon::parse($finapresmidi)<Carbon::parse($endpointage)){
                                $endpointage =  $finapresmidi;
                            }else{
                                $avhapmidi = Carbon::parse(Carbon::parse($finapresmidi)->format('H:i'))->diffInMinutes(Carbon::parse($endpointage));
                                // dd($avhapmidi);
                                $alerte.= "Sortie avant l'heure A Midi ". $avhapmidi . " min <br/>";
                            }
                        }
                        // dd($alerte);
                        $m = Carbon::parse($endpointage)->diffInMinutes(Carbon::parse($startpointage));
                        
                        $pausedeb = Carbon::parse($finmatin);
                        $pausefin = Carbon::parse($debapresmidi);
                        $pause = $pausefin->diffInMinutes($pausedeb);
                        // dd($pause);
                    }
                    if ($pointages->count()>=2){
                        $mints = intval($m) - intval($pause) -intval($avheurmat) - intval($retartdapMidi);
                        $min = $mints%60;
                        $h = intdiv($mints,60);
                    }

                    // dd(intdiv($mints,60));

                }
            }
            return array( 'first' => Carbon::parse($pointages->first())->format('H:i:s'),
                                'last' => Carbon::parse($pointages->last())->format('H:i:s'),
                                'date' =>  is_null($jour) ?  Carbon::parse($pointages->first())->format('Y-m-d'): Carbon::parse($jour)->format('Y-m-d'),
                                'nbpointage' => $pointages->count(),
                                'nbseances' => $nbseances,
                                'emploiejour' => is_null($emploi) ? [] : json_decode($emploi)[$weekday],
                                'pointagejour' => pointageResources::collection($pointages),
                                'alerte' => in_array($pointages->count(),array(1,3,5,7,9)) ? 'probleme' : 'normal',
                                'daynumber' => $weekday,
                                'nbheures' =>  $h . ':' .  $min,
                                'retardmatin' => $retardmatin,
                                'avhapmidi' => $avhapmidi,
                                'msg' => '<p style="color: orange;">'.$alerte.'<p>');

        }else{
            $weekday = Carbon::parse($pointages->first())->dayOfWeek;
            return array( 'first' => is_null($jour) ?  Carbon::parse($pointages->first())->format('d/m/Y'): Carbon::parse($jour)->format('d/m/Y'),
                                'last' => is_null($jour) ?  Carbon::parse($pointages->first())->format('d/m/Y'): Carbon::parse($jour)->format('d/m/Y'),
                                'date' =>  is_null($jour) ?  Carbon::parse($pointages->first())->format('Y-m-d'): Carbon::parse($jour)->format('Y-m-d'),
                                'nbpointage' => 0,
                                'nbseances' => 0,
                                'emploiejour' => is_null($emploi) ? [] : json_decode($emploi)[$weekday],
                                'pointagejour' => [],
                                'alerte' => '',
                                'daynumber' => 0,
                                'nbheures' =>  0,
                                'retardmatin' => 0,
                                'avhapmidi' => 0,
                                'msg' => '<p style="color: red;">Absent</p>');
        }
        // return $pointageslist;

    }
    public function employesDepartement(Request $request, $id){
        $departement = Departement::find($id);
        if ($departement){
            return response(['status' => true, 
                             'employes' =>  EmployesResources::collection($departement->employes)]);
        }else{
            return response(['status' => true, 'employes' =>  EmployesResources::collection(Employe::all())]);
        }
    }

    public function addEmployeAvatar(Request $request){

        if ($request->user()->Role->slug=="admin"){
            if($request->post('avatar') && $request->employe_id){
                $employe = Employe::find($request->employe_id);
                if ($employe){
                    if ($employe->avatar){
                        $employe->avatar->delete();
                    }
                    $image = $request->post('avatar');
                    $media = $employe->addMediaFromBase64($image)->toMediaCollection('avatar');
                    $employe->avatar_id = $media->id;
                    $employe->save();
                    $e = Employe::find($employe->id);
                    return response(['status' => true, 'employe' =>  new EmployesResources($e)]);
                }else{
                    return response(['status' => false, 'msg' => "Employé n'existe pas"]);
                }
            }else{
                return response(['status' => false, 'msg' => 'Erreur de requete']);
            }
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }
    public function update(Request $request){
        // dd($request->active?1:0);
        $employe = Employe::find($request->id);
        if ($employe){
            $employe->email = $request->email;
            $employe->nom = $request->nom;
            $employe->prenom = $request->prenom;
            $employe->birthday = $request->birthday;
            $employe->adress = $request->adress;
            if ($request->phone){
                $employe->phone = $request->phone;
            }
            if ($request->sexe){
                $employe->sexe = $request->sexe;
            }
            if ($request->matricule){
                $employe->matricule = $request->matricule;
            }
            if ($request->fonction){
                $employe->fonction = $request->fonction;
            }
            if ($request->postal_code){
                $employe->postal_code = $request->postal_code;
            }
            if ($request->cardNo){
                $employe->cardNo = $request->cardNo;
            }
            if ($request->marge_entree){
                $employe->marge_entree = $request->marge_entree;
            }else{
                $employe->marge_entree = 0;
            }
            if ($request->marge_sortie){
                $employe->marge_sortie = $request->marge_sortie;
            }else{
                $employe->marge_sortie = 0;
            }
            if ($request->marge_entree_retard){
                $employe->marge_entree_retard = $request->marge_entree_retard;
            }
            else{
                $employe->marge_entree_retard = 0;
            }
            if ($request->marge_sortie_retard){
                $employe->marge_sortie_retard = $request->marge_sortie_retard;
            }
            else{
                $employe->marge_sortie_retard = 0;
            }
            $employe->fingerPrint1 = $request->fingerPrint1;
            $employe->fingerPrint2 = $request->fingerPrint2;
            
            $employe->emploi = $request->emploi;
            if (!is_null($request->active)){
                $employe->active = $request->active==true? true : false;
                // dd($employe->active);
            }
            $employe->departement_id = $request->departement_id;
            if ($employe->save()){
                return response(['status' => true, 'employe' => new EmployesResources($employe)]);
            }else{
                return response(['status' => false]);    
            }
        }else{
            return response(['status' => false]);
        }
    }
    public function add(Request $request){
        // dd($request->all());
        $employe = new Employe();

            $employe->nom = $request->nom;
            $employe->prenom = $request->prenom;
            if ($request->email){
                $employe->email = $request->email;
            }
            if ($request->birthday){
                $employe->birthday = $request->birthday;
            }
            $employe->adress = $request->adress;
            if ($request->phone){
                $employe->phone = $request->phone;
            }
            if ($request->sexe){
                $employe->sexe = $request->sexe;
            }
            if ($request->matricule){
                $employe->matricule = $request->matricule;
            }
            if ($request->fonction){
                $employe->fonction = $request->fonction;
            }
            if ($request->postal_code){
                $employe->postal_code = $request->postal_code;
            }
            if ($request->cardNo){
                $employe->cardNo = $request->cardNo;
            }
            if (!is_null($request->active)){
                $employe->active = $request->active==true? true : false;
                // dd($employe->active);
            }
            $employe->departement_id = $request->departement_id;
            if ($employe->save()){
                return response(['status' => true, 'employe' => new EmployesResources($employe)]);
            }else{
                return response(['status' => false]);    
            }
    }
    public function departementsList(Request $request){
        $departements = Departement::all();
        return response(['status' => true, 'departements' => $departements]);
    }

    public function efface(Request $request){
        $employe_id = $request->employe_id;
        $employe = Employe::find($employe_id);
        if ($employe){
            $employe->delete();
            return response(['status' => true]);
        }else{
            return response(['status' => false]);
        }
    }
    public function affectMassEmplois(Request $request){
        try{
            if (count($request->employes)>0){
                foreach ($request->employes as $employe_id) {
                    $employe = Employe::find($employe_id);
                    $employe->marge_entree = $request->marge_entree;
                    $employe->marge_sortie = $request->marge_sortie;
                    $employe->marge_entree_retard = $request->marge_entree_retard;
                    $employe->marge_sortie_retard = $request->marge_sortie_retard;
                    $employe->emploi = $request->emploi;
                    $employe->save();
                }
                return response(['status' => true]);
            }
        }catch(Throwable $e){
            return response(['status' => false, 'msg' => 'Erreur...']);
        }
    }

    
}
