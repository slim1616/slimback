<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Emplacement;
use App\Enqueteemplacement;
use App\Http\Resources\EmplacementResource;
use Illuminate\Support\Str;

class EmplacementController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $emplacement =  Emplacement::findOrFail($id);
        $response['companies'] = \App\Company::all();   
        $response['users'] = \App\User::all();
        if ($request->user()->Role->slug=='superadmin'){
          $response['emplacement'] = new EmplacementResource($emplacement);
          $response['status'] = true;
        }else if ($request->user()->Role->slug=='admin'){
            if ($request->user()->Company->id==$emplacement->company_id){
              $response['emplacement'] = new EmplacementResource($emplacement);
              $response['status'] = true;
            }else{
              $response['status'] = false;
            }

        }else{
          $response['status'] = false;
        }
          
          return response($response);
    }
    public function MesEmplacements(Request $request){
      $user = $request->user();
      if ($user->Role->slug=='superadmin'){
        $response['emplacements'] =  EmplacementResource::collection(Emplacement::get()); 
      }else{
        $company = $user->Company;
        $response['emplacements'] =  EmplacementResource::collection($company->Emplacements); 
      }
        return $response;
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
        return response(EmplacementResource::collection(Emplacement::get()));
      }else{
        return response(EmplacementResource::collection($user->Company->Emplacements));
      }
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);
      $user = $request->user();

      if ($user->Role->slug=='admin'){
        request()->merge(['company_id' => $user->Company->id, 'user_id' => $user->id]);
        $emplacement = Emplacement::create($request->all());    
        return $emplacement;
      }else{
        return false;
      }
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);

        $emplacements = Emplacement::findOrFail($id);
        $input = $request->all();
        $emplacements->fill($input)->save();
        return $emplacements;
    }
    
    public function delete(Request $request, $id){
        $emplacements = Emplacement::findOrFail($id);
        $emplacements->delete();
    }
    public function newpass(Request $request){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 7; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)]; 
        }
        $enqemp = Enqueteemplacement::where('emplacement_id', $request->emplacement_id)
                                ->where('enquete_id', $request->enquete_id)
                                ->first();
        $enqemp->password = $randomString;
        $enqemp->save();
        return response(['status' => true, 'password' => $randomString]);

    }
}
 ?>