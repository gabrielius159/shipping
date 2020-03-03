<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Order as OrderEntity;
use App\Service\ShippingProvider\DHLService;
use App\Service\ShippingProvider\OmnivaService;
use App\Service\ShippingProvider\UpsService;

class Order
{
    private $upsService;
    private $omnivaService;
    private $dhlService;

    /**
     * Order constructor.
     *
     * @param UpsService    $upsService
     * @param OmnivaService $omnivaService
     * @param DHLService    $dhlService
     */
    public function __construct(
        UpsService $upsService,
        OmnivaService $omnivaService,
        DHLService $dhlService
    ) {
        $this->upsService    = $upsService;
        $this->omnivaService = $omnivaService;
        $this->dhlService    = $dhlService;
    }

    /**
     * @param OrderEntity $order
     *
     * @throws \Exception
     */
    public function registerShipping(OrderEntity $order): void
    {
        switch ($order->getShipping()) {
            case OrderEntity::SHIPPING_PROVIDER_UPS: {
                $this->upsService->makeRequest($order);

                break;
            }
            case OrderEntity::SHIPPING_PROVIDER_OMNIVA: {
                $this->omnivaService->makeRequest($order);

                break;
            }
            case OrderEntity::SHIPPING_PROVIDER_DHL: {
                $this->dhlService->makeRequest($order);

                break;
            }
        }
    }
}