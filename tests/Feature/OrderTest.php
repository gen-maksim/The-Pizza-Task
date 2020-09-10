<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Pizza;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->session(['currency_type' => 1]);
    }

    /** @test */
    public function it_can_have_pizzas()
    {
        $order = Order::create([
            'cost' => 100,
        ]);

        $pizza = Pizza::create([
            'name' => $this->faker()->word,
            'description' => $this->faker()->words(3, true),
            'cost' => 50,
            'picture' => 'test',
        ]);

        $order->pizzas()->attach($pizza, ['count' => 2]);

        $this->assertEquals(1, $order->pizzas()->count());
        $this->assertEquals(2, $order->pizzas()->first()->count);
    }

    /** @test */
    public function guest_can_make_an_order()
    {
        $pizzas = factory(Pizza::class, 3)->create();

        $response = $this->post(route('order.store'), [
            'pizzas' => [
                [
                    'pizza_id' => $pizzas[0]->id,
                    'count' => 2,
                ],
                [
                    'pizza_id' => $pizzas[1]->id,
                    'count' => 1,
                ]
            ],
            'delivery_needed' => 0,
        ]);

        $created_order = Order::orderByDesc('id')->first();
        $total_cost = $pizzas[0]->cost * 2 + $pizzas[1]->cost;

        $response->assertOk();
        $this->assertEquals('success', $response->json('status'));
        $this->assertEquals(2, $created_order->pizzas()->count());
        $this->assertEquals($total_cost, $created_order->cost);
    }
}
