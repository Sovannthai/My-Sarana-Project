<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UnreadMessagesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::check()) {
        //     $user = Auth::user();

        //     // Count unread messages for the authenticated user
        //     $unreadCount = $user->messages()->where('is_read', '0')->count();

        //     // Share the unread count with all views
        //     view()->share('unreadMessagesCount', $unreadCount);
        // }
        $unreadCount = Message::where('is_read', '0')->count();
        view()->share('unreadMessagesCount', $unreadCount);
        return $next($request);
    }
}
