<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait{

	public function issueToken(Request $request, $grantType, $scope = ""){

		$params = [
    		'grant_type' => $grantType,
    		'client_id' => $this->client->id,
    		'client_secret' => $this->client->secret,
    		'scope' => $scope
    	];
        if(!in_array($grantType, array('social', 'child'))){
			$params['username'] = $request->username ?: $request->email;
			if(is_numeric($params['username'])){
				$params['phone'] = $params['username'];
				$params['grant_type'] = 'phone';
			} 
        }
		
    	$request->request->add($params);

		$proxy = Request::create('oauth/token', 'POST');
        // dd($proxy);
		
    	return Route::dispatch($proxy);

	}

}
