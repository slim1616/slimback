<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compagne;
use App\Http\Resources\CompagneResource;
use App\Compagneborne;

class CompagneController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $compagne = Compagne::findOrFail($id);
        $company = \App\Company::findOrFail($compagne->company_id);

        $response['compagne'] = new CompagneResource($compagne);
        $response['bornes'] = \App\Borne::where('company_id',$compagne->company_id)->get();
        $response['actifbornes'] = $company->ActifBornes()->where('compagne_id','<>', $id)->pluck('borne_id');
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
        return response(CompagneResource::collection(Compagne::get()));
      }else{
        return response(CompagneResource::collection( $user->Company->Compagnes));
      }
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'question' => 'required |max:255 ',
        'company_id' => 'required |max:20 ',
      ],[
        'question.required' => 'question est obligatoire.',
        'question.max' => 'question doit avoir aux max 255 characters.',
        'company_id.required' => 'company_id est obligatoire.',
        'company_id.max' => 'company_id doit avoir aux max 20 characters.',
      ]);

        $compagnes = Compagne::create($request->all());    
        return $compagnes;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'question' => 'required |max:255 ',
      ],[
        'question.required' => 'question est obligatoire.',
        'question.max' => 'question doit avoir aux max 255 characters.'
      ]);

        $compagne = Compagne::findOrFail($id);
        $user = $request->user();
        if ($user->Role->slug=='superadmin'){
            if($compagne->SelectedBornes){
              $compagne->SelectedBornes()->delete();
            }
            if (count($request->selectedbornes)>0){
              foreach ($request->selectedbornes as $borne_id) {
                
                $compagnebornes = new Compagneborne();
                $compagnebornes->compagne_id = $id;
                $compagnebornes->company_id = $compagne->Company->id;
                $compagnebornes->borne_id = $borne_id;
                
                $compagnebornes->save();
              }
            }
        }
        $input = $request->all();
        $compagne->fill($input)->save();
        return $compagne;
    }
    
    public function delete(Request $request, $id){
        $compagnes = Compagne::findOrFail($id);
        $compagnes->delete();
    }
}
 ?>