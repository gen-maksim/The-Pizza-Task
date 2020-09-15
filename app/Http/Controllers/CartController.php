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
     * Return cart view with data
     *
     * @return Application|Factory|View
     */
    public function cart()
    {
        $pizzas = Pizza::all();
        $service = new OrderService();

        $cart = (new CartService())->getCart();
        $service->checkCurrency();
        $history = [];
        if (auth()->check()) {
            $history = $service->getUserHistory(auth()->user());
        }

        return view('cart', ['pizzas' => $pizzas, 'cart' => $cart, 'history' => $history]);
    }

    /**
     * Add one pizza to cart
     *
     * @param PizzaActionRequest $request
     */
    public function addPizza(PizzaActionRequest $request): void
    {
        (new CartService())->addPizza($request->pizza_id);
    }

    /**
     * Delete one pizza from cart
     *
     * @param PizzaActionRequest $request
     */
    public function deletePizza(PizzaActionRequest $request): void
    {
        (new CartService())->deletePizza($request->pizza_id);
    }

    /**
     * Delete all pizza of one type form cart
     *
     * @param PizzaActionRequest $request
     */
    public function removePizza(PizzaActionRequest $request): void
    {
        (new CartService())->removePizza($request->pizza_id);
    }
}
