<?php

/*
 * This file is part of the Kuiper package.
 *
 * (c) Ye Wenbin <wenbinye@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace kuiper\rpc\fixtures;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use kuiper\rpc\client\ProxyGenerator;
use kuiper\rpc\client\RpcRequestFactoryInterface;
use kuiper\rpc\RpcMethod;
use kuiper\rpc\RpcRequest;
use kuiper\rpc\RpcRequestInterface;
use kuiper\rpc\ServiceLocator;

class RpcRequestFactory implements RpcRequestFactoryInterface
{
    public function createRequest(object $proxy, string $method, array $args): RpcRequestInterface
    {
        $invokingMethod = new RpcMethod($proxy, new ServiceLocator(ProxyGenerator::getInterfaceName(get_class($proxy))), $method, $args);
        $request = (new Request('POST', '/'))
            ->withBody(Utils::streamFor(json_encode($args)));

        return new RpcRequest($request, $invokingMethod);
    }
}
