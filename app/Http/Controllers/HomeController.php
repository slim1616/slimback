<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function accueil()
    {
        $formules = Formule::where('online',1)->get();
        return view('home.accueil', compact('formules'));
    }
    public function passEnquete(Request $request, $enquete_id){
        return view('enquete.passexam', compact('enquete_id'));
    }
    
}
