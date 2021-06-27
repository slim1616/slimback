<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Laravel\Passport\Client;
use Validator;


class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(1);
    }

    public function register(Request $request){
		if(is_numeric($request->email)){
			$params['phone'] = $request->email;
			$request->request->add($params);
			// dd($request->all());
			$validator = Validator::make($request->all(), [
				'name' => 'required|unique:users',
				'phone' => 'required|unique:users,phone',
				'password' => 'required|min:6'
			]);
			
		}else{
			$validator = Validator::make($request->all(), [
				'name' => 'required|unique:users',
				'email' => 'required|email|unique:users,email',
				'password' => 'required|min:6'
			]);
		}
        if ($validator->fails()){
                return response()->json( [ "succes" => false, "errors" => $validator->errors()] );
            }
		$u = [	'name' => request('name'),
				'nameuser' => request('name'),
				'firstname' => request('name'),
				'type' => request('type'),
				'password' => bcrypt(request('password'))
		];

		if(is_numeric($request->email)){
            $u['phone'] = $request->email;
            $u['email'] = $request->email.'@smelsy.com';
        } elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $u['email'] = $request->email;
		}
		
    	$user = User::create($u);
    	return $this->issueToken($request, 'password');
    }
}
