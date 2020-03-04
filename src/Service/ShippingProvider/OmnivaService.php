<?php declare(strict_types=1);

namespace App\Service\ShippingProvider;

use App\Entity\Order;
use GuzzleHttp\Client;
use Psr\Log\LoggerAwareInterface;

class OmnivaService extends AbstractShippingProvider implements ShippingProviderInterface
{
    const SHIPPING_PROVIDER_PICKUP_URL = 'http://localhost:8000/omnivafake.com/pickup/find';
    const SHIPPING_PROVIDER_OMNIVA_URL = 'http://localhost:8000/omnivafake.com/register';

    public function __construct(Client $client, LoggerAwareInterface $loggerAware)
    {
        parent::__construct($client, $loggerAware);
    }

    /**
     * @param Order $order
     *
     * @return array
     * @throws \Exception
     */
    public function makeRequest(Order $order): array
    {
        $response = $this->client->request('POST', self::SHIPPING_PROVIDER_OMNIVA_URL, [
            'form_params' => $this->generateRequestParameters($order)
        ]);

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
    protected function generateRequestParameters(Order $order): array
    {
        try {
            $this->assertOrderIsReadyForRegistration($this->isOrderReadyForRegistration($order, [], false));
        } catch (\Exception $exception) {
            $this->logger->alert($exception->getMessage());
        }

        $parcelPointId = $this->getPickupPointForOrder($order);

        try {
            $this->assertOrderIsReadyForRegistration($this->isOrderReadyForRegistration($order, [
                'pickup_point_id' => $parcelPointId
            ]));
        } catch (\Exception $exception) {
            $this->logger->alert($exception->getMessage());
        }

        return [
            'orderId' => $order->getId(),
            'pickup_point_id' => $parcelPointId
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
        if ($checkSpecificParams) {
            return $this->checkSpecificParams($specificParams);
        }

        if (!$order->getId()) {
            return false;
        }

        if (!$order->getCountry()) {
            return false;
        }

        if (!$order->getPostCode()) {
            return false;
        }

        return true;
    }

    /**
     * @param Order $order
     *
     * @return int|null
     *
     * @throws \Exception
     */
    protected function getPickupPointForOrder(Order $order): ?int
    {
        $url = self::SHIPPING_PROVIDER_PICKUP_URL . '?country='.$order->getCountry().'&postCode='.$order->getPostCode();

        $response = $this->client->request('GET', $url);
        $pickupPointId = json_decode($response->getBody()->getContents(), true);

        if (!array_key_exists('pickup_point_id', $pickupPointId)) {
            return null;
        }

        return $pickupPointId['pickup_point_id'];
    }

    /**
     * @param array $specificParams
     *
     * @return bool
     */
    private function checkSpecificParams(array $specificParams): bool
    {
        if (empty($specificParams)) {
            return false;
        }

        if (!isset($specificParams['pickup_point_id'])) {
            return false;
        }

        return true;
    }
}