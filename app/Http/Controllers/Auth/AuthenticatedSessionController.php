<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\Login;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $verificacioncode = Str::random(6);

        $user = Auth::user();
        if($user->status==0)
        {
            return redirect()->route('login');
        }
        $user->code = $verificacioncode;
        $user->save();
        Mail::to($user->email)->send(new Login($verificacioncode));

        return redirect()->route('verificacion.show');
    }

    public function verifyshow()
    {
        return Inertia::render('Auth/Verify');
    }




    public function codigo(Request $request)
    {
        $request->validate([
            'code' => 'required|size:6',
        ]);

        $user = User::where('id', Auth::id())
            ->where('code', $request->code)
            ->first();

        if ($user) {
            // El código de verificación es correcto, por lo que iniciamos sesión al usuario
            Auth::login($user);

            // Limpiamos el código de verificación ya que ya no lo necesitamos
            $user->code = null;
            $user->save();

            // Redirigimos al usuario a la página de inicio
            return redirect()->route('dashboard');
        } else {
            // El código de verificación es incorrecto
            return back()->withErrors([
                'verification_code' => 'The verification code is incorrect.',
            ]);
        }
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
