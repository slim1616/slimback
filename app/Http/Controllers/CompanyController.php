<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
  public function get(Request $request, $id){
    $response = [];
    $bool = false;
    if  ($request->user()->Role->slug=='superadmin'){
      $bool = true;

    }else if  ($request->user()->Role->slug=='admin'){
      if ($request->user()->Company->id==$id){
        $bool = true;
      }else{
        $bool = false;
      }
    }else{
      $bool = false;
    }

    if ($bool==true){
      $response['status'] = true;
      $response['company'] = new CompanyResource(Company::findOrFail($id));
      $response['users'] = \App\User::all();
      return response($response);
    }else{
      $response['company'] = [];
      $response['users'] = [];
      $response['status'] = false;
      $response['msg'] = "Not allowed";
      return response($response);
    }
  }
  
  public function data(Request $request){
    $response = [];
    $response['users'] = \App\User::all();
    return response($response);
  }
  
  public function list(Request $request){
    return response(CompanyResource::collection(Company::get()));
  }
  
  public function create(Request $request){
    
    $validatedData = $request->validate([
      'title' => 'required |max:255 ',
      'type' => 'required ',
      'user_id' => 'required |max:20 ',
    ],[
      'title.required' => 'title est obligatoire.',
      'title.max' => 'title doit avoir aux max 255 characters.',
      'type.required' => 'type est obligatoire.',
      'user_id.required' => 'user_id est obligatoire.',
      'user_id.max' => 'user_id doit avoir aux max 20 characters.',
      ]);
      
      $companies = Company::create($request->all());    
      return $companies;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'title' => 'required |max:255 ',
        'type' => 'required ',
        'user_id' => 'required |max:20 ',
      ],[
        'title.required' => 'title est obligatoire.',
        'title.max' => 'title doit avoir aux max 255 characters.',
        'type.required' => 'type est obligatoire.',
        'user_id.required' => 'user_id est obligatoire.',
        'user_id.max' => 'user_id doit avoir aux max 20 characters.',
        ]);
        $user = $request->User();
        if ($user->Role->slug=='superadmin'){ 
          $companies = Company::findOrFail($id);
          $input = $request->all();
          $companies->fill($input)->save();
          return $companies;
        }elseif ($user->Role->slug=='admin'){
          if ($request->id==$user->Company->id){
            if($request->user_id==$user->id){
              $companies = Company::findOrFail($id);
              $input = $request->all();
              $companies->fill($input)->save();
              return $companies;
            }else{
              return false;
            }
          }else{
            return false;
          }

        }else{
          return false;
        }
      }
      
      public function delete(Request $request, $id){
        $companies = Company::findOrFail($id);
        $companies->delete();
      }
    }
    ?>