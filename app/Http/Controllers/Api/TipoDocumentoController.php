<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "TipoDocumento",
    description: "CRUD de Tipo Documento"
)]

class TipoDocumentoController extends Controller
{
   #[OA\Get(
        path: "/tipodocumentos",
        summary: "Listar tipos de documento",
        tags: ["TipoDocumento"],

        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de tipos de documento"
            )
        ]
    )]
    public function index()
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Listar'
        ]);

        $tipodocumentos = TipoDocumento::all();

        return response()->json([
            'success' => true,
            'data' => $tipodocumentos
        ], 200);
    }

    #[OA\Post(
        path: "/tipodocumentos",
        summary: "Registrar tipo documento",
        tags: ["TipoDocumento"],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "description", "type"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "FACTURA"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "Documento fiscal factura"
                    ),
                    new OA\Property(
                        property: "type",
                        type: "string",
                        example: "VENTA"
                    )
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Tipo documento registrado"
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
            'message' => 'TIPODOCUMENTO - Registrar',
            'request' => $request->all()
        ]);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|max:255'
        ]);

        $tipodocumento = TipoDocumento::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'created_at' => time(),
            'update_at' => time()
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Registrado',
            'id' => $tipodocumento->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tipo documento registrado correctamente',
            'data' => $tipodocumento
        ], 201);
    }

    #[OA\Get(
        path: "/tipodocumentos/{id}",
        summary: "Obtener tipo documento",
        tags: ["TipoDocumento"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID del tipo documento",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Detalle tipo documento"
            ),
            new OA\Response(
                response: 404,
                description: "Tipo documento no encontrado"
            )
        ]
    )]
    public function show(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Obtener',
            'id' => $id
        ]);

        $tipodocumento = TipoDocumento::find($id);

        if (!$tipodocumento) {

            Log::warning(__METHOD__, [
                'file' => __FILE__,
                'line' => __LINE__,
                'message' => 'TIPODOCUMENTO - No encontrado',
                'id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Tipo documento no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tipodocumento
        ], 200);
    }

    #[OA\Put(
        path: "/tipodocumentos/{id}",
        summary: "Actualizar tipo documento",
        tags: ["TipoDocumento"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID tipo documento",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "description", "type"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "BOLETA"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "Documento boleta"
                    ),
                    new OA\Property(
                        property: "type",
                        type: "string",
                        example: "COMPRA"
                    )
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 200,
                description: "Tipo documento actualizado"
            ),
            new OA\Response(
                response: 404,
                description: "Tipo documento no encontrado"
            )
        ]
    )]
    public function update(Request $request, string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Actualizar',
            'id' => $id,
            'request' => $request->all()
        ]);

        $tipodocumento = TipoDocumento::find($id);

        if (!$tipodocumento) {

            return response()->json([
                'success' => false,
                'message' => 'Tipo documento no encontrado'
            ], 404);
        }

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|max:255'
        ]);

        $tipodocumento->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'update_at' => time()
        ]);

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Actualizado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tipo documento actualizado correctamente',
            'data' => $tipodocumento
        ], 200);
    }

    #[OA\Delete(
        path: "/tipodocumentos/{id}",
        summary: "Eliminar tipo documento",
        tags: ["TipoDocumento"],

        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID tipo documento",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Tipo documento eliminado"
            ),
            new OA\Response(
                response: 404,
                description: "Tipo documento no encontrado"
            )
        ]
    )]
    public function destroy(string $id)
    {
        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Eliminar',
            'id' => $id
        ]);

        $tipodocumento = TipoDocumento::find($id);

        if (!$tipodocumento) {

            return response()->json([
                'success' => false,
                'message' => 'Tipo documento no encontrado'
            ], 404);
        }

        $tipodocumento->delete();

        Log::info(__METHOD__, [
            'file' => __FILE__,
            'line' => __LINE__,
            'message' => 'TIPODOCUMENTO - Eliminado',
            'id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tipo documento eliminado correctamente'
        ], 200);
    }
}
