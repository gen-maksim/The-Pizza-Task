<?php

namespace App\Services;


class CartService
{
    /**
     * @param int $pizza_id
     */
    public function addPizza(int $pizza_id)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index === false) {
            array_push($cart, [
                'pizza_id' => $pizza_id,
                'count' => 1,
            ]);
        } else {
            $cart[$cart_index]['count']++;
        }

        session()->put('cart', array_values($cart));
    }

    /**
     * @param int $pizza_id
     */
    public function deletePizza(int $pizza_id)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($pizza_id, array_column($cart, 'pizza_id'));

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
     * @param int $pizza_id
     */
    public function removePizza(int $pizza_id)
    {
        $cart = (new OrderService())->getCart();
        $cart_index = array_search($pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index !== false) {
            unset($cart[$cart_index]);
        }

        session()->put('cart', array_values($cart));
    }
}
