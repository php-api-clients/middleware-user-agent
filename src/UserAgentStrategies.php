<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent;

use ApiClients\Middleware\UserAgent\UserAgentStrategy;

final class UserAgentStrategies
{
    const STRING          = UserAgentStrategy\StringStrategy::class;
    const PACKAGE_VERSION = UserAgentStrategy\PackageVersionStrategy::class;
}
