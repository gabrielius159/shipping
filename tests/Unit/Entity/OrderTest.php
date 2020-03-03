<?php


namespace App\Tests\Unit\Entity;

use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldHaveUpsAsDefaultShipping()
    {
        $order = new Order(
            'ID001',
            'Street',
            'PC54784',
            'Vilnius',
            'Lithuania'
        );

        $this->assertEquals(Order::SHIPPING_PROVIDER_UPS, $order->getShipping());
    }
}