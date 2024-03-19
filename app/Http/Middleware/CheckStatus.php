<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (Auth::check()) {
            $is_token = \DB::table('admintokens')
                ->where('id', $user->user_token)
                ->exists();

            $user->update(['is_logged_in' => true]);
        }

        if ($user && $user->user_token == 3) {
            $user->update(['is_logged_in' => false]);
            Auth::logout();
            return redirect('/login')->withErrors(['lock' => 'Your account is locked']);
        }elseif ($user && $user->status == "guest") {
            return redirect("/profile?show_update_form=true")->withErrors(['update_email' => 'Please update and verify your email address before proceeding.']);
        }elseif ($user && !$user->hasVerifiedEmail()) {
            return redirect('/email/verify');
        } else {
            return $next($request);
        }

        return redirect('/');
    }
}
