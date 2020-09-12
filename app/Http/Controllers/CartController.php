<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        $pizzas = Pizza::all();
        $cart = (new OrderService())->getCart();

        return view('cart', ['pizzas' => $pizzas, 'cart' => $cart]);
    }

    public function addPizza(Request $request)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($request->pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index === false) {
            array_push($cart, [
                'pizza_id' => $request->pizza_id,
                'count' => 1,
            ]);
        } else {
            $cart[$cart_index]['count']++;
        }

        session()->put('cart', array_values($cart));
    }

    public function deletePizza(Request $request)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($request->pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index !== false) {
            if ($cart[$cart_index]['count'] > 0) {
                $cart[$cart_index]['count']--;
            } else {
                unset($cart[$cart_index]);
            }
        }

        session()->put('cart', array_values($cart));
    }

    public function removePizza(Request $request)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($request->pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index !== false) {
            unset($cart[$cart_index]);
        }

        session()->put('cart', array_values($cart));
    }
}
