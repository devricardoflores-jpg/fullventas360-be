<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\File;
use OpenApi\Attributes as OA;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

#[OA\Tag(
    name: "Products",
    description: "CRUD de Productos"
)]

class ProductController extends Controller
{

#[OA\Get(
    path: "/api/products",
    summary: "Listar productos",
    tags: ["Products"],
    responses: [
        new OA\Response(response: 200, description: "OK")
    ]
)]
public function index()
{
    $products = Product::with([
        'images',
        'category',
        'user'
    ])
    ->where('status', 1)
    ->orderBy('id', 'desc')
    ->get();

    return response()->json([
        'success' => true,
        'data' => $products
    ]);
}

    #[OA\Post(
        path: "/api/products",
        summary: "Crear producto",
        tags: ["Products"],
        responses: [
            new OA\Response(response: 201, description: "Creado"),
            new OA\Response(response: 422, description: "Validación")
        ]
    )]
    
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'quantity' => 'required',
        'category_id' => 'required',
        'status' => 'required'
    ]);

    try {

        $product = Product::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'created_at' => time(),
            'update_at' => time()
        ]);

        /* ===================== CREAR CARPETAS ===================== */
       // Storage::disk('public')->makeDirectory('products/barcode');
        //Storage::disk('public')->makeDirectory('products/qrcode');
       $barcodeDir = storage_path('app/public/products/barcode');
        $qrcodeDir = storage_path('app/public/products/qrcode');

        File::ensureDirectoryExists($barcodeDir);
        File::ensureDirectoryExists($qrcodeDir);
        /* ===================== BARCODE ===================== */
         $generator = new BarcodeGeneratorPNG();

        $barcode = $generator->getBarcode(
            (string) $product->id,
            $generator::TYPE_CODE_128
        );

        $barcodeFileName = $product->id . '.png';

        $barcodeFullPath = $barcodeDir . '/' . $barcodeFileName;

        file_put_contents($barcodeFullPath, $barcode);

        /* ===================== GENERAR QR ===================== */

 
        $qrFileName = $product->id . '.png';

        $qrFullPath = $qrcodeDir . '/' . $qrFileName;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data((string) $product->id)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($qrFullPath);

        /* ===================== GUARDAR RUTAS ===================== */

        $product->update([
            'barcode' => 'storage/products/barcode/' . $barcodeFileName,
            'qrcode' => 'storage/products/qrcode/' . $qrFileName
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado correctamente',
            'data' => $product
        ], 201);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    #[OA\Get(
        path: "/api/products/{id}",
        summary: "Obtener producto",
        tags: ["Products"],
        responses: [
            new OA\Response(response: 200, description: "OK"),
            new OA\Response(response: 404, description: "No encontrado")
        ]
    )]
    public function show($id)
    {
        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

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
         try {

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'update_at' => time()
        ]);

        /* ===================== CARPETAS ===================== */

        $barcodeDir = storage_path('app/public/products/barcode');
        $qrcodeDir = storage_path('app/public/products/qrcode');

        File::ensureDirectoryExists($barcodeDir);
        File::ensureDirectoryExists($qrcodeDir);

        /* ===================== GENERAR BARCODE ===================== */

        $generator = new BarcodeGeneratorPNG();

        $barcode = $generator->getBarcode(
            (string) $product->id,
            $generator::TYPE_CODE_128
        );

        $barcodeFileName = $product->id . '.png';

        $barcodeFullPath = $barcodeDir . '/' . $barcodeFileName;

        file_put_contents($barcodeFullPath, $barcode);

        /* ===================== GENERAR QRCODE ===================== */

        $qrFileName = $product->id . '.png';

        $qrFullPath = $qrcodeDir . '/' . $qrFileName;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data((string) $product->id)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($qrFullPath);

        /* ===================== GUARDAR RUTAS ===================== */

        $product->update([
            'barcode' => 'storage/products/barcode/' . $barcodeFileName,
            'qrcode' => 'storage/products/qrcode/' . $qrFileName
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'data' => $product
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


  #[OA\Delete(
    path: "/api/products/{id}",
    summary: "Eliminar producto lógico",
    tags: ["Products"],
    responses: [
        new OA\Response(response: 200, description: "Eliminado"),
        new OA\Response(response: 404, description: "No encontrado")
    ]
)]

    public function destroy($id)
{
    try {

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        /* ===================== ELIMINADO LÓGICO ===================== */

        $product->update([
            'status' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente',
            'data' => $product
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
 }
    /*
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado'
        ]);
    }
        */
}
