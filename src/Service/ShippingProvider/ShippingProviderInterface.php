<?php declare(strict_types=1);

namespace App\Service\ShippingProvider;

use App\Entity\Order;

interface ShippingProviderInterface
{
    public function makeRequest(Order $order);

    /*
     * @todo move function to AbstractShippingProvider
     *
     * my bad, I need to move this function to AbstractShippingProvider to make it protected and abstract.
     */
    public function generateRequestParameters(Order $order): array; 
}
