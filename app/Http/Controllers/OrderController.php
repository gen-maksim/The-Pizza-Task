<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Pizza;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        $pizzas = (new OrderService())->getCart();

        if (count($pizzas) === 0) {
            return back()->withErrors(['pizza' => 'Wow, looks like you ordered only delivery. Please, add some pizza!']);
        }
        $new_order = (new OrderService())->makeOrder(array_merge(['pizzas' => $pizzas], $request->all()));

        return redirect(route('menu'))->with('order_succeed', 'true');
    }

    public function menu()
    {
        $pizzas = Pizza::all();
        $cart = (new OrderService())->getCart();
        (new OrderService())->checkCurrency();

        return view('menu', ['pizzas' => $pizzas, 'cart' => $cart]);
    }

    public function setCurrency(CurrencyRequest $request)
    {
        session()->put('currency_type', $request->type);
        $authed_user = auth()->user();
        if ($authed_user) {
            $authed_user->currency_type = $request->type;
            $authed_user->save();
        }
    }
}
