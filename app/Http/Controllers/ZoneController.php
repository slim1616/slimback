<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zone;
use App\Batiment;
use App\Http\resources\zoneResources;

class ZoneController extends Controller
{

    public function zonesByBatiment(Request $request){
      // dd($request->all());
      $batiment = Batiment::find($request->batiment_id);
      return $batiment->Zones;
    }
    public function get(Request $request, $id){
      return Zone::findOrFail($id);
    }
    
    public function list(Request $request){
      return  zoneResources::collection(Zone::all());
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'batiment_id' => 'required |max:20 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
        'batiment_id.required' => 'batiment_id est obligatoire.',
        'batiment_id.max' => 'batiment_id doit avoir aux max 20 characters.',
      ]);

        $zones = Zone::create($request->all());    
        return $zones;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'batiment_id' => 'required |max:20 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
        'batiment_id.required' => 'batiment_id est obligatoire.',
        'batiment_id.max' => 'batiment_id doit avoir aux max 20 characters.',
      ]);

        $zones = Zone::findOrFail($id);
        $input = $request->all();
        $zones->fill($input)->save();
        return $zones;
    }
    
    public function delete(Request $request, $id){
        $zone = Zone::findOrFail($id);
        if ($zone->Portes->count()>0){
            return response(['status' => false]);
        }
        $zone->delete();
        return response(['status' => true]);
    }
}
 ?>