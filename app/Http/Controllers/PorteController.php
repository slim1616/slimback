<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Porte;
use App\Zone;
use App\Http\resources\PorteResources;

class PorteController extends Controller
{
    public function get(Request $request, $id){
      return Porte::findOrFail($id);
    }
    public function portesByZone(Request $request, $zone_id){
      $zone = Zone::find($zone_id);
      return $zone->Portes;
    }
    
    public function list(Request $request){
      return PorteResources::collection(Porte::all());
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'marque' => 'required |max:255 ',
        'ip' => 'required |max:45 ',
        'port' => 'required |max:11 ',
        'zone_id' => 'required |max:20 ',
        'batiment_id' => 'required |max:20 ',
      ],[
        'marque.required' => 'marque est obligatoire.',
        'marque.max' => 'marque doit avoir aux max 255 characters.',
        'ip.required' => 'ip est obligatoire.',
        'ip.max' => 'ip doit avoir aux max 45 characters.',
        'port.required' => 'port est obligatoire.',
        'port.max' => 'port doit avoir aux max 11 characters.',
        'zone_id.required' => 'zone_id est obligatoire.',
        'zone_id.max' => 'zone_id doit avoir aux max 20 characters.',
        'batiment_id.required' => 'batiment_id est obligatoire.',
        'batiment_id.max' => 'batiment_id doit avoir aux max 20 characters.',
      ]);

        $portes = Porte::create($request->all());    
        return $portes;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'marque' => 'required |max:255 ',
        'ip' => 'required |max:45 ',
        'port' => 'required |max:11 ',
        'zone_id' => 'required |max:20 ',
        'batiment_id' => 'required |max:20 ',
      ],[
        'marque.required' => 'marque est obligatoire.',
        'marque.max' => 'marque doit avoir aux max 255 characters.',
        'ip.required' => 'ip est obligatoire.',
        'ip.max' => 'ip doit avoir aux max 45 characters.',
        'port.required' => 'port est obligatoire.',
        'port.max' => 'port doit avoir aux max 11 characters.',
        'zone_id.required' => 'zone_id est obligatoire.',
        'zone_id.max' => 'zone_id doit avoir aux max 20 characters.',
        'batiment_id.required' => 'batiment_id est obligatoire.',
        'batiment_id.max' => 'batiment_id doit avoir aux max 20 characters.',
      ]);

        $portes = Porte::findOrFail($id);
        $input = $request->all();
        $portes->fill($input)->save();
        return $portes;
    }
    
    public function delete(Request $request, $id){
        $portes = Porte::findOrFail($id);
        $portes->delete();
    }
}
 ?>