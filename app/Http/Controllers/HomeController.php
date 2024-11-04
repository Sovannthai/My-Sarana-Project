<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

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
        $total_renters = User::whereHas('roles', function ($q) {
            $q->where('id', 8);
        })->count();
        $total_rooms = Room::count();
        return view('backends.index', compact('total_rooms', 'total_renters'));
    }
}
