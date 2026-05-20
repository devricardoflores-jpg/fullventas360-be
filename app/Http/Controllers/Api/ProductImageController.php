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
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    try {

        // =========================
        // CREAR CARPETA
        // =========================

        Storage::disk('public')
            ->makeDirectory('products/images');

        // =========================
        // GUARDAR IMAGEN
        // =========================

        $file = $request->file('image');

        $filename =
            time().'_'.$file->getClientOriginalName();

        $path = $file->storeAs(
            'products/images',
            $filename,
            'public'
        );

        // =========================
        // GUARDAR BD
        // =========================

        $image = ProductImage::create([

            'product_id' => $request->product_id,

            'image_path' => 'storage/'.$path,

            'created_at' => time(),

            'update_at' => time()

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Imagen subida',

            'data' => $image

        ], 201);

    } catch (\Exception $e) {

        return response()->json([

            'success' => false,

            'error' => $e->getMessage()

        ], 500);
    }
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

            'message' => 'Imagen no encontrada'

        ], 404);
    }

    $request->validate([

        'image' =>
        'required|image|mimes:jpg,jpeg,png,webp|max:2048'

    ]);

    try {

        // =========================
        // ELIMINAR IMAGEN ANTERIOR
        // =========================

        $oldPath = str_replace(
            'storage/',
            '',
            $image->image_path
        );

        if (
            Storage::disk('public')
                ->exists($oldPath)
        ) {

            Storage::disk('public')
                ->delete($oldPath);
        }

        // =========================
        // NUEVA IMAGEN
        // =========================

        $file = $request->file('image');

        $filename =
            time().'_'.$file->getClientOriginalName();

        $path = $file->storeAs(

            'products/images',

            $filename,

            'public'
        );

        // =========================
        // UPDATE BD
        // =========================

        $image->update([

            'image_path' =>
                'storage/'.$path,

            'update_at' =>
                time()

        ]);

        return response()->json([

            'success' => true,

            'message' =>
                'Imagen actualizada',

            'data' => $image

        ]);

    } catch (\Exception $e) {

        return response()->json([

            'success' => false,

            'error' => $e->getMessage()

        ], 500);
    }
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
