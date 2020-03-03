<?php declare(strict_types=1);

namespace App\Service\ShippingProvider;

use App\Entity\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractShippingProvider
{
    use LoggerAwareTrait;

    protected $client;

    /**
     * AbstractShippingProvider constructor.
     *
     * @param Client               $client
     * @param LoggerAwareInterface $loggerAware
     */
    public function __construct(Client $client, LoggerAwareInterface $loggerAware)
    {
        $this->client = $client;
        $this->logger = $loggerAware;
    }

    abstract protected function isOrderReadyForRegistration(
        Order $order,
        array $specificParams = [],
        bool $checkSpecificParams = true
    ): bool;

    /**
     * @param Response $response
     *
     * @throws \Exception
     */
    protected function assertResponseBodyIsNotEmpty(Response $response): void
    {
        if (empty($response->getBody())) {
            throw new \Exception('Response body is empty.');
        }
    }

    /**
     * @param bool $isOrderReadyForRegistration
     *
     * @throws \Exception
     */
    protected function assertOrderIsReadyForRegistration(bool $isOrderReadyForRegistration): void
    {
        if (!$isOrderReadyForRegistration) {
            throw new \Exception('Order is not ready yet!');
        }
    }

    /**
     * @param array $response
     *
     * @throws \Exception
     */
    protected function assertReturnsSuccessMessage(array $response): void
    {
        if (!array_key_exists('success', $response) && $response['success'] !== true) {
            throw new \Exception('Array does\'t have success key!');
        }
    }
}