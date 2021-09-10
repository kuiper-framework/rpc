<?php

declare(strict_types=1);

namespace kuiper\rpc\client\middleware;

use kuiper\resilience\retry\RetryFactory;
use kuiper\rpc\MiddlewareInterface;
use kuiper\rpc\RpcRequestHandlerInterface;
use kuiper\rpc\RpcRequestInterface;
use kuiper\rpc\RpcResponseInterface;

class Retry implements MiddlewareInterface
{
    /**
     * @var RetryFactory
     */
    private $retryFactory;

    /**
     * Retry constructor.
     *
     * @param RetryFactory $retryFactory
     */
    public function __construct(RetryFactory $retryFactory)
    {
        $this->retryFactory = $retryFactory;
    }

    public function process(RpcRequestInterface $request, RpcRequestHandlerInterface $handler): RpcResponseInterface
    {
        $rpcMethod = $request->getRpcMethod();

        return $this->retryFactory->create($rpcMethod->getServiceLocator()->getName().'::'.$rpcMethod->getMethodName())
            ->call([$handler, 'handle'], $request);
    }
}
