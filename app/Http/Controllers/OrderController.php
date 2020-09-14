<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Pizza;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Storing an order
     *
     * @param OrderStoreRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(OrderStoreRequest $request)
    {
        $pizzas = (new CartService())->getCart();

        if (count($pizzas) === 0) {
            return back()->withErrors(['pizza' => 'Wow, looks like you ordered only delivery. Please, add some pizza!']);
        }
        (new OrderService())->makeOrder(array_merge(['pizzas' => $pizzas], $request->all()));

        return redirect(route('menu'))->with('order_succeed', 'true');
    }

    /**
     * Return menu view with data
     *
     * @return Application|Factory|View
     */
    public function menu()
    {
        $pizzas = Pizza::all();
        $cart = (new CartService())->getCart();
        (new OrderService())->checkCurrency();

        return view('menu', ['pizzas' => $pizzas, 'cart' => $cart]);
    }

    /**
     * Update session currency type
     *
     * @param CurrencyRequest $request
     */
    public function setCurrency(CurrencyRequest $request)
    {
        $authed_user = auth()->user();
        if ($authed_user) {
            $authed_user->currency_type = $request->type;
            $authed_user->save();
        }

        session()->put('currency_type', $request->type);
    }
}
