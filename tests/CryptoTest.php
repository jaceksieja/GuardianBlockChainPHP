<?php
declare(strict_types=1);

use guardiansdk\CryptoService;
use PHPUnit\Framework\TestCase;

class CryptoTest extends TestCase
{
    protected $crypto;

    protected function setUp()
    {
        $this->crypto = new CryptoService();
    }

    public function testNewKeyPair(): void
    {
        $this->crypto->generateNewSet();
        $this->assertNotEmpty($this->crypto->getPrivateKey());
        $this->assertNotEmpty($this->crypto->getPublicKey());
    }

    public function testSignature(): void
    {
        $this->crypto->generateNewSet();
        $payload = "This is a simple test";
        $signature = $this->crypto->sign($this->crypto->getPrivateKey(), $payload);
        $this->assertNotEmpty($signature);
        $this->assertTrue(
            $this->crypto->verify(
                $this->crypto->getPublicKey(),
                $signature,
                $payload
            )
        );
        $this->assertFalse(
            $this->crypto->verify(
                $this->crypto->getPublicKey(),
                $signature,
                $payload."x"
            )
        );
    }
}