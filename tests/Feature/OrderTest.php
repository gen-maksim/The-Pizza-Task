<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
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
}
