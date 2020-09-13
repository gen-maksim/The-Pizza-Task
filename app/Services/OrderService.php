<?php


namespace App\Services;


use App\Models\Order;
use App\Models\Pizza;

class OrderService
{
    public function makeOrder(array $attributes)
    {
        $this->checkCurrency();
        $authed_user = auth()->user();
        $new_order = Order::create([
            'user_id' => $authed_user ? $authed_user->id : null,
            'currency_type' => session('currency_type') ?? 1,
            'address' => $attributes['address'],
            'name' => $attributes['name'],
            'phone' => $attributes['phone'],
            'cost' => 10
        ]);

        foreach ($attributes['pizzas'] as $pizza_attr) {
            $pizza = Pizza::find($pizza_attr['pizza_id']);
            $new_order->pizzas()->attach($pizza, ['count' => $pizza_attr['count']]);
            $new_order->cost += $pizza->cost * $pizza_attr['count'];
        }
        $new_order->cost *= (session('currency_type') === 0 ? 0.84 : 1);

        if (isset($attributes['remember_delivery']) and $authed_user) {
            $authed_user->fill([
                'address' => $attributes['address'],
                'name' => $attributes['name'],
                'phone' => $attributes['phone'],
                'currency_type' => $new_order->currency_type
            ]);

            $authed_user->save();
        }

        $new_order->save();
        session()->put('cart', []);
        return $new_order;
    }

    public function getCart()
    {
        $cart = session('cart');

        if ($cart == null) {
            $cart = [];
            session()->put('cart', $cart);
        }
        return $cart;
    }

    public function checkCurrency()
    {
        $currency = session('currency_type');

        if ($currency === null) {
            if (auth()->user()) {
                $currency = auth()->user()->currency_type;
            } else {
                $currency = 1;
            }
            session()->put('currency_type', $currency);
        }

        return $currency;
    }
}
