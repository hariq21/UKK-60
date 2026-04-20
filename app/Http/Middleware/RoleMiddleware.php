<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (($user->role ?? null) !== $role) {
            $homeRoute = ($user->role ?? null) === 'admin'
                ? route('admin.dashboard')
                : route('siswa.dashboard');

            return redirect($homeRoute);
        }

        return $next($request);
    }
}
