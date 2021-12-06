<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enquete;
use App\Enqueteemplacement;
use App\Section;
use App\Reponse;
use App\Singlereponse;
use App\Emplacement;
use App\Http\Resources\EnqueteResource;
use App\Http\Resources\EmplacementResource;
use App\Http\Resources\EnqEmplacementResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\ReponsesResources;
use Carbon\Carbon;

class EnqueteController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $enquete = Enquete::findOrFail($id);
        $response['enquete'] = new EnqueteResource($enquete);
        $response['companies'] = \App\Company::all();
        // $response['emplacements'] = EmplacementResource::collection($enquete->Company->Emplacements);
        $emps = $enquete->Company->Emplacements;//->where('borne',0);

        // dd($enquete->Enqueteemplacements->pluck('id')->toArray());
        $ems = [];
        foreach ($emps as $emp) {
          if (in_array($emp->id,$enquete->Enqueteemplacements->pluck('emplacement_id')->toArray())){
            foreach (json_decode(EnqEmplacementResource::collection($emp->Enqueteemplacements)->toJson()) as $e) {
              $ems[] = $e;
            }
          }else{
            $ems[] = array('emplacement_id' => $emp->id, 'enquete_id' => $enquete->id, 'password'=>null, 'title' => $emp->title);
          }
        }
        $response['emplacements'] = $ems;
        $response['users'] = \App\User::all();       
        
        return response($response);
    }
    public function getFront(Request $request, $id){
      $response = [];
      $enquete = Enquete::find($id);
      if ($enquete){
          if ($enquete->where('online')){
            $response['questions'] = QuestionResource::collection(Section::where('enquete_id', $id)
            ->orderBy('order')
            ->get());
            $response['enquete'] = new EnqueteResource($enquete);
            $response['uniqid'] = uniqid($id);
            $response['status'] = true;
          }else{
            $response['status'] = false;
          }
      }else{
        $response['status'] = false;
      }
      return response($response);
  }
  public function getFrontMobile(Request $request, $id){
    // return response($id);

    $Enqueteemplacement = Enqueteemplacement::where('emplacement_id', $request->emplacement_id)
                                              ->where('enquete_id', $id)
                                      ->first();
    if (!is_null($Enqueteemplacement)){
      if (strcmp($Enqueteemplacement->password,$request->password)==0){

      }else{
        return response(['status' => false, 'msg' => 'Mot de passe incorrect']);
      }
    }else{
      return response(['status' => false, 'msg' => "cette enquete n'est pas activé"]);
    }

    $response = [];
    $enquete = Enquete::find($id);
    if ($enquete){
        if ($enquete->where('online')){
          $response['questions'] = QuestionResource::collection(Section::where('enquete_id', $id)
          ->orderBy('order')
          ->get());
          $response['enquete'] = new EnqueteResource($enquete);
          $response['emplacement'] = new EmplacementResource(Emplacement::find($request->emplacement_id));
          $response['uniqid'] = uniqid($id);
          $response['status'] = true;
        }else{
          $response['status'] = false;
        }
    }else{
      $response['status'] = false;
    }
    return response($response);
}

     public function data(Request $request){
        $response = [];
        $response['companies'] = \App\Company::all();  
        $response['users'] = \App\User::all();       
        return response($response);
    }
    
    public function list(Request $request){
      $user = $request->user();
      if ($user->Role->slug=='superadmin'){
        return response(EnqueteResource::collection(Enquete::get()));
      }else{
        return response(EnqueteResource::collection($user->Company->Enquetes));
      }
      
    }
    
    public function create(Request $request){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'description' => 'required ',
        
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);
      $user = $request->user();
      if ($user->Role->slug=='admin'){
        request()->merge(['company_id' => $user->Company->id, 'user_id' => $user->id]);
        $enquetes = Enquete::create($request->all());    
        return $enquetes;
      }else{
        return false;
      }
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'description' => 'required ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
        'description.required' => 'description est obligatoire.',
      ]);
        $enquetes = Enquete::findOrFail($id);
        if($enquetes->Enqueteemplacements){
          $enquetes->Enqueteemplacements()->delete();
        }
        if (!is_null($request->online)){
          $enquetes->online = $request->online==true? true : false;
          // dd($employe->active);
        }
        if (count($request->selectedEmplacements)>0){
          foreach ($request->selectedEmplacements as $emplacement_id) {
            // $enqemp = Enqueteemplacement::where('emplacement_id', $emplacement_id)
            //                               ->where('enquete_id', $id)
            //                               ->first();
            $enqemp = new Enqueteemplacement();
            $enqemp->emplacement_id = $emplacement_id;
            $enqemp->company_id = $enquetes->Company->id;
            $enqemp->enquete_id = $id;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 7; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)]; 
            }
            $newpass = $randomString;
            $enqemp->password = $newpass;
            $enqemp->save();
          }
        }
        $input = $request->all();
        $enquetes->fill($input)->save();
        return new EnqueteResource($enquetes);
    }
    
    public function delete(Request $request, $id){
        $enquetes = Enquete::findOrFail($id);
        $enquetes->delete();
    }
    public function addResponse(Request $request){
      
      $uniqid = $request->uniqid;
      $enquete_id = $request->enquete_id;
      $enquete = Enquete::find($enquete_id);
      $company_id = $enquete->Company->id;
      if (count($request->responses)>0){
        $reponse = new Reponse();
        $reponse->enquete_id = $enquete_id;
        $reponse->company_id = $company_id;
        if ($request->emplacement_id){
          $reponse->emplacement_id = $request->emplacement_id;
        }
        $reponse->uniqid = $uniqid;
        $reponse->source = $request->source;
        $reponse->ip = $request->ip();
        $reponse->save();
        foreach ($request->responses as $response) {

          $singlereponse = new Singlereponse();
          $singlereponse->enquete_id = $response['enquete_id'];
          $singlereponse->ip = $request->ip();
          $singlereponse->company_id = $company_id;
          $singlereponse->section_id = $response['section_id'];
          $singlereponse->reponse = $response['reponse'];
          $singlereponse->uniqid = $uniqid;
          $singlereponse->source = $request->source;
          if ($request->emplacement_id){
            $singlereponse->emplacement_id = $request->emplacement_id;
          }
          $singlereponse->reponse_id = $reponse->id;
          $singlereponse->save();
        }
        
      }
      return response(['status' => true]);  
    }
    public function getResponses(Request $request, $unique){
      $reponse = Reponse::where('uniqid', $unique)->first();
      $response['questions'] = QuestionResource::collection(Section::where('enquete_id', $reponse->enquete_id)
                          ->orderBy('order')
                          ->get());
      $response['responses'] = $reponse->Reponses;
      return response($response);
    }
    
    public function getHistorique(Request $request, $enquete_id){
      $reponses = Reponse::where('enquete_id', $enquete_id)->get();
      $enquete = Enquete::findOrFail($enquete_id);
      $response['emplacements'] = EmplacementResource::collection($enquete->Company->Emplacements);
      $grouped = $reponses->map(function($response){
          return array('date' => Carbon::parse($response->created_at)->format('d/m/Y'),
                      'count' => $response->Reponses->count());
      });
      $response['dates'] = $grouped->groupBy('date')->values();
      $response['questions'] = QuestionResource::collection(Section::where('enquete_id', $enquete_id)
                          ->orderBy('order')
                          ->get());
      $response['responses'] = ReponsesResources::collection($reponses);
      return response($response);
    }
    
    public function getHistoriqueBySource(Request $request){
      // dd($request->selectedEmplacementll);
      if ($request->selectedEmplacement=='*'){
        $reponses = Reponse::where('enquete_id', $request->enquete_id)->get();
      }else{
        $reponses = Reponse::where('enquete_id', $request->enquete_id)
                            ->where('emplacement_id',$request->selectedEmplacementll)->get();
      }
      $response['dates'] = [];
      if ($reponses){
        $grouped = $reponses->map(function($response){
            return array('date' => Carbon::parse($response->created_at)->format('d/m/Y'),
                        'count' => $response->Reponses->count());
        });
        $response['dates'] = $grouped->groupBy('date')->values();
      }
      
      return response($response);
    }
    
}
 ?>