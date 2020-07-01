<?php
declare(strict_types=1);

use guardiansdk\TransactionService;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    protected $transaction;
    protected $from = "10ca96ee75eef3e5aa242f64608cb4a67fed5395d925dec0679b89e4c010649c";
    protected $to ="d58a6ea8beb2fce4dfa9b1fda99367c156e0d1dd031bb55b899484bc18aa432b";
    protected $privateKey ="";
    protected $publicKey = "";

    protected function setUp()
    {
        $this->transaction = new TransactionService();
    }

    public function testDefault(): void
    {
        $this->assertNotEmpty($this->transaction);
    }

// provide valid keys and uncomment this test
//    public function testTransaction(): void {
//        $response = $this->transaction->transact(
//            $this->from,
//            $this->to,
//            0.00001,
//            $this->publicKey,
//            $this->privateKey
//        );
//
//        $this->assertEquals(36, strlen($response->transactionId));
//    }
}