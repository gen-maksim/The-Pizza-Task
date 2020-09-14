<?php

namespace App\Http\Controllers;

use App\Http\Requests\PizzaActionRequest;
use App\Models\Pizza;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Returning cart view with data
     *
     * @return Application|Factory|View
     */
    public function cart()
    {
        $pizzas = Pizza::all();
        $service = new OrderService();

        $cart = $service->getCart();
        $service->checkCurrency();
        $history = [];
        if (auth()->check()) {
            $history = $service->getUserHistory(auth()->user());
        }

        return view('cart', ['pizzas' => $pizzas, 'cart' => $cart, 'history' => $history]);
    }

    /**
     * Add one pizza to session cart
     *
     * @param PizzaActionRequest $request
     */
    public function addPizza(PizzaActionRequest $request)
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

    /**
     * delete one pizza from session cart
     *
     * @param PizzaActionRequest $request
     */
    public function deletePizza(PizzaActionRequest $request)
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

    /**
     * Delete all pizza of one type form session cart
     *
     * @param PizzaActionRequest $request
     */
    public function removePizza(PizzaActionRequest $request)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($request->pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index !== false) {
            unset($cart[$cart_index]);
        }

        session()->put('cart', array_values($cart));
    }
}
