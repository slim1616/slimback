<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Emplacement;
use App\Http\Resources\EmplacementResource;

class EmplacementController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['emplacement'] = new EmplacementResource(Emplacement::findOrFail($id));
        $response['companies'] = \App\Company::all();   
        $response['users'] = \App\User::all();
     
        return response($response);
    }
    public function MesEmplacements(Request $request){
        $user = $request->user();
        $company = $user->Company;

        $response['emplacements'] =  EmplacementResource::collection($company->Emplacements); 
        return $response;
    }

     public function data(Request $request){
        $response = [];

        $response['companies'] = \App\Company::all();
                        
        
        $response['users'] = \App\User::all();
                        
                        
                
        return response($response);
    }
    
    public function list(Request $request){
      return response(EmplacementResource::collection(Emplacement::get()));
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
}
 ?>