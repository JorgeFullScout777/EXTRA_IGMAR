<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Mail\ActiveMail;
use Illuminate\Support\Facades\URL;

class RegisteredUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['active']]);
    }
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        $signed_route = URL::temporarySignedRoute(
            'active',
            now()->addMinutes(15),
            ['user'=>$user->id]
        );

        Mail::to($user->email)->send(new ActiveMail($signed_route,$user->name));
        return response()->json([
            'msg'   =>  "Usuario registrado correctamente, revisa tu correo",
            'data'  =>  $user
        ],201);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }

    public function active(User $user){
        if($user){
            $user->status = true;
            $user->save();
            return view('mails.activado');
        }
        return response()->json("No se encontro usuario",404);
    }
}
