<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Order;
use App\Service\ShippingProvider\UpsService;
use GuzzleHttp\Client;
use Psr\Log\LoggerAwareInterface;

class UpsServiceTest
{
    private $client;
    private $upsService;

    public function setUp(): void
    {
        $this->client = new Client();

        $loggerMock = $this->getMockBuilder(LoggerAwareInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->upsService = new UpsService($this->client, $loggerMock);
    }

    /**
     * @test
     */
    public function shouldReturnArrayWithSuccessKey()
    {
        $order = new Order(
            'ID001',
            'Street',
            'PC54784',
            'Vilnius',
            'Lithuania'
        );

        $response = $this->upsService->makeRequest($order);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
    }

    public function tearDown(): void
    {
        $this->client = null;
        $this->upsService = null;
    }
}