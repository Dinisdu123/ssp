<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        // Sample data (replace with your SSP module data, e.g., products or orders)
        $data = [
            ['id' => 1, 'title' => 'Product 1', 'description' => 'Sample product for SSP'],
            ['id' => 2, 'title' => 'Product 2', 'description' => 'Another sample product'],
        ];

        // Restrict admin-only data if needed
        if ($request->user()->isAdmin()) {
            $data[] = ['id' => 3, 'title' => 'Admin Product', 'description' => 'Admin-only data'];
        }

        return response()->json($data, 200);
    }
}