<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Jika user adalah admin, gunakan admin layout
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('layouts.admin');
        }
        
        // Untuk user biasa (customer/developer) gunakan app layout
        return view('layouts.app');
    }
}
