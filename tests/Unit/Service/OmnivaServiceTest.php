<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Order;
use App\Service\ShippingProvider\OmnivaService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerAwareInterface;

class OmnivaServiceTest extends TestCase
{
    private $client;
    private $omnivaService;

    public function setUp(): void
    {
        $this->client = new Client();

        $loggerMock = $this->getMockBuilder(LoggerAwareInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omnivaService = new OmnivaService($this->client, $loggerMock);
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

        $response = $this->omnivaService->makeRequest($order);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
    }


    /**
     * @test
     *
     * @throws \Exception
     */
    public function shouldGenerateRequestParameters()
    {
        $order = new Order(
            'ID001',
            'Street',
            'PC54784',
            'Vilnius',
            'Lithuania'
        );

        $generatedParameters = $this->omnivaService->generateRequestParameters($order);

        $this->assertIsArray($generatedParameters);
        $this->assertArrayHasKey('pickup_point_id', $generatedParameters);
    }

    public function tearDown(): void
    {
        $this->client = null;
        $this->omnivaService = null;
    }
}