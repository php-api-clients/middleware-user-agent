<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent\UserAgentStrategy;

use ApiClients\Middleware\UserAgent\Options;
use ApiClients\Middleware\UserAgent\UserAgentStrategyInterface;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

final class StringStrategy implements UserAgentStrategyInterface
{
    public function determineUserAgent(RequestInterface $request, array $options): string
    {
        if (!isset($options[Options::USER_AGENT])) {
            throw new InvalidArgumentException('Missing user agent option');
        }

        return $options[Options::USER_AGENT];
    }
}
