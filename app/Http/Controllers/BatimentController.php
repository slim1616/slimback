<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batiment;
use App\Http\Resources\BatimentsResource;

class BatimentController extends Controller
{
    public function get(Request $request, $id){
      return Batiment::findOrFail($id);
    }
    
    public function list(Request $request){
      return Batiment::get();
    }

    public function all(Request $request){
      return BatimentsResource::collection(Batiment::get());
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);

        $batiments = Batiment::create($request->all());    
        return $batiments;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
      ]);

        $batiments = Batiment::findOrFail($id);
        $input = $request->all();
        $batiments->fill($input)->save();
        return $batiments;
    }
    
    public function delete(Request $request, $id){
        $batiments = Batiment::findOrFail($id);
        if ($batiments->Zones->count()>0){
            return response(['status' => false]);
        }
        $batiments->delete();
        return response(['status' => true]);
    }
}
 ?>