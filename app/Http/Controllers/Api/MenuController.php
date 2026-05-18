<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Menus",
    description: "Menus dinámicos"
)]

class MenuController extends Controller
{
    #[OA\Get(

        path: "/api/menus",

        summary: "Listar menus",

        tags: ["Menus"],

        security: [["bearerAuth" => []]],

        responses: [

            new OA\Response(
                response: 200,
                description: "Lista menus"
            )

        ]

    )]

    public function index(Request $request)
    {

        $user = auth()->user();

        $menus = $user->role
        ->menus()

        ->whereNull('parent_id')

        ->with(['children'])

        ->orderBy('sort_order')

        ->get();

        return response()->json([

            'success' => true,

            'data' => $menus

        ]);

    }
}