<?php

namespace App\Http\Controllers;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use App\Abonnement;
use App\Company;
use App\Emplacement;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider){
        $getInfo = Socialite::driver($provider)->user();
        // dd($getInfo->getAvatar());
        

    $user = User::where('provider', $provider)->where('provider_id', $getInfo->id)->first();
    if ($user){
    }else{
        $userwithemail = User::where('email', $getInfo->getEmail())->first();
        if ($userwithemail){
            
            return redirect('login')->with("error","The email ". $getInfo->getEmail() ." is alerady exist");
            // dd($userwithemail->name);
        }
        $user = $this->createUser($getInfo,$provider);
    }
    auth()->login($user);
    return redirect( route('home') );    
    
    }

    function createUser($getInfo,$provider){

        // dd(str_replace('s96', '',  $getInfo->avatar));
        
        // dd($getInfo->name);
        $spacepos = stripos($getInfo->name, " ");
        $nameuser = substr($getInfo->name,0, $spacepos);
        $firstname = substr($getInfo->name, $spacepos+1);

        if ($provider=='google'){
            $avatarUrl = str_replace('s96', '',  $getInfo->getAvatar());
        }else{
            $avatarUrl = $getInfo->getAvatar();
        }
        // dd($avatarUrl);
        $nickname = $getInfo->getNickname();
        $name = $getInfo->getName();
        if (strpos($getInfo->email, '@')){
            $email = $getInfo->getEmail();
        }else{
            $email = $getInfo->id . '@' . $provider  . '.com';
        }
        
    $user = User::where('provider_id', $getInfo->id)->first();
    if (is_null($user)) {
            try {
                $user = User::create([
                    'name'     => str_replace(" ","_", $name) . time(),
                    'nameuser'     => $nameuser,
                    'firstname'     => $firstname,
                    'email'    => $email,
                    'provider' => $provider,
                    'provider_id' => $getInfo->id,
                ]);
            
            }catch (\Exception $e){

                // dd($e->getMessage());
                return view('auth.login')->with('error','Property is updated .');
                // Log::info('Social login ' . $name . ' ' . $e->getMessage());
            }
    }
        if ($user) {
            try{
                // $media = $user->addMediaFromUrl($avatarUrl)->toMediaCollection('avatar');
                // $user->avatar_id = $media->id;
                $user->save();
            }catch (\Exception $e){
                Log::info('Social login ' . $name . ' ' . $e->getMessage());
                return $user;
            }
        }
        $company = new Company();
        $company->title = $nameuser;
        $company->type = 'Personnel';
        $company->user_id = $user->id;
        $company->save();
        $emplacement = Emplacement::create(['title' => 'Siège '.$company->title , 'company_id' => $company->id, 'user_id' => $user->id]);
        $user->company_id = $company->id;
        $user->save();
        $abonnement = new Abonnement ();
        $abonnement->formule_id = 1;
        $abonnement->company_id = $company->id;
        $abonnement->user_id = $user->id;
        $abonnement->save();
        return $user;
    }

}
