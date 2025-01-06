<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
//use Config;
use Illuminate\Support\Facades\Config;
use App\Models\SajReporterType;
use App\Models\SajDiscipline;
use App\Models\SajCategory;
use App\Models\SajGender;
use App\Models\SajCircumstance;
use App\Models\SajInjuredBodyPart;
use App\Models\SajSide;
use App\Models\SajInjuryType;
use App\Models\SajExpectedAbsence;
use App\Models\SajWithOrWithout;

use App\Models\SajCourseCondition;
use App\Models\SajTypeOfSnow;
use App\Models\SajWeatherCondition;
use App\Models\SajWindCondition;
use App\Models\SajVideo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }
        $menu = Config::get('menu.homemenu1');
        //ddd($user->role);
        //return view('home', compact('menu'));
        return view('home',
        [
            'user' => $user,
            'menu' => $menu
        ]);
    }

    public function show(){
        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }
        return view('injury', compact('user'));
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // ログアウト後にリダイレクトする先を指定
    }
}
