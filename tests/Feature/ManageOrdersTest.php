<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageOrdersTest extends TestCase
{
    use RefreshDatabase;

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
}
