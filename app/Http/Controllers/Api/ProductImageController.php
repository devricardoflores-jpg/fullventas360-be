<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Product Images",
    description: "CRUD de imágenes de productos"
)]
class ProductImageController extends Controller
{
    /* ================= LISTAR ================= */
    #[OA\Get(
        path: "/api/producto_images",
        operationId: "productoImages_index",
        summary: "Listar imágenes de productos",
        tags: ["Product Images"],
        parameters: [
            new OA\Parameter(
                name: "product_id",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "OK")
        ]
    )]
    public function index(Request $request)
    {
        Log::info('PRODUCT IMAGE - LISTAR', $request->all());

        $query = ProductImage::query();

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $images = $query->orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }

    /* ================= SUBIR IMAGEN ================= */
    #[OA\Post(
        path: "/api/producto_images",
        operationId: "productoImages_store",
        summary: "Subir imagen de producto",
        tags: ["Product Images"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["product_id", "image"],
                    properties: [
                        new OA\Property(property: "product_id", type: "integer", example: 1),
                        new OA\Property(property: "image", type: "string", format: "binary")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Imagen subida correctamente"),
            new OA\Response(response: 422, description: "Error de validación"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'image' => 'required|image|max:2048'
        ]);

        try {

            $path = $request->file('image')->store('products', 'public');

            $image = ProductImage::create([
                'product_id' => $request->product_id,
                'image_path' => 'storage/' . $path
            ]);

            Log::info('PRODUCT IMAGE - CREATED', [
                'product_id' => $request->product_id,
                'image_id' => $image->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida correctamente',
                'data' => $image
            ], 201);

        } catch (\Exception $e) {

            Log::error('PRODUCT IMAGE ERROR', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al subir imagen'
            ], 500);
        }
    }

    /* ================= ELIMINAR ================= */
    #[OA\Delete(
        path: "/api/producto_images/{id}",
        operationId: "productoImages_delete",
        summary: "Eliminar imagen de producto",
        tags: ["Product Images"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Imagen eliminada"),
            new OA\Response(response: 404, description: "No encontrado"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function destroy($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        try {

            $filePath = str_replace('storage/', 'public/', $image->image_path);

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada correctamente'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar imagen'
            ], 500);
        }
    }
}