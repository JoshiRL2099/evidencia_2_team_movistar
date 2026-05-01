<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $user->loadMissing('role');

        $userRole = strtoupper(trim($user->role->name ?? ''));

        if ($userRole === 'ADMIN') {
            return $next($request);
        }

        $allowedRoles = array_map(
            fn($role) => strtoupper(trim($role)),
            $roles
        );

        if (in_array($userRole, $allowedRoles, true)) {
            return $next($request);
        }

        dd([
            'usuario' => $user->username,
            'rol_en_bd' => $user->role->name ?? null,
            'rol_normalizado' => $userRole,
            'roles_permitidos' => $allowedRoles,
        ]);
    }
}