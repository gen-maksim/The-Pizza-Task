<?php


namespace App\Services;

use App\Models\Order;
use App\Models\Pizza;

class OrderService
{
    /**
     * Fill order with data
     *
     * @param array $attributes
     * @return Order
     */
    public function makeOrder(array $attributes): Order
    {
        $this->checkCurrency();
        $authed_user = auth()->user();

        /** @var Order $new_order */
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

    /**
     * Retrieving currency type from session
     *
     * @return int
     */
    public function checkCurrency(): int
    {
        $currency = session()->get('currency_type');

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

    /**
     * Retrieving cart from session
     *
     * @return array
     */
    public function getCart(): array
    {
        $cart = session()->get('cart');

        if ($cart == null) {
            $cart = [];
            session()->put('cart', $cart);
        }

        return $cart;
    }

    /**
     * Collecting data for user previous orders
     *
     * @param $user
     * @return array
     */
    public function getUserHistory($user)
    {
        $orders = $user->orders()->get();
        $history = [];
        foreach ($orders as $order) {
            $pizzas = [];
            foreach ($order->pizzas()->get() as $pizza) {
                $pizzas [] = [
                    'name' => $pizza->name,
                    'count' => $pizza->count
                ];
            }
            $history [] = [
                'total_price' => $order->cost,
                'currency_type' => $order->currency_type,
                'pizzas' => $pizzas,
                'created_at' => $order->created_at->toDateTimeString(),
            ];
        }

        return $history;
    }
}
