<?php

declare(strict_types=1);

namespace guardiansdk;

use Psr\Http\Message\ResponseInterface;

class TransportService
{
    protected $client;

    /**
     * TransportService constructor.
     * sets up url and timeout default values.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * GetBalance - runs call to blockchain
     * to request current balance for given wallet address.
     *
     * @param string $wallet
     *
     * @return BalanceModel
     */
    public function getBalance(string $wallet): BalanceModel
    {
        $response = $this->client->get(
            'wallet/' . $wallet
        );

        return $this->parseBalance($response);
    }

    /**
     * Parses response into Balance model
     *
     * @param  ResponseInterface $response
     * @return BalanceModel
     */
    protected function parseBalance(ResponseInterface $response): BalanceModel
    {
        $responseObject = json_decode(
            $response->getBody()->getContents()
        );
        $balance = new BalanceModel();
        $balance->balance = $responseObject->balance;

        return $balance;
    }

    /**
     * Requests wallet address from Blockchain providing public key
     *
     * @param  string $publicKey
     * @return WalletModel
     */
    public function getWalletAddress(string $publicKey): WalletModel
    {
        $response = $this->client->post(
            'wallet',
            new WalletModel($publicKey)
        );

        return $this->parseWallet($response);
    }

    /**
     * Parses http response into Wallet model
     *
     * @param  ResponseInterface $response
     * @return WalletModel
     */
    protected function parseWallet(ResponseInterface $response): WalletModel
    {
        $contents = $response->getBody()->getContents();
        $responseObject = \GuzzleHttp\json_decode(
            $contents
        );
        $wallet = new WalletModel();
        $wallet->publicKey = $responseObject->publicKey;
        $wallet->walletId = $responseObject->walletId;

        return $wallet;
    }

    /**
     * Retrieves History for given wallet
     *
     * @param  string $wallet
     * @return array
     */
    public function getHistory(string $wallet): array
    {
        $response = $this->client->get(
            'transaction/' . $wallet
        );

        return \GuzzleHttp\json_decode(
            $response->getBody()->getContents(),
            true
        );
    }

    /**
     * Executes transaction on Blockchain
     *
     * @param  EnvelopeModel $envelope
     * @return TransactionResponseModel
     */
    public function sendTransaction(EnvelopeModel $envelope): TransactionResponseModel
    {
        $response = $this->client->post(
            'transaction',
            $envelope
        );
        return $this->parseTransaction($response);
    }

    /**
     * Parses Transaction response into saturated model
     *
     * @param  ResponseInterface $response
     * @return TransactionResponseModel
     */
    protected function parseTransaction(ResponseInterface $response): TransactionResponseModel
    {
        $responseObject = \GuzzleHttp\json_decode(
            $response->getBody()->getContents()
        );
        return new TransactionResponseModel($responseObject->transactionId);
    }
}
