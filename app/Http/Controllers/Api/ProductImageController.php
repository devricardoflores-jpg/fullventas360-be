<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "ProductImages",
    description: "CRUD de imágenes de productos"
)]

class ProductImageController extends Controller
{
   #[OA\Get(
        path: "/api/product-images",
        summary: "Listar imágenes",
        tags: ["ProductImages"],
        responses: [
            new OA\Response(response: 200, description: "OK")
        ]
    )]
    public function index()
    {
        return ProductImage::all();
    }

    #[OA\Post(
        path: "/api/product-images",
        summary: "Crear imagen de producto",
        tags: ["ProductImages"],
        responses: [
            new OA\Response(response: 201, description: "Creado")
        ]
    )]
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'image_path' => 'required'
        ]);

        $image = ProductImage::create([
            'product_id' => $request->product_id,
            'image_path' => $request->image_path,
            'created_at' => time(),
            'update_at' => time()
        ]);

        return response()->json([
            'success' => true,
            'data' => $image
        ], 201);
    }

    #[OA\Get(
        path: "/api/product-images/{id}",
        summary: "Obtener imagen",
        tags: ["ProductImages"],
        responses: [
            new OA\Response(response: 200, description: "OK"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    public function show($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'No encontrado'
            ], 404);
        }

        return $image;
    }

    #[OA\Put(
        path: "/api/product-images/{id}",
        summary: "Actualizar imagen",
        tags: ["ProductImages"],
        responses: [
            new OA\Response(response: 200, description: "Actualizado"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    public function update(Request $request, $id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'No encontrado'
            ], 404);
        }

        $image->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Actualizado',
            'data' => $image
        ]);
    }

    #[OA\Delete(
        path: "/api/product-images/{id}",
        summary: "Eliminar imagen",
        tags: ["ProductImages"],
        responses: [
            new OA\Response(response: 200, description: "Eliminado"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    public function destroy($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'No encontrado'
            ], 404);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Eliminado'
        ]);
    }
}
