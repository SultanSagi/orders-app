<?php

namespace Tests\Feature;

use App\Order;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageOrdersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * See a list of all orders
     *
     * @return void
     */
    public function testListAll()
    {
        $this->withoutExceptionHandling();

        $order = factory('App\Order')->create();

        $this->get('')
            ->assertSee($order->user->name);
    }

    /**
     * Add a new order
     *
     * @return void
     */
    public function testAddNew()
    {
        $this->withoutExceptionHandling();

        $product = factory('App\Product')->create();

        $attributes = [
            'user_id' => factory('App\User')->create()->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1,20)
        ];

        $this->post('orders', $attributes);

        $this->assertDatabaseHas('orders', [
            'user_id' => $attributes['user_id'],
            'product_id' => $attributes['product_id'],
            'quantity' => $attributes['quantity'],
            'total' => $attributes['quantity'] * $product->price,
        ]);

        $order = Order::latest()->first();

        $this->get('/')
            ->assertSee($order->user->name);
    }
}
