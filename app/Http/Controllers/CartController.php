<?php

namespace App\Http\Controllers;

use App\Http\Requests\PizzaActionRequest;
use App\Models\Pizza;
use App\Services\CartService;
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
        (new CartService())->addPizza($request->pizza_id);
    }

    /**
     * delete one pizza from session cart
     *
     * @param PizzaActionRequest $request
     */
    public function deletePizza(PizzaActionRequest $request)
    {
        (new CartService())->deletePizza($request->pizza_id);
    }

    /**
     * Delete all pizza of one type form session cart
     *
     * @param PizzaActionRequest $request
     */
    public function removePizza(PizzaActionRequest $request)
    {
        (new CartService())->removePizza($request->pizza_id);
    }
}
