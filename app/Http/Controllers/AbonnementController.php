<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Abonnement;
use App\Http\Resources\AbonnementResource;

class AbonnementController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['abonnement'] = new AbonnementResource(Abonnement::findOrFail($id));
                
                        
        
        $response['formules'] = \App\Formule::all();
                        
        
        $response['companies'] = \App\Company::all();
                        
        
        $response['users'] = \App\User::all();
                        
                        
                        
                        
                
        return response($response);
    }

     public function data(Request $request){
        $response = [];
                
                        
        
        $response['formules'] = \App\Formule::all();
                        
        
        $response['companies'] = \App\Company::all();
                        
        
        $response['users'] = \App\User::all();
                        
                        
                        
                        
                
        return response($response);
    }
    
    public function list(Request $request){
      return response(AbonnementResource::collection(Abonnement::get()));
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'formule_id' => 'required |max:20 ',
        'company_id' => 'required |max:20 ',
        'user_id' => 'required |max:20 ',
      ],[
        'formule_id.required' => 'formule_id est obligatoire.',
        'formule_id.max' => 'formule_id doit avoir aux max 20 characters.',
        'company_id.required' => 'company_id est obligatoire.',
        'company_id.max' => 'company_id doit avoir aux max 20 characters.',
        'user_id.required' => 'user_id est obligatoire.',
        'user_id.max' => 'user_id doit avoir aux max 20 characters.',
      ]);

        $abonnements = Abonnement::create($request->all());    
        return $abonnements;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'formule_id' => 'required |max:20 ',
        'company_id' => 'required |max:20 ',
        'user_id' => 'required |max:20 ',
      ],[
        'formule_id.required' => 'formule_id est obligatoire.',
        'formule_id.max' => 'formule_id doit avoir aux max 20 characters.',
        'company_id.required' => 'company_id est obligatoire.',
        'company_id.max' => 'company_id doit avoir aux max 20 characters.',
        'user_id.required' => 'user_id est obligatoire.',
        'user_id.max' => 'user_id doit avoir aux max 20 characters.',
      ]);

        $abonnements = Abonnement::findOrFail($id);
        $input = $request->all();
        $abonnements->fill($input)->save();
        return $abonnements;
    }
    
    public function delete(Request $request, $id){
        $abonnements = Abonnement::findOrFail($id);
        $abonnements->delete();
    }
}
 ?>