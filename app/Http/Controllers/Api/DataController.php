<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        
        $data = [
            ['id' => 1, 'title' => 'Product 1', 'description' => 'Sample product for SSP'],
            ['id' => 2, 'title' => 'Product 2', 'description' => 'Another sample product'],
        ];

        
        if ($request->user()->isAdmin()) {
            $data[] = ['id' => 3, 'title' => 'Admin Product', 'description' => 'Admin-only data'];
        }

        return response()->json($data, 200);
    }
}