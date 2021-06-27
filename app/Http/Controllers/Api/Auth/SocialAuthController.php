<?php

namespace App\Http\Controllers\Api\Auth;
use Socialite;
use App\Http\Controllers\Api\Auth\IssueTokenTrait;
use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{

	use IssueTokenTrait;

	private $client;
    protected $socialUser;
	public function __construct(){
		$this->client = Client::find(1);
	}

    public function socialAuth(Request $request){
    	$this->validate($request, [
    		// 'name' => 'required',
    		// 'email' => 'nullable|email',
    		'provider' => 'required|in:facebook,twitter,google,apple',
    		'provider_user_id' => 'required'
    	]);
   
        $user = User::where('provider', $request->provider)->where('provider_id', $request->provider_user_id)->first();
        
    	if($user){
    		//$this->addSocialAccountToUser($request, $user);
    	}else{
            if ($request->email){
                if (strpos($request->email, '@')){
                    $email = $request->email;
                }else{
                    $email = $request->provider_user_id . '@' . $request->provider  . '.com';
                    // $params['email'] = $email;
                // $request->request->add($params);
                }
            }else{
                $email = $request->provider_user_id . '@' . $request->provider  . '.com';

                // $request->request->add($params);
                // dd($request->all());
                
            }
            $user = User::where('email', $email)->first();
            // dd($user);
    		if ($user ){
	    		if ($request->socialpass&&$request->socialpass==''){
	    			return response(["status" => true, "exist" => true, "msg" => "This email is alerady exist, join with this account?"]);
	    		}else{

	    			if (Auth::attempt(['email' => $email, 'password' => $request->socialpass])) {
	    				try{
			                $this->updateUserAccount($request);

			    		}catch(\Exception $e){
			    			return response("An Error Occured, please retry later", 422);
			    		}
					}else{
						return response(["exist" => true, "msg" => "This email is alerady exist and password is set"]);
					}
	    		}
	    	}else{
	    		try{
	                $this->createUserAccount($request, $email);

	    		}catch(\Exception $e){
                    // echo 'Message: ' .$e->getMessage();
	    			return response("An Error Occured, please retry later " . $e->getMessage(), 422);
	    		}
	    	}

    	}

    	return $this->issueToken($request, 'social');
    }

    /**
     * Associate social account to user
     * @param Request $request [description]
     * @param User    $user    [description]
     */
    private function addSocialAccountToUser(Request $request, User $user){

    	$this->validate($request, [
    		'provider' => ['required', Rule::unique('social_accounts')->where(function($query) use ($user) {
    			return $query->where('user_id', $user->id);
    		})],
    		'provider_id' => 'required'
    	]);

    	$user->socialAccounts()->create([
			'provider' => $request->provider,
    		'provider_id' => $request->provider_id
    	]);

    }

    /**
     * Create user accound and Social account
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function createUserAccount(Request $request, $email){
        // dd($request->all());
        // dd($email);
        $spacepos = stripos($request->givenName, " ");
        $nameuser = substr($request->givenName,0,$spacepos);
        $firstname = substr($request->givenName,$spacepos+1);
        $this->socialUser = array(
            'email' => $email,
            'name' => str_replace(" ","_", $request->givenName) . time(),
            'firstname' => $firstname,
            'nameuser' => $nameuser,
            'provider' => $request->provider,
            'provider_id' => $request->provider_user_id
        );

        
        // DB::transaction( function () use ($request){
        $user = User::create($this->socialUser);
        // });
        //$this->addSocialAccountToUser($request, $user);
        if ($request->provider=='google'){
            $avatarUrl = str_replace('s96', '',  $request->avatar);
        }else{
            $avatarUrl = $request->avatar;
        }
        if ($request->avatar){
            $image = $request->post('avatar');
            $media = $user->addMediaFromUrl($avatarUrl)->toMediaCollection('avatar');
            $user->avatar_id = $media->id;
            $user->save();
        }
        // dd($user);
        // return true;

    }

    /**
     * updaate user accound and Social account
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function updateUserAccount(Request $request){


        $user = User::where('email', $request->email)->first();
        $user->provider = $request->provider;
        $user->provider_id = $request->provider_user_id;
        $user->save();

        

        
    }

    public function setSocialPass(Request $request){


        $user = User::find($request->user()->id);
        if ($user){
        	$user->password = bcrypt($request->password);
        	$user->save();
        }
        return response(['status' => true, 'pass' => $request->password]);
      }
}
