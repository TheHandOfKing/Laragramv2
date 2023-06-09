<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsVisible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('slug', $request->route('user.slug'))->firstOrFail();
        if ($user->canViewProfile()) {
            return $next($request);
        }

        return abort(403, 'You do not have permission to view this profile.');
    }
}
