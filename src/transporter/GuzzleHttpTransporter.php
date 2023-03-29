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

namespace kuiper\rpc\transporter;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use kuiper\rpc\exception\ConnectionException;
use kuiper\rpc\exception\TimedOutException;
use Psr\Http\Message\RequestInterface;

class GuzzleHttpTransporter implements TransporterInterface
{
    public function __construct(private readonly ClientInterface $httpClient)
    {
    }

    public function close(): void
    {
    }

    public function createSession(RequestInterface $request): Session
    {
        try {
            return new SimpleSession($this->httpClient->send($request));
        } catch (RequestException $e) {
            if (str_contains($e->getMessage(), 'Operation timed out')) {
                throw new TimedOutException($this, $e->getMessage(), $e->getCode(), $e);
            }

            throw new ConnectionException($this, $e->getMessage(), $e->getCode(), $e);
        }
    }
}
