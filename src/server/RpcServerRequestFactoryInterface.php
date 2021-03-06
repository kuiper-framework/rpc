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

namespace kuiper\rpc\server;

use kuiper\rpc\exception\InvalidRequestException;
use kuiper\rpc\RpcRequestInterface;
use Psr\Http\Message\RequestInterface;

interface RpcServerRequestFactoryInterface
{
    /**
     * Creates the request.
     *
     * @throws InvalidRequestException
     */
    public function createRequest(RequestInterface $request): RpcRequestInterface;
}
