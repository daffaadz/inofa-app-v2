<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAfterLoginController extends Controller
{
    public function __invoke()
    {
        return match (auth()->user()->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'developer'=> redirect()->route('developer.dashboard'),
            default    => redirect()->route('consumer.dashboard'),
        };
    }
}