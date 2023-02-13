<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
class LoginController extends Controller
{

    public function login(Request $request):JsonResponse
  {
    $credentials = $request->validate([
      "email" => ["required", "email"],
      "password" => ["required"],
    ]);

    if (Auth::attempt($credentials)) {
    $request->session()->regenerate();
    return response()->json(Auth::user());
  }
    return Response()->json([],401);
  }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(true);
    }

    public function register(Request $request)
    {
        $user = User::create([
            "name" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        Auth::login($user);
        return response()->json($user, 200);
    }
    public function edit(Request $request, User $user){
        {
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = $request->password;
            return $user->update()
                ?response()->json($user)
                :response()->json([],500);
        }
    }
}
