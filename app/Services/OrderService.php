<?php


namespace App\Services;


use App\Models\Order;
use App\Models\Pizza;

class OrderService
{
    public function makeOrder(array $attributes)
    {
        $authed_user = auth()->user();
        $new_order = Order::create([
            'user_id' => $authed_user ? $authed_user->id : null,
            'currency_type' => session('currency_type'),
            'delivery_needed' => $attributes['delivery_needed'],
        ]);

        foreach ($attributes['pizzas'] as $pizza_attr) {
            $pizza = Pizza::find($pizza_attr['pizza_id']);
            $new_order->pizzas()->attach($pizza, ['count' => $pizza_attr['count']]);
            $new_order->cost += $pizza->cost * $pizza_attr['count'];
        }

        if ($new_order->delivery_needed) {
            $new_order->fill([
                'address' => $attributes['address'],
                'name' => $attributes['name'],
                'phone' => $attributes['phone'],
            ]);
        }

        if ($attributes['remember_delivery'] and $authed_user) {
            $authed_user->fill([
                'address' => $attributes['address'],
                'name' => $attributes['name'],
                'phone' => $attributes['phone'],
                'currency_type' => $new_order->currency_type
            ]);

            $authed_user->save();
        }

        $new_order->save();
        return $new_order;
    }

    public function getCart()
    {
        $cart = session('cart');
        if ($cart == null) {
            session()->put('cart', []);
        }
        return $cart;
    }
}
