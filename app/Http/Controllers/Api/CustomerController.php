<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "clientes",
    description: "CRUD de Clientes"
)]


class CustomerController extends Controller
{
     #[OA\Get(
        path: "/clientes",
        summary: "Listar clientes",
            tags: ["Clientes"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de clientes"
            )
        ]
    )]
    public function index()
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'CUSTOMER - Listar clientes'
        ]);

        $customers = Customer::all();

        return response()->json([
            'success' => true,
            'data' => $customers
        ], 200);
    }

    #[OA\Post(
        path: "/clientes",
        summary: "Registrar cliente",
        tags: ["Clientes"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    "ruc",
                    "name",
                    "email",
                    "phone",
                    "address",
                    "photo",
                    "status"
                ],
                properties: [
                    new OA\Property(property: "ruc", type: "string", example: "20111111111"),
                    new OA\Property(property: "name", type: "string", example: "CLIENTE LIMA"),
                    new OA\Property(property: "email", type: "string", example: "cliente@gmail.com"),
                    new OA\Property(property: "phone", type: "string", example: "999999999"),
                    new OA\Property(property: "address", type: "string", example: "LIMA"),
                    new OA\Property(property: "photo", type: "string", example: "default.png"),
                    new OA\Property(property: "status", type: "string", example: "ACTIVO")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Cliente registrado"
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
            'message' => 'CUSTOMER - Registrar cliente',
            'request' => $request->all()
        ]);

        $request->validate([
            'ruc' => 'required|max:20',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'photo' => 'required|max:255',
            'status' => 'required|max:255'
        ]);

        $customer = Customer::create([
            'ruc' => $request->ruc,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $request->photo,
            'status' => $request->status,
            'created_at' => time(),
            'update_at' => time()
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'CUSTOMER - Cliente registrado',
            'id' => $customer->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado correctamente',
            'data' => $customer
        ], 201);
    }

    #[OA\Get(
        path: "/clientes/{id}",
        summary: "Obtener cliente",
        tags: ["Clientes"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID cliente",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Detalle cliente"
            ),
            new OA\Response(
                response: 404,
                description: "Cliente no encontrado"
            )
        ]
    )]
    public function show(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'CUSTOMER - Obtener cliente',
            'id' => $id
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ], 200);
    }

  #[OA\Put(
    path: "/clientes/{id}",
    summary: "Actualizar cliente",
    tags: ["Clientes"],

    parameters: [
        new OA\Parameter(
            name: "id",
            description: "ID del cliente",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],

    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["ruc", "name", "email", "phone", "address", "photo", "status"],
            properties: [
                new OA\Property(property: "ruc", type: "string"),
                new OA\Property(property: "name", type: "string"),
                new OA\Property(property: "email", type: "string"),
                new OA\Property(property: "phone", type: "string"),
                new OA\Property(property: "address", type: "string"),
                new OA\Property(property: "photo", type: "string"),
                new OA\Property(property: "status", type: "string")
            ]
        )
    ),

    responses: [
        new OA\Response(
            response: 200,
            description: "Cliente actualizado correctamente"
        ),
        new OA\Response(
            response: 404,
            description: "Cliente no encontrado"
        ),
        new OA\Response(
            response: 422,
            description: "Errores de validación"
        )
    ]
)]
    public function update(Request $request, string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'CUSTOMER - Actualizar cliente',
            'id' => $id
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        $request->validate([
            'ruc' => 'required|max:20',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'photo' => 'required|max:255',
            'status' => 'required|max:255'
        ]);

        $customer->update([
            'ruc' => $request->ruc,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $request->photo,
            'status' => $request->status,
            'update_at' => time()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'data' => $customer
        ], 200);
    }

   #[OA\Delete(
    path: "/clientes/{id}",
    summary: "Eliminar cliente",
    tags: ["Clientes"],

    parameters: [
        new OA\Parameter(
            name: "id",
            description: "ID del cliente",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],

    responses: [
        new OA\Response(
            response: 200,
            description: "Cliente eliminado correctamente"
        ),
        new OA\Response(
            response: 404,
            description: "Cliente no encontrado"
        )
    ]
)]
    public function destroy(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'CUSTOMER - Eliminar cliente',
            'id' => $id
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado correctamente'
        ], 200);
    }
}
