<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user adalah admin
        if ($request->user() && $request->user()->role === 'admin') {
            // Dapatkan current route name
            $currentRoute = $request->route()->getName();
            
            // Daftar route yang diizinkan untuk admin selain route admin.*
            $allowedRoutes = [
                'logout',
                'chat',
                'user',
                'group',
                'profile.edit',
                'profile.update',
                'profile.destroy',
            ];
            
            // Cek apakah route dimulai dengan 'admin.' atau termasuk dalam allowed routes
            // Jika tidak, redirect ke admin dashboard
            if (!str_starts_with($currentRoute, 'admin.') && !in_array($currentRoute, $allowedRoutes)) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
        }
        
        return $next($request);
    }
}
