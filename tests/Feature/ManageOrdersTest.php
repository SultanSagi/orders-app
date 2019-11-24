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
        ]);

        $order = Order::latest()->first();

        $this->assertSame($order->quantity*$order->product->price, $order->total);

        $this->get('/')
            ->assertSee($order->user->name);
    }

    /**
     * Edit existing order
     *
     * @return void
     */
    public function testEdit()
    {
        $this->withoutExceptionHandling();

        $order = factory('App\Order')->create();

        $product = factory('App\Product')->create(['price' => 200]);

        $attributes = [
            'user_id' => factory('App\User')->create()->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1,20),
        ];

        $this->patch("orders/{$order->id}", $attributes);

        $this->assertCount(1, Order::all());

        $this->assertDatabaseHas('orders', $attributes);

        $order = Order::latest()->first();

        $this->assertSame($order->quantity*$order->product->price, $order->total);
    }

    /**
     * Delete an order
     *
     * @return void
     */
    public function testDelete()
    {
        $this->withoutExceptionHandling();

        $order = factory('App\Order')->create();

        $this->delete('orders/' . $order->id);

        $this->assertDatabaseMissing('orders', $order->only('id'));
    }

    /**
     * Filter orders by date (all time, today, week)
     *
     * @return void
     */
    public function testFilterByDate()
    {
        $now = \Carbon\Carbon::now();

        $orderToday = factory('App\Order')->create();
        $orderWeek = factory('App\Order')->create(['created_at' => $now->copy()->subWeek()]);
        $orderMonth = factory('App\Order')->create(['created_at' => $now->copy()->subMonth()]);

        $this->json('get', '?date=today')
            ->assertSee($orderToday->user->name)
            ->assertDontSee($orderWeek->user->name)
            ->assertDontSee($orderMonth->user->name);

        $this->json('get', '?date=week')
            ->assertSee($orderToday->user->name)
            ->assertSee($orderWeek->user->name)
            ->assertDontSee($orderMonth->user->name);

        $this->json('get', '')
            ->assertSee($orderToday->user->name)
            ->assertSee($orderWeek->user->name)
            ->assertSee($orderMonth->user->name);
    }

    /**
     * Filter orders by product
     *
     * @return void
     */
    public function testFilterByProduct()
    {
        $orderByProduct = factory('App\Order')->create();
        $orderNotByProduct = factory('App\Order')->create();
        $orderNotByProduct2 = factory('App\Order')->create();

        $this->json('get', '?product_id=' . $orderByProduct->product->id)
            ->assertSee($orderByProduct->user->name)
            ->assertDontSee($orderNotByProduct->user->name)
            ->assertDontSee($orderNotByProduct2->user->name);
    }

    /**
     * Filter orders by user
     *
     * @return void
     */
    public function testFilterByUser()
    {
        $orderByUser = factory('App\Order')->create();
        $orderNotByUser = factory('App\Order')->create();
        $orderNotByUser2 = factory('App\Order')->create();

        $this->json('get', '?product_id=' . $orderByUser->user->id)
            ->assertSee($orderByUser->user->name)
            ->assertDontSee($orderNotByUser->user->name)
            ->assertDontSee($orderNotByUser2->user->name);
    }

    /**
     * Search orders by user name
     *
     * @return void
     */
    public function testSearchByUser()
    {
        $orderByUser = factory('App\Order')->create(['user_id' => factory('App\User')->create(['name' => 'Mtfbfga'])]);
        $orderNotByUser = factory('App\Order')->create();
        $orderNotByUser2 = factory('App\Order')->create();

        $this->json('get', '?q=' . $orderByUser->user->name)
            ->assertSee($orderByUser->user->name)
            ->assertDontSee($orderNotByUser->user->name)
            ->assertDontSee($orderNotByUser2->user->name);
    }

    /**
     * Search orders by product name
     *
     * @return void
     */
    public function testSearchByProduct()
    {
        $orderByUser = factory('App\Order')->create(['product_id' => factory('App\Product')->create(['name' => 'Mtfbfga'])]);
        $orderNotByUser = factory('App\Order')->create();
        $orderNotByUser2 = factory('App\Order')->create();

        $this->json('get', '?q=' . $orderByUser->product->name)
            ->assertSee($orderByUser->product->name)
            ->assertDontSee($orderNotByUser->product->name)
            ->assertDontSee($orderNotByUser2->product->name);
    }
}
