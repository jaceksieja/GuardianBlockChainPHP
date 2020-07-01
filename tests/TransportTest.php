<?php
declare(strict_types=1);

use guardiansdk\TransportService;
use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{
    private $transport;

    public function setUp(): void
    {
        $this->transport = new TransportService();
    }

    public function testBalance(): void
    {
        $balance = $this->transport->getBalance(
            "10ca96ee75eef3e5aa242f64608cb4a67fed5395d925dec0679b89e4c010649a"
        );
        $this->assertEquals(0, $balance->balance);
    }

    public function testNewWallet(): void
    {
        $response = $this->transport->getWalletAddress("asdasdsadsadsd");
        $this->assertEquals(
            "0f125463d0af398eb9deaa424d1c091e30885fed2ea0256d7b5884c19339b616",
            $response->walletId
        );
        $this->assertNotEmpty($response->publicKey);
    }

    public function testHistory(): void
    {
        $response = $this->transport->getHistory(
            "0f125463d0af398eb9deaa424d1c091e30885fed2ea0256d7b5884c19339b616"
        );
        $this->assertIsArray($response);
    }
// provide valid envelope and uncoment for full unit coverage
//    public function testTransaction(): void {
//        $envelope = new \guardiansdk\EnvelopeModel(
//            "",
//            "",
//            ""
//        );
//        $response = $this->transport->sendTransaction($envelope);
//        $this->assertEquals(36, strlen($response->transactionId));
//    }

}