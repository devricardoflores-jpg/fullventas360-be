<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Supplier;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "proveedores",
    description: "CRUD de Proveedores"
)]

class SupplierController extends Controller
{
    

 #[OA\Get(
        path: "/proveedores",
        summary: "Listar proveedores",
        tags: ["Suppliers"],

        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de proveedores"
            )
        ]
    )]
    public function index()
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'SUPPLIER - Listar proveedores'
        ]);

        $suppliers = Supplier::all();

        return response()->json([
            'success' => true,
            'data' => $suppliers
        ], 200);
    }

    #[OA\Post(
        path: "/proveedores",
        summary: "Registrar proveedor",
        tags: ["Suppliers"],

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
                    new OA\Property(
                        property: "ruc",
                        type: "string",
                        example: "20111111111"
                    ),
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "GLORIA SAC"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        example: "gloria@gmail.com"
                    ),
                    new OA\Property(
                        property: "phone",
                        type: "string",
                        example: "999999999"
                    ),
                    new OA\Property(
                        property: "address",
                        type: "string",
                        example: "LIMA"
                    ),
                    new OA\Property(
                        property: "photo",
                        type: "string",
                        example: "default.png"
                    ),
                    new OA\Property(
                        property: "status",
                        type: "string",
                        example: "ACTIVO"
                    )
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Proveedor registrado"
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
            'message' => 'SUPPLIER - Registrar proveedor',
            'request' => $request->all()
        ]);

        $request->validate([
            'ruc' => 'required|max:20',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'photo' => 'required|max:255',
            'status' => 'required|max:255'
        ]);

        $supplier = Supplier::create([
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
            'message' => 'SUPPLIER - Proveedor registrado',
            'id' => $supplier->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor registrado correctamente',
            'data' => $supplier
        ], 201);
    }

    #[OA\Get(
        path: "/proveedores/{id}",
        summary: "Obtener proveedor",
        tags: ["Suppliers"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID proveedor",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Detalle proveedor"
            ),
            new OA\Response(
                response: 404,
                description: "Proveedor no encontrado"
            )
        ]
    )]
    public function show(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'SUPPLIER - Obtener proveedor',
            'id' => $id
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {

            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $supplier
        ], 200);
    }

    #[OA\Put(
        path: "/proveedores/{id}",
        summary: "Actualizar proveedor",
        tags: ["Suppliers"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID proveedor",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

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
                description: "Proveedor actualizado"
            ),
            new OA\Response(
                response: 404,
                description: "Proveedor no encontrado"
            )
        ]
    )]
    public function update(Request $request, string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'SUPPLIER - Actualizar proveedor',
            'id' => $id,
            'request' => $request->all()
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {

            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        $request->validate([
            'ruc' => 'required|max:20',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $id,
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'photo' => 'required|max:255',
            'status' => 'required|max:255'
        ]);

        $supplier->update([
            'ruc' => $request->ruc,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $request->photo,
            'status' => $request->status,
            'update_at' => time()
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'SUPPLIER - Proveedor actualizado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor actualizado correctamente',
            'data' => $supplier
        ], 200);
    }

    #[OA\Delete(
        path: "/proveedores/{id}",
        summary: "Eliminar proveedor",
        tags: ["Suppliers"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID proveedor",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Proveedor eliminado"
            ),
            new OA\Response(
                response: 404,
                description: "Proveedor no encontrado"
            )
        ]
    )]
    public function destroy(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'SUPPLIER - Eliminar proveedor',
            'id' => $id
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {

            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        $supplier->delete();

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'SUPPLIER - Proveedor eliminado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor eliminado correctamente'
        ], 200);
    }

}
