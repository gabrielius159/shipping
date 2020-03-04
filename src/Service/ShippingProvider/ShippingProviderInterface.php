<?php declare(strict_types=1);

namespace App\Service\ShippingProvider;

use App\Entity\Order;

interface ShippingProviderInterface
{
    /**
     * @param Order $order
     *
     * @return array
     */
    public function makeRequest(Order $order): array;
}
