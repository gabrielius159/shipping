<?php declare(strict_types=1);

namespace App\Service\ShippingProvider;

use App\Entity\Order;

interface ShippingProviderInterface
{
    public function makeRequest(Order $order);

    public function generateRequestParameters(Order $order): array;
}