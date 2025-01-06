<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SajReporterType;

class UserProfileController extends Controller
{
    //
    /**
     */
    public function index(){
        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }
        $reporter_types = SajReporterType::get();

        return view('profile',compact(
            'user',
            'reporter_types',
        ));
    }
 
}
