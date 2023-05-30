<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = User::with([
            'roles'
        ])->findOrFail(Auth::user()->id);
        $data = [
            'user' => $user,
            'upload_config' => [
                'localUrl' => url('/'),
                'globalUrl' => config('services.aics.database'),
                'serverName' => env('computername'),
            ]
        ];
        return view('home', $data);
    }

   
}
