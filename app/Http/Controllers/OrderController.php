<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Pizza;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        $new_order = (new OrderService())->makeOrder($request->all());

        return redirect(route('menu'))->with('order_succeed', 'true');
    }

    public function menu()
    {
        $pizzas = Pizza::all();
        $cart = (new OrderService())->getCart();

        return view('menu', ['pizzas' => $pizzas, 'cart' => $cart]);
    }
}
