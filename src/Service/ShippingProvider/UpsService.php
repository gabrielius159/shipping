<?php declare(strict_types=1);

namespace App\Service\ShippingProvider;

use App\Entity\Order;

class UpsService extends AbstractShippingProvider implements ShippingProviderInterface
{
    const SHIPPING_PROVIDER_UPS_URL = 'http://localhost:8000/upsfake.com/register';

    /**
     * @param Order $order
     *
     * @return array
     *
     * @throws \Exception
     */
    public function makeRequest(Order $order): array
    {
        $response = $this->client->request('POST', self::SHIPPING_PROVIDER_UPS_URL);

        try {
            $this->assertResponseBodyIsNotEmpty($response);
        } catch (\Exception $exception) {
            $this->logger->alert($exception->getMessage());
        }

        $response = json_decode($response->getBody()->getContents(), true);

        try {
            $this->assertReturnsSuccessMessage($response);
        } catch (\Exception $exception) {
            $this->logger->alert($exception->getMessage());
        }

        return $response;
    }

    /**
     * @param Order $order
     *
     * @return array
     *
     * @throws \Exception
     */
    public function generateRequestParameters(Order $order): array
    {
        try {
            $this->assertOrderIsReadyForRegistration($this->isOrderReadyForRegistration($order));
        } catch (\Exception $exception) {
            $this->logger->alert($exception->getMessage());
        }

        return [
            'order_id' => $order->getId(),
            'country' => $order->getCountry(),
            'street' => $order->getStreet(),
            'city' => $order->getCity(),
            'post_code' => $order->getPostCode()
        ];
    }

    /**
     * @param Order $order
     * @param array $specificParams
     * @param bool  $checkSpecificParams
     *
     * @return bool
     */
    protected function isOrderReadyForRegistration(
        Order $order,
        array $specificParams = [],
        bool $checkSpecificParams = true
    ): bool {
        if (!$order->getId()) {
            return false;
        }

        if (!$order->getCountry()) {
            return false;
        }

        if (!$order->getStreet()) {
            return false;
        }

        if (!$order->getCity()) {
            return false;
        }

        if (!$order->getPostCode()) {
            return false;
        }

        return true;
    }
}