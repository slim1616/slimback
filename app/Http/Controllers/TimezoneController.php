<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timezone;
use App\Http\resources\TimezoneResource;
class TimezoneController extends Controller
{
    public function get(Request $request, $id){
      return new TimezoneResource(Timezone::findOrFail($id));
    }
    
    public function list(Request $request){
      return  TimezoneResource::collection(Timezone::get());
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'titre' => 'required |max:255 ',
        'heure_debut' => 'required ',
        'heure_fin' => 'required ',
        'marge_entree' => 'required |max:11 ',
        'marge_sortie' => 'required |max:11 ',
        'marge_entree_retard' => 'required |max:11 ',
        'marge_sortie_retard' => 'required |max:11 ',

      ],[
        'titre.required' => 'titre est obligatoire.',
        'titre.max' => 'titre doit avoir aux max 255 characters.',
        'heure_debut.required' => 'heure_debut est obligatoire.',
        'heure_fin.required' => 'heure_fin est obligatoire.',
        'marge_entree.required' => 'marge_entree est obligatoire.',
        'marge_entree.max' => 'marge_entree doit avoir aux max 11 characters.',
        'marge_sortie.required' => 'marge_sortie est obligatoire.',
        'marge_sortie.max' => 'marge_sortie doit avoir aux max 11 characters.',
        'marge_entree_retard.required' => 'marge_entree_retard est obligatoire.',
        'marge_entree_retard.max' => 'marge_entree_retard doit avoir aux max 11 characters.',
        'marge_sortie_retard.required' => 'marge_sortie_retard est obligatoire.',
        'marge_sortie_retard.max' => 'marge_sortie_retard doit avoir aux max 11 characters.',

      ]);

        $timezones = Timezone::create($request->all());    
        return $timezones;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'titre' => 'required |max:255 ',
        'heure_debut' => 'required ',
        'heure_fin' => 'required ',
        'marge_entree' => 'required |max:11 ',
        'marge_sortie' => 'required |max:11 ',
        'marge_entree_retard' => 'required |max:11 ',
        'marge_sortie_retard' => 'required |max:11 ',
        'planning' => 'required ',
      ],[
        'titre.required' => 'titre est obligatoire.',
        'titre.max' => 'titre doit avoir aux max 255 characters.',
        'heure_debut.required' => 'heure_debut est obligatoire.',
        'heure_fin.required' => 'heure_fin est obligatoire.',
        'marge_entree.required' => 'marge_entree est obligatoire.',
        'marge_entree.max' => 'marge_entree doit avoir aux max 11 characters.',
        'marge_sortie.required' => 'marge_sortie est obligatoire.',
        'marge_sortie.max' => 'marge_sortie doit avoir aux max 11 characters.',
        'marge_entree_retard.required' => 'marge_entree_retard est obligatoire.',
        'marge_entree_retard.max' => 'marge_entree_retard doit avoir aux max 11 characters.',
        'marge_sortie_retard.required' => 'marge_sortie_retard est obligatoire.',
        'marge_sortie_retard.max' => 'marge_sortie_retard doit avoir aux max 11 characters.',
        'planning.required' => 'planning est obligatoire.',
      ]);

        $timezones = Timezone::findOrFail($id);
        $input = $request->all();
        $timezones->fill($input)->save();
        return $timezones;
    }
    
    public function delete(Request $request, $id){
        $timezones = Timezone::findOrFail($id);
        $timezones->delete();
    }
}
 ?>