<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formule;
use App\Http\Resources\FormuleResource;

class FormuleController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['formule'] = new FormuleResource(Formule::findOrFail($id));
                
                        
                        
                        
                        
                        
                        
                        
                
        return response($response);
    }

     public function data(Request $request){
        $response = [];
                
                        
                        
                        
                        
                        
                        
                        
                
        return response($response);
    }
    
    public function list(Request $request){
      return response(FormuleResource::collection(Formule::get()));
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'online' => 'required |max:1 ',
        'price' => 'required ',
        'nbsurvey' => 'required |max:11 ',
        'nbsemplacements' => 'required |max:11 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
        'online.required' => 'online est obligatoire.',
        'online.max' => 'online doit avoir aux max 1 characters.',
        'price.required' => 'price est obligatoire.',
        'nbsurvey.required' => 'nbsurvey est obligatoire.',
        'nbsurvey.max' => 'nbsurvey doit avoir aux max 11 characters.',
        'nbsemplacements.required' => 'nbsemplacements est obligatoire.',
        'nbsemplacements.max' => 'nbsemplacements doit avoir aux max 11 characters.',
      ]);

        $formules = Formule::create($request->all());    
        return $formules;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'online' => 'required |max:1 ',
        'price' => 'required ',
        'nbsurvey' => 'required |max:11 ',
        'nbsemplacements' => 'required |max:11 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
        'online.required' => 'online est obligatoire.',
        'online.max' => 'online doit avoir aux max 1 characters.',
        'price.required' => 'price est obligatoire.',
        'nbsurvey.required' => 'nbsurvey est obligatoire.',
        'nbsurvey.max' => 'nbsurvey doit avoir aux max 11 characters.',
        'nbsemplacements.required' => 'nbsemplacements est obligatoire.',
        'nbsemplacements.max' => 'nbsemplacements doit avoir aux max 11 characters.',
      ]);

        $formules = Formule::findOrFail($id);
        $input = $request->all();
        $formules->fill($input)->save();
        return $formules;
    }
    
    public function delete(Request $request, $id){
        $formules = Formule::findOrFail($id);
        $formules->delete();
    }
}
 ?>