<?php

declare(strict_types=1);

namespace kuiper\rpc\fixtures;

class UserService287144eeac08b48f7713f40fc08f345d implements UserService
{
    private $client = null;

    public function __construct(\kuiper\rpc\client\RpcClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function findUser(int $id): User
    {
        list($ret) = $this->client->sendRequest($this->client->createRequest($this, __FUNCTION__, [$id]));

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllUser(?int &$total): array
    {
        list($ret, $total) = $this->client->sendRequest($this->client->createRequest($this, __FUNCTION__, []));

        return $total;
    }

    /**
     * {@inheritdoc}
     */
    public function saveUser(User $user): void
    {
        list($ret) = $this->client->sendRequest($this->client->createRequest($this, __FUNCTION__, [$user]));
    }

    public function createExecutor(string $method, ...$args): \kuiper\rpc\client\RpcExecutorInterface
    {
        return new \kuiper\rpc\client\RpcExecutor($this->client, $this->client->createRequest($this, $method, $args));
    }
}
