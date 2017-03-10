<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent;

use Psr\Http\Message\RequestInterface;

interface UserAgentStrategyInterface
{
    public function determineUserAgent(RequestInterface $request, array $options): string;
}
