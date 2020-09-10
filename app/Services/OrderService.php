<?php


namespace App\Services;


use App\Models\Order;
use App\Models\Pizza;

class OrderService
{
    public function makeOrder(array $attributes)
    {
        $new_order = Order::create([
            'user_id' => auth()->user() ? auth()->id() : null,
            'currency_type' => session()->get('currency_type'),
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

        $new_order->save();
        return $new_order;
    }
}
