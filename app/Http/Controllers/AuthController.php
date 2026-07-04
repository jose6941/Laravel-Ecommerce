<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $usuario = Usuario::where('email', $request->email)->first();

        if (! $usuario || ! Hash::check($request->senha, $usuario->senha)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        $token = $usuario->createToken($request->device_name ?? 'web')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
