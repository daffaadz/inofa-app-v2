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
        // Jika bukan admin, skip middleware
        if (!$request->user() || $request->user()->role !== 'admin') {
            return $next($request);
        }
        
        // ============================================
        // PATH-BASED EXCEPTIONS (Prioritas Tertinggi)
        // ============================================
        // Langsung izinkan path-path penting tanpa cek route name
        
        $allowedPaths = [
            'broadcasting/auth',     // Pusher authentication
            'broadcasting/*',        // Semua broadcasting endpoints
            'chatify',              // Chatify home
            'chatify/*',            // Semua chatify endpoints
            'api/*',                // API endpoints
        ];
        
        foreach ($allowedPaths as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }
        
        // ============================================
        // ROUTE NAME-BASED EXCEPTIONS
        // ============================================
        
        $currentRoute = $request->route() ? $request->route()->getName() : null;
        
        // Jika route belum di-resolve (null), izinkan
        if (!$currentRoute) {
            return $next($request);
        }
        
        // Route prefixes yang diizinkan
        $allowedPrefixes = [
            'admin.',      // Semua route admin
            'chatify.',    // Semua route chatify (jika ada yang named)
        ];
        
        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($currentRoute, $prefix)) {
                return $next($request);
            }
        }
        
        // Route spesifik yang diizinkan
        $allowedRoutes = [
            'logout',
            'chat',
            'user',
            'group',
            'profile.edit',
            'profile.update',
            'profile.destroy',
        ];
        
        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }
        
        // ============================================
        // REDIRECT KE ADMIN DASHBOARD
        // ============================================
        
        return redirect()->route('admin.dashboard')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
