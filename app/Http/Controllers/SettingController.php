<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    public function get(Request $request){
      return Setting::first();
    }
    
    public function list(Request $request){
      return Setting::get();
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'societe' => 'required |max:255 ',
        'mail_driver' => 'required |max:255 ',
        'mail_host' => 'required |max:255 ',
        'mail_port' => 'required |max:255 ',
        'mail_username' => 'required |max:255 ',
        'mail_password' => 'required |max:255 ',
        'mail_encrypt' => 'required |max:255 ',
        'from_address' => 'required |max:255 ',
        'from_name' => 'required |max:255 ',
      ],[
        'societe.required' => 'societe est obligatoire.',
        'societe.max' => 'societe doit avoir aux max 255 characters.',
        'mail_driver.required' => 'mail_driver est obligatoire.',
        'mail_driver.max' => 'mail_driver doit avoir aux max 255 characters.',
        'mail_host.required' => 'mail_host est obligatoire.',
        'mail_host.max' => 'mail_host doit avoir aux max 255 characters.',
        'mail_port.required' => 'mail_port est obligatoire.',
        'mail_port.max' => 'mail_port doit avoir aux max 255 characters.',
        'mail_username.required' => 'mail_username est obligatoire.',
        'mail_username.max' => 'mail_username doit avoir aux max 255 characters.',
        'mail_password.required' => 'mail_password est obligatoire.',
        'mail_password.max' => 'mail_password doit avoir aux max 255 characters.',
        'mail_encrypt.required' => 'mail_encrypt est obligatoire.',
        'mail_encrypt.max' => 'mail_encrypt doit avoir aux max 255 characters.',
        'from_address.required' => 'from_address est obligatoire.',
        'from_address.max' => 'from_address doit avoir aux max 255 characters.',
        'from_name.required' => 'from_name est obligatoire.',
        'from_name.max' => 'from_name doit avoir aux max 255 characters.',
      ]);

        $settings = Setting::create($request->all());    
        return $settings;
    }
    
    public function update(Request $request){
      
      $validatedData = $request->validate([
        'societe' => 'required |max:255 ',
        'mail_driver' => 'required |max:255 ',
        'mail_host' => 'required |max:255 ',
        'mail_port' => 'required |max:255 ',
        'mail_username' => 'required |max:255 ',
        'mail_password' => 'required |max:255 ',
        'mail_encrypt' => 'required |max:255 ',
        'from_address' => 'required |max:255 ',
        'from_name' => 'required |max:255 ',
      ],[
        'societe.required' => 'societe est obligatoire.',
        'societe.max' => 'societe doit avoir aux max 255 characters.',
        'mail_driver.required' => 'mail_driver est obligatoire.',
        'mail_driver.max' => 'mail_driver doit avoir aux max 255 characters.',
        'mail_host.required' => 'mail_host est obligatoire.',
        'mail_host.max' => 'mail_host doit avoir aux max 255 characters.',
        'mail_port.required' => 'mail_port est obligatoire.',
        'mail_port.max' => 'mail_port doit avoir aux max 255 characters.',
        'mail_username.required' => 'mail_username est obligatoire.',
        'mail_username.max' => 'mail_username doit avoir aux max 255 characters.',
        'mail_password.required' => 'mail_password est obligatoire.',
        'mail_password.max' => 'mail_password doit avoir aux max 255 characters.',
        'mail_encrypt.required' => 'mail_encrypt est obligatoire.',
        'mail_encrypt.max' => 'mail_encrypt doit avoir aux max 255 characters.',
        'from_address.required' => 'from_address est obligatoire.',
        'from_address.max' => 'from_address doit avoir aux max 255 characters.',
        'from_name.required' => 'from_name est obligatoire.',
        'from_name.max' => 'from_name doit avoir aux max 255 characters.',
      ]);

        $settings = Setting::first();
        $input = $request->all();
        $settings->fill($input)->save();
        return $settings;
    }
    
    public function delete(Request $request, $id){
        $settings = Setting::findOrFail($id);
        $settings->delete();
    }
}
 ?>