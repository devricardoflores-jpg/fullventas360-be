<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Support\Facades\Log;

use OpenApi\Attributes as OA;

class AuthController extends Controller
{
     #[OA\Post(
        path: '/api/login',
        tags: ['Autenticación'],
        summary: 'Iniciar sesión',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'admin@gmail.com'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        example: '123456'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login correcto'
            ),
            new OA\Response(
                response: 401,
                description: 'Credenciales incorrectas'
            )
        ]
    )]
   
    public function login(Request $request)
{
    Log::info('AUTH - Inicio login', [
        'email' => $request->email
    ]);

    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validator->fails()) {

        Log::warning('AUTH - Error validación login', [
            'errors' => $validator->errors()
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Errores de validación',
            'errors' => $validator->errors()
        ], 422);
    }

    if (!Auth::attempt($request->only('email', 'password'))) {

        Log::warning('AUTH - Credenciales incorrectas', [
            'email' => $request->email
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $user = User::where('email', $request->email)->first();

    Log::info('AUTH - Usuario autenticado', [
        'user_id' => $user->id,
        'email' => $user->email
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    Log::info('AUTH - Token generado', [
        'user_id' => $user->id
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Login correcto',
        'token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ]);
}
}
