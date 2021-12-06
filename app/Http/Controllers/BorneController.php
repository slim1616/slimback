<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borne;
use App\Http\Resources\BorneResource;

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
        $input = $request->all();
        $bornes->fill($input)->save();
        return $bornes;
    }
    
    public function delete(Request $request, $id){
        $bornes = Borne::findOrFail($id);
        $bornes->delete();
    }
}
 ?>