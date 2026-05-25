<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\CategorySucursal;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "CategorySucursal",
    description: "CRUD relación categoría sucursal"
)]

class CategorySucursalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTAR
    |--------------------------------------------------------------------------
    */

    #[OA\Get(
        path: "/api/category-sucursal",
        summary: "Listar relaciones categoría sucursal",
        tags: ["CategorySucursal"],

        security: [["bearerAuth" => []]],

        parameters: [

            new OA\Parameter(
                name: "sucursal_id",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer"
                )
            ),

            new OA\Parameter(
                name: "category_id",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer"
                )
            )

        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "OK"
            )

        ]
    )]

    public function index(Request $request)
    {
        try {

            $query = CategorySucursal::with([

                'category',

                'sucursal'

            ]);

            /*
            |--------------------------------------------------------------------------
            | FILTRO CATEGORY
            |--------------------------------------------------------------------------
            */

            if ($request->filled('category_id')) {

                $query->where(

                    'category_id',

                    $request->category_id

                );

            }

            /*
            |--------------------------------------------------------------------------
            | FILTRO SUCURSAL
            |--------------------------------------------------------------------------
            */

            if ($request->filled('sucursal_id')) {

                $query->where(

                    'sucursal_id',

                    $request->sucursal_id

                );

            }

            $data = $query
                ->latest()
                ->get();

            return response()->json([

                'success' => true,

                'data' => $data

            ], 200);

        } catch (\Throwable $e) {

            Log::error(__METHOD__, [

                'message' => $e->getMessage()

            ]);

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTRAR
    |--------------------------------------------------------------------------
    */

    #[OA\Post(
        path: "/api/category-sucursal",
        summary: "Registrar relación categoría sucursal",
        tags: ["CategorySucursal"],

        security: [["bearerAuth" => []]],

        requestBody: new OA\RequestBody(

            required: true,

            content: new OA\JsonContent(

                required: [

                    "category_id",

                    "sucursal_id"

                ],

                properties: [

                    new OA\Property(
                        property: "category_id",
                        type: "integer",
                        example: 1
                    ),

                    new OA\Property(
                        property: "sucursal_id",
                        type: "integer",
                        example: 2
                    )

                ]

            )

        ),

        responses: [

            new OA\Response(
                response: 201,
                description: "Asignación creada"
            ),

            new OA\Response(
                response: 422,
                description: "Error validación"
            )

        ]
    )]

    public function store(Request $request)
    {
        try {

            Log::info(__METHOD__, [

                'message' => 'CATEGORY_SUCURSAL - Registrar',

                'request' => $request->all()

            ]);

            $validated = $request->validate([

                'category_id' =>

                    'required|integer|exists:categories,id',

                'sucursal_id' =>

                    'required|integer|exists:sucursales,id'

            ]);

            /*
            |--------------------------------------------------------------------------
            | VALIDAR DUPLICADO
            |--------------------------------------------------------------------------
            */

            $exists = CategorySucursal::where(

                'category_id',

                $validated['category_id']

            )

            ->where(

                'sucursal_id',

                $validated['sucursal_id']

            )

            ->exists();

            if ($exists) {

                return response()->json([

                    'success' => false,

                    'message' => 'La relación ya existe'

                ], 409);

            }

            $data = CategorySucursal::create([

                'category_id' =>

                    $validated['category_id'],

                'sucursal_id' =>

                    $validated['sucursal_id']

            ]);

            return response()->json([

                'success' => true,

                'message' => 'Relación registrada correctamente',

                'data' => $data

            ], 201);

        } catch (\Throwable $e) {

            Log::error(__METHOD__, [

                'message' => $e->getMessage()

            ]);

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    #[OA\Get(
        path: "/api/category-sucursal/{id}",
        summary: "Obtener relación categoría sucursal",
        tags: ["CategorySucursal"],

        security: [["bearerAuth" => []]],

        parameters: [

            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer"
                )
            )

        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "OK"
            ),

            new OA\Response(
                response: 404,
                description: "No encontrado"
            )

        ]
    )]

    public function show(string $id)
    {
        $data = CategorySucursal::with([

            'category',

            'sucursal'

        ])->find($id);

        if (!$data) {

            return response()->json([

                'success' => false,

                'message' => 'Registro no encontrado'

            ], 404);

        }

        return response()->json([

            'success' => true,

            'data' => $data

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    #[OA\Put(
        path: "/api/category-sucursal/{id}",
        summary: "Actualizar relación categoría sucursal",
        tags: ["CategorySucursal"],

        security: [["bearerAuth" => []]],

        responses: [

            new OA\Response(
                response: 200,
                description: "Actualizado"
            ),

            new OA\Response(
                response: 404,
                description: "No encontrado"
            )

        ]
    )]

    public function update(
        Request $request,
        string $id
    ) {

        try {

            $data = CategorySucursal::find($id);

            if (!$data) {

                return response()->json([

                    'success' => false,

                    'message' => 'Registro no encontrado'

                ], 404);

            }

            $validated = $request->validate([

                'category_id' =>

                    'sometimes|integer|exists:categories,id',

                'sucursal_id' =>

                    'sometimes|integer|exists:sucursales,id'

            ]);

            $data->update($validated);

            return response()->json([

                'success' => true,

                'message' => 'Relación actualizada correctamente',

                'data' => $data->fresh()

            ], 200);

        } catch (\Throwable $e) {

            Log::error(__METHOD__, [

                'message' => $e->getMessage()

            ]);

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    #[OA\Delete(
        path: "/api/category-sucursal/{id}",
        summary: "Eliminar relación categoría sucursal",
        tags: ["CategorySucursal"],

        security: [["bearerAuth" => []]],

        parameters: [

            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer"
                )
            )

        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "Eliminado"
            ),

            new OA\Response(
                response: 404,
                description: "No encontrado"
            )

        ]
    )]

    public function destroy(string $id)
    {
        try {

            $data = CategorySucursal::find($id);

            if (!$data) {

                return response()->json([

                    'success' => false,

                    'message' => 'Registro no encontrado'

                ], 404);

            }

            $data->delete();

            return response()->json([

                'success' => true,

                'message' => 'Relación eliminada correctamente'

            ], 200);

        } catch (\Throwable $e) {

            Log::error(__METHOD__, [

                'message' => $e->getMessage()

            ]);

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);

        }
    }
}