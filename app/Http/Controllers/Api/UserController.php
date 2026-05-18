<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Users",
    description: "CRUD de Usuarios"
)]

class UserController extends Controller
{
     #[OA\Get(
        path: "/users",
        summary: "Listar usuarios",
        tags: ["Users"],

        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de usuarios"
            )
        ]
    )]
    public function index()
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Listar usuarios'
        ]);

        $users = User::with('role')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
    }

    #[OA\Post(
        path: "/users",
        summary: "Registrar usuario",
        tags: ["Users"],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name","email","password","phone","adress","photo","role_id"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "RICARDO"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        example: "ricardo@gmail.com"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        example: "123456"
                    ),
                    new OA\Property(
                        property: "phone",
                        type: "string",
                        example: "999999999"
                    ),
                    new OA\Property(
                        property: "adress",
                        type: "string",
                        example: "LIMA"
                    ),
                    new OA\Property(
                        property: "photo",
                        type: "string",
                        example: "default.png"
                    ),
                    new OA\Property(
                        property: "role_id",
                        type: "integer",
                        example: 1
                    )
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Usuario registrado"
            ),
            new OA\Response(
                response: 422,
                description: "Errores de validación"
            )
        ]
    )]
    public function store(Request $request)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Registrar usuario',
            'request' => $request->all()
        ]);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|max:255',
            'adress' => 'required|max:255',
            'photo' => 'required|max:255',
            'role_id' => 'required|integer'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'adress' => $request->adress,
            'photo' => $request->photo,
            'role_id' => $request->role_id,
            'created_at' => time(),
            'update_at' => time()
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Usuario registrado',
            'id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado correctamente',
            'data' => $user
        ], 201);
    }

    #[OA\Get(
        path: "/users/{id}",
        summary: "Obtener usuario",
        tags: ["Users"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID usuario",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Detalle usuario"
            ),
            new OA\Response(
                response: 404,
                description: "Usuario no encontrado"
            )
        ]
    )]
    public function show(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Obtener usuario',
            'id' => $id
        ]);

        $user = User::with('role')->find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    #[OA\Put(
        path: "/users/{id}",
        summary: "Actualizar usuario",
        tags: ["Users"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID usuario",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name","email","phone","adress","photo","role_id"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "email", type: "string"),
                    new OA\Property(property: "phone", type: "string"),
                    new OA\Property(property: "adress", type: "string"),
                    new OA\Property(property: "photo", type: "string"),
                    new OA\Property(property: "role_id", type: "integer")
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 200,
                description: "Usuario actualizado"
            ),
            new OA\Response(
                response: 404,
                description: "Usuario no encontrado"
            )
        ]
    )]
    public function update(Request $request, string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Actualizar usuario',
            'id' => $id,
            'request' => $request->all()
        ]);

        $user = User::find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|max:255',
            'adress' => 'required|max:255',
            'photo' => 'required|max:255',
            'role_id' => 'required|integer'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'adress' => $request->adress,
            'photo' => $request->photo,
            'role_id' => $request->role_id,
            'update_at' => time()
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Usuario actualizado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $user
        ], 200);
    }

    #[OA\Delete(
        path: "/users/{id}",
        summary: "Eliminar usuario",
        tags: ["Users"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID usuario",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Usuario eliminado"
            ),
            new OA\Response(
                response: 404,
                description: "Usuario no encontrado"
            )
        ]
    )]
    public function destroy(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Eliminar usuario',
            'id' => $id
        ]);

        $user = User::find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $user->delete();

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'USER - Usuario eliminado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }
}
