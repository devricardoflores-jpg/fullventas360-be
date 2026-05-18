<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Role;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Roles",
    description: "CRUD de Roles"
)]

class RoleController extends Controller
{
   #[OA\Get(
    path: "/roles",
    summary: "Listar roles",
    tags: ["Roles"],

    responses: [
        new OA\Response(
            response: 200,
            description: "Lista de roles"
        )
    ]
)]
    public function index()
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Listar roles'
        ]);

        $roles = Role::all();

        return response()->json([
            'success' => true,
            'data' => $roles
        ], 200);
    }

   #[OA\Post(
    path: "/roles",
    summary: "Registrar rol",
    tags: ["Roles"],

    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "description"],
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "ADMINISTRADOR"
                ),
                new OA\Property(
                    property: "description",
                    type: "string",
                    example: "Acceso total al sistema"
                )
            ]
        )
    ),

    responses: [
        new OA\Response(
            response: 201,
            description: "Rol registrado correctamente"
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
            'message' => 'ROLE - Registrar rol',
            'request' => $request->all()
        ]);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:250'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Rol registrado',
            'id' => $role->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rol registrado correctamente',
            'data' => $role
        ], 201);
    }

   #[OA\Get(
    path: "/roles/{id}",
    summary: "Obtener rol",
    tags: ["Roles"],

    parameters: [
        new OA\Parameter(
            name: "id",
            description: "ID del rol",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],

    responses: [
        new OA\Response(
            response: 200,
            description: "Detalle del rol"
        ),
        new OA\Response(
            response: 404,
            description: "Rol no encontrado"
        )
    ]
)]
    public function show(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Obtener rol',
            'id' => $id
        ]);

        $role = Role::find($id);

        if (!$role) {

            Log::warning(__METHOD__, [
                'file' => __FILE__,
                'line' => __LINE__,
                'message' => 'ROLE - Rol no encontrado',
                'id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $role
        ], 200);
    }

 
#[OA\Put(
    path: "/roles/{id}",
    summary: "Actualizar rol",
    tags: ["Roles"],

    parameters: [
        new OA\Parameter(
            name: "id",
            description: "ID del rol",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],

    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "description"],
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "SUPERVISOR"
                ),
                new OA\Property(
                    property: "description",
                    type: "string",
                    example: "Control y supervisión"
                )
            ]
        )
    ),

    responses: [
        new OA\Response(
            response: 200,
            description: "Rol actualizado correctamente"
        ),
        new OA\Response(
            response: 404,
            description: "Rol no encontrado"
        )
    ]
)]

    public function update(Request $request, string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Actualizar rol',
            'id' => $id
        ]);

        $role = Role::find($id);

        if (!$role) {

            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:250'
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Rol actualizado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente',
            'data' => $role
        ], 200);
    }

#[OA\Delete(
    path: "/roles/{id}",
    summary: "Eliminar rol",
    tags: ["Roles"],

    parameters: [
        new OA\Parameter(
            name: "id",
            description: "ID del rol",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],

    responses: [
        new OA\Response(
            response: 200,
            description: "Rol eliminado correctamente"
        ),
        new OA\Response(
            response: 404,
            description: "Rol no encontrado"
        )
    ]
)]


    public function destroy(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Eliminar rol',
            'id' => $id
        ]);

        $role = Role::find($id);

        if (!$role) {

            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $role->delete();

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'ROLE - Rol eliminado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado correctamente'
        ], 200);
    }
}
