<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departement;

class DepartementController extends Controller
{
    public function get(Request $request, $id){
      return Departement::findOrFail($id);
    }
    
    public function list(Request $request){
      return Departement::get();
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);

        $departements = Departement::create($request->all());    
        return $departements;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);

        $departements = Departement::findOrFail($id);
        $input = $request->all();
        $departements->fill($input)->save();
        return $departements;
    }
    
    public function delete(Request $request, $id){
        $departements = Departement::findOrFail($id);
        $departements->delete();
    }
}
 ?>