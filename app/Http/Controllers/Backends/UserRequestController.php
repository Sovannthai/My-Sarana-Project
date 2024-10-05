<?php

namespace App\Http\Controllers\Backends;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRequestController extends Controller
{
    public function index()
    {
        $user_requests = Message::select('messages.user_id', 'messages.first_name', 'messages.username', 'users.avatar')
            ->join('users', 'users.telegram_id', '=', 'messages.user_id')
            ->groupBy('messages.user_id', 'messages.first_name', 'messages.username', 'users.avatar')
            ->get();
        return view('backends.request.index',compact('user_requests'));
    }
}
