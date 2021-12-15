<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResourceSec;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;
use App\Company;


class UserController extends Controller
{
    public function fileImportExport()
    {
       return view('file-import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request) 
    {
        Excel::import(new UsersImport, $request->file('file')->store('temp'));
        return back();
    }


    public function UsersByCompany(Request $request, $company_id){
        $company = Company::find($company_id);
        $users = $company->Users;
        if ($users){
            return response(['status' => true, 'users'=> UserResourceSec::collection($users)]);
            return response(['status' => true, 'users'=> []]);
        }

    }
    public function UsersCompany(Request $request){
        $user = $request->user();
        if ($user->Role->slug=='admin'){
            return response(['status' => true, 'users' => UserResourceSec::collection($user->Company->Users)]); 
        }else{
            return response(['status' => true, 'users' => []]); 
        }
    }
    
    public function getSingleUser(Request $request, $id){
        $user= User::find($id);
        $companies = Company::all();
        if ($user){
            return response(['status' => true, 'user' => new UserResourceSec($user),
                                        'companies' => $companies]);
        }else{
            return response(['status' => false, 'msg' => 'utilisateur non trouvé']);
        }
    }
    public function getUser(Request $request){
        // dd($request->all());
        $user = Auth::user() ?? Auth::guard("api")->user();
        // $user = User::findOrfail(Auth::user()->id);
        if ($user){
            return response(['status' => true, 'user' =>  new UserResourceSec($user)]);
            
        }else{
            return response(['status' => false, 'user' =>  null]);
        }
    }
    public function all(Request $request){
        // dd($request->all());
        $user = Auth::user() ?? Auth::guard("api")->user();
        $users = User::all();
        if ($users){
            return response(['status' => true, 'users' =>  UserResourceSec::collection($users)]);
            
        }else{
            return response(['status' => false, 'users' =>  []]);
        }
    }

    public function editSingleUser(Request $request){
        if ($request->user()->Role->slug=="superadmin"){
            $validator = Validator::make($request->all(), [
                'nom' => 'required|min:3',
                'prenom' => 'required',
                'email' => 'required|email',
                'company_id' => 'required',
                ]);
            
            if ($validator->fails()){
                return response()->json( ["status" => false, "errors" => $validator->errors() ] );
            }
            $user = User::find($request->id);
            if ($user){
                $user->nom = $request->nom;
                $user->prenom = $request->prenom;
                $user->name = $request->nom . ' ' . $request->prenom;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->adress = $request->adress;
                $user->sexe = $request->sexe;
                $user->fonction = $request->fonction;
                $user->role_id = $request->role_id;
                $user->company_id = $request->company_id;
                // $user->birthday = $request->birthday;
                // $user->postal_code = $request->postal_code;
                if (!is_null($request->active)){
                    $user->active = $request->active==true? true : false;
                    // dd($employe->active);
                }
                try{
                    $user->save();
                }catch(Exception $e){
                    return response()->json( ["status" => false, "msg" => $e->getMessage() ]);
                }
                return response()->json( ["status" => true, "user" => new UserResourceSec($user) ]);
            }else{
                return response()->json( ["status" => false, "msg" => "utilisateur n'existe pas" ]);    
            }
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }
    public function editSingleComanyUser(Request $request){
        if ($request->user()->Role->slug=="admin"){
            $validator = Validator::make($request->all(), [
                'nom' => 'required|min:3',
                'prenom' => 'required',
                'email' => 'required|email',
                ]);
            
            if ($validator->fails()){
                return response()->json( ["status" => false, "errors" => $validator->errors() ] );
            }
            $user = User::find($request->id);
            if ($user){
                if ($user->Company->id==$request->user()->Company->id){
                    $user->nom = $request->nom;
                    $user->prenom = $request->prenom;
                    $user->phone = $request->phone;
                    $user->email = $request->email;
                    $user->adress = $request->adress;
                    $user->sexe = $request->sexe;
                    $user->fonction = $request->fonction;
                    $user->role_id = $request->role_id;
                    // $user->birthday = $request->birthday;
                    // $user->postal_code = $request->postal_code;
                    if (!is_null($request->active)){
                        $user->active = $request->active==true? true : false;
                        // dd($employe->active);
                    }
                    try{
                        $user->save();
                    }catch(Exception $e){
                        return response()->json( ["status" => false, "msg" => $e->getMessage() ]);
                    }
                    return response()->json( ["status" => true, "user" => new UserResourceSec($user) ]);
                }else{
                    return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);   
                }
            }else{
                return response()->json( ["status" => false, "msg" => "utilisateur n'existe pas" ]);    
            }
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }
    
    public function changePassword(Request $request){
        // dd($request->all());
        if ($request->user()->Role->slug=="superadmin"){
            $user = User::find($request->user_id);
            if ($user){
                if ($request->password==$request->confirm){
                    $user->password = Hash::make($request->password);
                }
                try{
                    $user->save();
                }catch(Exception $e){
                    return response()->json( ["status" => false, "msg" => $e->getMessage() ]);
                }
                return response()->json( ["status" => true, "user" => new UserResourceSec($user) ]);
            }else{
                return response()->json( ["status" => false, "msg" => "utilisateur n'existe pas" ]);    
            }
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }
    
    public function updateAuthUserPassword(Request $request)
    {
        $user = $request->user();
        if ($user->id==$request->user_id){
            $validator = Validator::make($request->all(), [
                'current' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required'
                ]);
            if ($validator->fails()){
                return response()->json( [ "succes" => false, "errors" => $validator->errors()] );
            }
            if (!Hash::check($request->current, $user->password)) {
                return response()->json(['succes' => false, 'errors' => ['current'=> ['Current password does not match']]]);
            }
    
            $user->password = Hash::make($request->password);
            $user->save();
    
            return response()->json(['succes' => true, 'msg' => 'Password updated succussful', 'user' =>  new UserResourceSec($user)]);
        }
    }
    
    public function adduserCompany(Request $request){
        if ($request->user()->Role->slug=="admin"){
            $validator = Validator::make($request->all(), [
                'nom' => 'required|min:3',
                'prenom' => 'required',
                'email' => 'required|email|unique:users',
                ]);
            
            if ($validator->fails()){
                return response()->json( ["status" => false, "errors" => $validator->errors() ] );
            }
            $user = new  User();
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->name = $request->nom . ' ' . $request->prenom;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->adress = $request->adress;
            $user->sexe = $request->sexe;
            $user->fonction = $request->fonction;
            $user->role_id = $request->role_id;
            $user->company_id = $request->user()->Company->id;
            if (!is_null($request->active)){
                $user->active = $request->active==true? true : false;
                // dd($employe->active);
            }
            if ($request->password==$request->passwordconfirm){
                $user->password = Hash::make($request->password);
            }
            // $user->birthday = $request->birthday;
            // $user->postal_code = $request->postal_code;
            try{
                $user->save();
            }catch(Exception $e){
                return response()->json( ["status" => false, "msg" => $e->getMessage() ]);
            }
            return response()->json( ["status" => true, "user" => new UserResourceSec($user) ]);
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }   
    }
    public function add(Request $request)
    {
        // dd($request->all());
        if ($request->user()->Role->slug=="superadmin"){
            $validator = Validator::make($request->all(), [
                'nom' => 'required|min:3',
                'prenom' => 'required',
                'company_id' => 'required',
                'email' => 'required|email|unique:users',
                ]);
            
            if ($validator->fails()){
                return response()->json( ["status" => false, "errors" => $validator->errors() ] );
            }
            $user = new  User();
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->name = $request->nom . ' ' . $request->prenom;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->adress = $request->adress;
            $user->sexe = $request->sexe;
            $user->fonction = $request->fonction;
            $user->role_id = $request->role_id;
            $user->company_id = $request->company_id;
            if (!is_null($request->active)){
                $user->active = $request->active==true? true : false;
                // dd($employe->active);
            }
            if ($request->password==$request->passwordconfirm){
                $user->password = Hash::make($request->password);
            }
            // $user->birthday = $request->birthday;
            // $user->postal_code = $request->postal_code;
            try{
                $user->save();
            }catch(Exception $e){
                return response()->json( ["status" => false, "msg" => $e->getMessage() ]);
            }
            return response()->json( ["status" => true, "user" => new UserResourceSec($user) ]);
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }
    
    public function updateMyAvatar(Request $request){
        $user = $request->user();
        if($request->post('avatar')){
            if ($user->avatar){
                $user->avatar->delete();
            }
            $image = $request->post('avatar');
            $media = $user->addMediaFromBase64($image)->toMediaCollection('avatar');
            $user->avatar_id = $media->id;
            $user->save();
            $u = User::find($user->id);

            return response(['status' => true, 'user' =>  new UserResourceSec($u)]);
        }else{
            return response(['status' => false, 'msg' => 'Erreur de requete', 'user' =>  new UserResourceSec($user)]);
        }
    }
    public function updateAvatar(Request $request){
        $user = User::find($request->user_id);
        if($request->post('avatar') && $request->user_id){
            if ($user->avatar){
                $user->avatar->delete();
            }
            $image = $request->post('avatar');
            $media = $user->addMediaFromBase64($image)->toMediaCollection('avatar');
            $user->avatar_id = $media->id;
            $user->save();
            $u = User::find($user->id);
            return response(['status' => true, 'user' =>  new UserResourceSec($user)]);
        }else{
            return response(['status' => false, 'msg' => 'Erreur de requete', 'user' =>  new UserResourceSec($user)]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        if ($request->user()->id==$request->id||$request->user()->Role->slug=="superadmin"){
            $user = User::findOrfail($request->id);
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->adress = $request->adress;
            $user->sexe = $request->sexe;
            $user->fonction = $request->fonction;
            
            // $user->birthday = $request->birthday;
            // $user->postal_code = $request->postal_code;
            try{
                $user->update();
            }catch(Exception $e){
                return response()->json( ["status" => false, "msg" => $e->getMessage() ]);
            }
            return response()->json( ["status" => true, "user" => new UserResourceSec($user) ]);
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {   
        if ($request->User()->Role->slug=='superadmin'){
            $user = User::findOrfail($id);
            $user->delete();
            return response()->json(["status" => true, "msg" => "User deleted"]);
        }elseif ($request->User()->Role->slug=='admin'){
            $user = User::findOrfail($id);
            if ($user->Company->id==$request->User()->Company->id){
                $user->delete();
                return response()->json(["status" => true, "msg" => "User deleted"]);
            }
        }else{
            return response()->json( ["status" => false, "msg" => 'Not Allowaed' ]);
        }
    }

    public function rolesList(Request $request)
    {
        $roles = Role::all();
        $companies = Company::all();
        if ($roles){
            return response(["status" => true, "roles" => $roles, 'companies' => $companies]);
        }else{
            return response(["status" => false, "roles" => [] ]);
        }
    }
}
