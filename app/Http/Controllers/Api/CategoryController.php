<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

use Illuminate\Support\Facades\Log;

#[OA\Tag(
    name: "Categories",
    description: "CRUD de Categorías"
)]

class CategoryController extends Controller
{
    #[OA\Get(
        path: "/categories",
        summary: "Listar categorías",
        tags: ["Categories"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de categorías"
            )
        ]
    )]
    public function index()
    {
          Log::info(__METHOD__, [
        'file' => __FILE__,
        'line' => __LINE__,
        'message' => 'CATEGORY - Listar categorías'
        ]);

        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    #[OA\Post(
        path: "/categories",
        summary: "Registrar categoría",
        tags: ["Categories"],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "description"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Electrónicos"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "Productos electrónicos"
                    )
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Categoría registrada"
            )
        ]
    )]
    public function store(Request $request)
    {
                        Log::info(__METHOD__, [
                    'file' => __FILE__,
                    'line' => __LINE__,
                    'message' => 'CATEGORY - Registrar categoría',
                    'request' => $request->all()
                ]);

                $request->validate([
                    'name' => 'required|max:255',
                    'description' => 'required|max:255'
                ]);

                $category = Category::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'created_at' => time(),
                    'update_at' => time()
                ]);

                Log::info(__METHOD__, [
                    'file' => __FILE__,
                    'line' => __LINE__,
                    'message' => 'CATEGORY - Categoría registrada',
                    'id' => $category->id
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Categoría registrada correctamente',
                    'data' => $category
                ], 201);
    }

    #[OA\Get(
        path: "/categories/{id}",
        summary: "Obtener categoría por ID",
        tags: ["Categories"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID de la categoría",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Detalle categoría"
            ),
            new OA\Response(
                response: 404,
                description: "Categoría no encontrada"
            )
        ]
    )]
    public function show(string $id)
    {
                    Log::info(__METHOD__, [
                'file' => __FILE__,
                'line' => __LINE__,
                'message' => 'CATEGORY - Obtener categoría',
                'id' => $id
            ]);

            $category = Category::find($id);

            if (!$category) {

                Log::warning(__METHOD__, [
                    'file' => __FILE__,
                    'line' => __LINE__,
                    'message' => 'CATEGORY - Categoría no encontrada',
                    'id' => $id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Categoría no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $category
            ], 200);  
    }

    #[OA\Put(
        path: "/categories/{id}",
        summary: "Actualizar categoría",
        tags: ["Categories"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID categoría",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Tecnología"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "Productos tecnológicos"
                    )
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 200,
                description: "Categoría actualizada"
            )
        ]
    )]
    public function update(Request $request, string $id)
    {
                 try {

        Log::info(__METHOD__, [
            'message' => 'CATEGORY - Actualizar categoría',
            'id' => $id,
            'request' => $request->all()
        ]);

        $category = Category::find($id);

        if (!$category) {

            Log::warning(__METHOD__, [
                'message' => 'CATEGORY - Categoría no encontrada update',
                'id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'update_at' => time() // si tu campo es BIGINT
        ]);

        Log::info(__METHOD__, [
            'message' => 'CATEGORY - Categoría actualizada',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente',
             'data' => $category->fresh()
        ], 200);

    } catch (\Throwable $e) {

        Log::error('CATEGORY - Error en update', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error interno del servidor',
            'error' => $e->getMessage() // puedes quitar esto en producción
        ], 500);
    }
    }

    #[OA\Delete(
        path: "/categories/{id}",
        summary: "Eliminar categoría",
        tags: ["Categories"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID categoría",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Categoría eliminada"
            )
        ]
    )]
    public function destroy(string $id)
    {
                Log::info(__METHOD__, [
                'file' => __FILE__,
                'line' => __LINE__,
                'message' => 'CATEGORY - Eliminar categoría',
                'id' => $id
            ]);

            $category = Category::find($id);

            if (!$category) {

                Log::warning(__METHOD__, [
                    'file' => __FILE__,
                    'line' => __LINE__,
                    'message' => 'CATEGORY - Categoría no encontrada delete',
                    'id' => $id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Categoría no encontrada'
                ], 404);
            }

            $category->delete();

            Log::info(__METHOD__, [
                'file' => __FILE__,
                'line' => __LINE__,
                'message' => 'CATEGORY - Categoría eliminada',
                'id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada correctamente'
            ], 200);
    }
}