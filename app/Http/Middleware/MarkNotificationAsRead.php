<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if($request->has('notification_id')) 
        $not_id = $request->query('notification_id');
        if ($not_id) {
            $user = $request->user();
            if ($user) {
                $not = $user->unreadNotifications()->find($not_id);
                if($not) {
                    $not->markAsRead();
                }
            }
        }
        return $next($request);
    }
}
