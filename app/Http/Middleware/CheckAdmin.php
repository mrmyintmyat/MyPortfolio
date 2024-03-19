<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $is_token = \DB::table('admintokens')->where('id', Auth::user()->user_token)->exists();
        // if (Auth::user()->status == 0) {
        //     Auth::logout();
        //     // Log::info(Auth::user()->status);
        //     return redirect('/login')->withErrors(['lock' => 'Your account is locked']);
        // } else if (Auth::user()->status == 'adminzynn' && Auth::user()->user_token && $is_token) {
        //     return $next($request);
        // }

        // return redirect('myintmyat.dev');
        $user = Auth::user();

        if (Auth::check()) {
            $is_token = \DB::table('admintokens')
                ->where('id', $user->user_token)
                ->exists();
            $user->update(['is_logged_in' => true]);
            if ($user && $user->user_token == 3) {
                $user->update(['is_logged_in' => false]);
                Auth::logout();
                return redirect('/login')->withErrors(['lock' => 'Your account is locked']);
            } elseif ($user && !$user->hasVerifiedEmail()) {
                return redirect('/email/verify');
            } elseif (($user->status == 'admin' || $user->status == 'adminzynn') && $user->user_token && $is_token) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
