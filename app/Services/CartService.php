<?php

namespace App\Services;


class CartService
{
    /**
     * Retrieve cart from session
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
     * Add one pizza to cart
     *
     * @param int $pizza_id
     */
    public function addPizza(int $pizza_id): void
    {
        $cart = $this->getCart();
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
     * Delete one pizza from cart
     *
     * @param int $pizza_id
     */
    public function deletePizza(int $pizza_id): void
    {
        $cart = $this->getCart();
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
     * Delete all pizza of one type form session cart
     *
     * @param int $pizza_id
     */
    public function removePizza(int $pizza_id): void
    {
        $cart = $this->getCart();
        $cart_index = array_search($pizza_id, array_column($cart, 'pizza_id'));

        if ($cart_index !== false) {
            unset($cart[$cart_index]);
        }

        session()->put('cart', array_values($cart));
    }
}
