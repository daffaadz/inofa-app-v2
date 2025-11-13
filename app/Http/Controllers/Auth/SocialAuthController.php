<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback($driver)
    {
        $socialUser = Socialite::driver($driver)->stateless()->user();

        // 1. Cari user berdasarkan provider + provider_id
        $user = User::where('provider', $driver)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        // 2. Jika belum ada, coba match via email
        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        // 3. Buat user baru kalau memang belum ada
        if (!$user) {
            $user = User::create([
                'name'        => $socialUser->getName(),
                'email'       => $socialUser->getEmail(),
                'provider'    => $driver,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
                'password'    => bcrypt(Str::random(24)),
            ]);
            // user baru → belum punya role → akan diarahkan ke select-role
        } else {
            // 4. User lama: attach social credential jika kosong
            if (!$user->provider) {
                $user->update([
                    'provider'    => $driver,
                    'provider_id' => $socialUser->getId(),
                    'avatar'      => $socialUser->getAvatar(),
                ]);
            }
        }

        // 5. Login
        Auth::login($user);

        // 6. Redirect berdasarkan "kelengkapan registrasi"
        return $this->redirectBasedOnRegistration($user);
    }

    /**
     * Tentukan redirect setelah login social
     */
    private function redirectBasedOnRegistration(User $user)
    {
        // Jika belum punya role → wajib pilih role
        if (!$user->role) {
            return redirect()->route('select-role');
        }

        if ($user->role === 'developer' && !$user->developerProfile) {
            return redirect()->route('developer.information');
        }

        // Sudah lengkap → langsung dashboard sesuai role
        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'developer'=> redirect()->route('developer.dashboard'),
            default    => redirect()->route('consumer.dashboard'),
        };
    }
}