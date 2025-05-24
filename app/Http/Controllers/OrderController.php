<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmation($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('_id', $id)
            ->firstOrFail();

        return view('order.confirmation', compact('order'));
    }
}