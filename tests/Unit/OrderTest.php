<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * An order has a user
     *
     * @return void
     */
    public function testUser()
    {
        $order = factory('App\Order')->create();

        $this->assertInstanceOf('App\User', $order->user);
    }

    /**
     * An order has a product
     *
     * @return void
     */
    public function testProduct()
    {
        $order = factory('App\Order')->create();

        $this->assertInstanceOf('App\Product', $order->product);
    }

    /**
     * An order has a total cost
     *
     * @return void
     */
    public function testTotal()
    {
        $order = factory('App\Order')->create();

        $this->assertEquals($order->quantity * $order->product->price, $order->total);
    }

    /**
     * We define if order can be calculated with discount
     *
     * @return void
     */
    public function testCanBeCalculatedWithDiscount()
    {
        $product = factory('App\Product')->create(['name' => 'Pepsi Cola', 'discount' => 20]);

        $order = factory('App\Order')->create();

        $this->assertFalse($order->canBeCalculatedWithDiscount());

        $order = factory('App\Order')->create(['product_id' => $product->id, 'quantity' => 2]);

        $this->assertFalse($order->canBeCalculatedWithDiscount());

        $order = factory('App\Order')->create(['product_id' => $product->id, 'quantity' => 3]);

        $this->assertTrue($order->canBeCalculatedWithDiscount());
    }
}
