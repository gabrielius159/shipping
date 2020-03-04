<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Order;
use App\Service\ShippingProvider\DHLService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerAwareInterface;

class DHLServiceTest extends TestCase
{
    private $client;
    private $dhlService;

    public function setUp(): void
    {
        $this->client = new Client();

        $loggerMock = $this->getMockBuilder(LoggerAwareInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dhlService = new DHLService($this->client, $loggerMock);
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

        $response = $this->dhlService->makeRequest($order);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
    }

    public function tearDown(): void
    {
        $this->client = null;
        $this->dhlService = null;
    }
}