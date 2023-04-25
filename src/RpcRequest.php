<?php

/** @noinspection PhpMissingReturnTypeInspection */

/*
 * This file is part of the Kuiper package.
 *
 * (c) Ye Wenbin <wenbinye@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace kuiper\rpc;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class RpcRequest implements RpcRequestInterface
{
    public function __construct(
        private RequestInterface $httpRequest,
        private RpcMethodInterface $rpcMethod,
        private array $attributes = []
    ) {
    }

    public function getProtocolVersion(): string
    {
        return $this->httpRequest->getProtocolVersion();
    }

    private function withHttpRequest(RequestInterface $httpRequest): static
    {
        $new = clone $this;
        $new->httpRequest = $httpRequest;

        return $new;
    }

    public function withProtocolVersion(string $version): static
    {
        return $this->withHttpRequest($this->httpRequest->withProtocolVersion($version));
    }

    public function getHeaders(): array
    {
        return $this->httpRequest->getHeaders();
    }

    public function hasHeader($name): bool
    {
        return $this->httpRequest->hasHeader($name);
    }

    public function getHeader($name): array
    {
        return $this->httpRequest->getHeader($name);
    }

    public function getHeaderLine($name): string
    {
        return $this->httpRequest->getHeaderLine($name);
    }

    public function withHeader($name, $value): static
    {
        return $this->withHttpRequest($this->httpRequest->withHeader($name, $value));
    }

    public function withAddedHeader($name, $value): static
    {
        return $this->withHttpRequest($this->httpRequest->withAddedHeader($name, $value));
    }

    public function withoutHeader($name): static
    {
        return $this->withHttpRequest($this->httpRequest->withoutHeader($name));
    }

    public function getBody(): StreamInterface
    {
        return $this->httpRequest->getBody();
    }

    public function withBody(StreamInterface $body): static
    {
        return $this->withHttpRequest($this->httpRequest->withBody($body));
    }

    public function getRequestTarget(): string
    {
        return $this->httpRequest->getRequestTarget();
    }

    public function withRequestTarget($requestTarget): static
    {
        return $this->withHttpRequest($this->httpRequest->withRequestTarget($requestTarget));
    }

    public function getMethod(): string
    {
        return $this->httpRequest->getMethod();
    }

    public function withMethod($method): static
    {
        return $this->withHttpRequest($this->httpRequest->withMethod($method));
    }

    public function getUri(): UriInterface
    {
        return $this->httpRequest->getUri();
    }

    public function withUri(UriInterface $uri, $preserveHost = false): static
    {
        return $this->withHttpRequest($this->httpRequest->withUri($uri, $preserveHost));
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getAttribute(string $name, $default = null): mixed
    {
        if (false === array_key_exists($name, $this->attributes)) {
            return $default;
        }

        return $this->attributes[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function withAttribute(string $name, mixed $value): static
    {
        $new = clone $this;
        $attributes = $this->attributes;
        $attributes[$name] = $value;
        $new->attributes = $attributes;

        return $new;
    }

    public function getHttpRequest(): RequestInterface
    {
        return $this->httpRequest;
    }

    public function getRpcMethod(): RpcMethodInterface
    {
        return $this->rpcMethod;
    }

    /**
     * {@inheritDoc}
     */
    public function withRpcMethod(RpcMethodInterface $rpcMethod): static
    {
        $new = clone $this;
        $new->rpcMethod = $rpcMethod;

        return $new;
    }
}
