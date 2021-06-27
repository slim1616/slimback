<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use App\User;

class LoginController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(1);
		// dd($this->client);
	}

    public function login(Request $request){

    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required'
    	]);
        return $this->issueToken($request, 'password');

	}
	

    public function refresh(Request $request){
    	$this->validate($request, [
    		'refresh_token' => 'required'
    	]);

    	return $this->issueToken($request, 'refresh_token');

    }

    public function logout(Request $request){

    	$accessToken = $request->user()->token();

    	DB::table('oauth_refresh_tokens')
    		->where('access_token_id', $accessToken->id)
    		->update(['revoked' => true]);

    	$accessToken->revoke();

    	return response()->json([], 204);

	}
	public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);
        $user = User::where('email', $credentials['email'])->first();
		// dd($user);
		if ($user){
        	Password::sendResetLink($credentials);
        	return response()->json(["status" => true, "msg" => 'Reset password link sent on your email.']);
		}else{
			return response()->json(["status" => false, "msg" => 'Verify your mail adress']);
		}

    }
}
