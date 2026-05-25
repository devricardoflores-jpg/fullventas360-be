<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Products",
    description: "CRUD de Productos"
)]
class ProductController extends Controller
{
    /* ================= LISTAR ================= */
    #[OA\Get(
        path: "/api/products",
        summary: "Listar productos",
        tags: ["Products"],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK"
            ),
            new OA\Response(
                response: 500,
                description: "Error interno"
            )
        ]
    )]
    public function index(Request $request)
    {
        Log::info('PRODUCT - LISTAR', $request->all());

        $query = Product::with(['category', 'images', 'user']);

        if ($request->filled('configuracion_id')) {
            $query->where('configuracion_id', $request->configuracion_id);
        }

        if ($request->filled('sucursal_id')) {
            $query->where('sucursal_id', $request->sucursal_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->latest()->get()
        ]);
    }

    /* ================= CREAR ================= */
    #[OA\Post(
        path: "/api/products",
        summary: "Crear producto",
        tags: ["Products"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    "name",
                    "description",
                    "price",
                    "quantity",
                    "category_id",
                    "user_id",
                    "status"
                ],
                properties: [
                    new OA\Property(property: "configuracion_id", type: "integer", example: 1),
                    new OA\Property(property: "sucursal_id", type: "integer", example: 1),
                    new OA\Property(property: "category_id", type: "integer", example: 2),
                    new OA\Property(property: "user_id", type: "integer", example: 1),
                    new OA\Property(property: "name", type: "string", example: "Laptop HP"),
                    new OA\Property(property: "description", type: "string", example: "i7 16GB RAM"),
                    new OA\Property(property: "price", type: "number", example: 2500),
                    new OA\Property(property: "quantity", type: "integer", example: 10),
                    new OA\Property(property: "status", type: "string", example: "ACTIVO")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Producto creado"
            ),
            new OA\Response(
                response: 422,
                description: "Error de validación"
            )
        ]
    )]
   public function store(Request $request)
{
    $request->validate([
        'configuracion_id' => 'nullable|integer',
        'sucursal_id' => 'nullable|integer',
        'name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'quantity' => 'required',
        'category_id' => 'required',
        'user_id' => 'required',
        'status' => 'required'
    ]);

    try {

        $product = Product::create($request->all());

        /* ================= DIRECTORIOS ================= */
        $barcodeDir = public_path('storage/products/barcode');
        $qrcodeDir = public_path('storage/products/qrcode');

        if (!file_exists($barcodeDir)) {
            mkdir($barcodeDir, 0777, true);
        }

        if (!file_exists($qrcodeDir)) {
            mkdir($qrcodeDir, 0777, true);
        }

        /* ================= BARCODE ================= */
        $generator = new BarcodeGeneratorPNG();

        $barcode = $generator->getBarcode(
            (string) $product->id,
            $generator::TYPE_CODE_128
        );

        $barcodeFile = $product->id . '.png';
        file_put_contents($barcodeDir . '/' . $barcodeFile, $barcode);

        /* ================= QR ================= */
        $qrFile = $product->id . '.png';

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data((string) $product->id)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($qrcodeDir . '/' . $qrFile);

        /* ================= UPDATE ================= */
        $product->update([
            'barcode' => 'storage/products/barcode/' . $barcodeFile,
            'qrcode' => 'storage/products/qrcode/' . $qrFile
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado correctamente',
            'data' => $product->fresh()
        ], 201);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    /* ================= SHOW ================= */
    #[OA\Get(
        path: "/api/products/{id}",
        summary: "Detalle producto",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "OK"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'No encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /* ================= UPDATE ================= */
    #[OA\Put(
        path: "/api/products/{id}",
        summary: "Actualizar producto",
        tags: ["Products"],
        responses: [
            new OA\Response(response: 200, description: "Actualizado"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    
    public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'Producto no encontrado'
        ], 404);
    }

    $request->validate([
        'configuracion_id' => 'nullable|integer',
        'sucursal_id' => 'nullable|integer',
        'category_id' => 'required|integer',
        'user_id' => 'required|integer',
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'status' => 'required|string'
    ]);

    try {

        /* ================= ACTUALIZAR DATOS ================= */
        $product->update([
            'configuracion_id' => $request->configuracion_id,
            'sucursal_id' => $request->sucursal_id,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);

        /* ================= DIRECTORIOS ================= */
        $barcodeDir = public_path('storage/products/barcode');
        $qrcodeDir = public_path('storage/products/qrcode');

        if (!file_exists($barcodeDir)) {
            mkdir($barcodeDir, 0777, true);
        }

        if (!file_exists($qrcodeDir)) {
            mkdir($qrcodeDir, 0777, true);
        }

        /* ================= BARCODE ================= */
        $generator = new BarcodeGeneratorPNG();

        $barcode = $generator->getBarcode(
            (string) $product->id,
            $generator::TYPE_CODE_128
        );

        $barcodeFile = $product->id . '.png';
        file_put_contents($barcodeDir . '/' . $barcodeFile, $barcode);

        /* ================= QR ================= */
        $qrFile = $product->id . '.png';

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data((string) $product->id)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($qrcodeDir . '/' . $qrFile);

        /* ================= UPDATE PATHS ================= */
        $product->update([
            'barcode' => 'storage/products/barcode/' . $barcodeFile,
            'qrcode' => 'storage/products/qrcode/' . $qrFile
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'data' => $product->fresh()
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    /* ================= DELETE ================= */
    #[OA\Delete(
        path: "/api/products/{id}",
        summary: "Eliminar producto",
        tags: ["Products"],
        responses: [
            new OA\Response(response: 200, description: "Eliminado"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'No encontrado'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Eliminado'
        ]);
    }
}