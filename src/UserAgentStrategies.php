<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent;

final class UserAgentStrategies
{
    const STRING          = UserAgentStrategy\StringStrategy::class;
    const PACKAGE_VERSION = UserAgentStrategy\PackageVersionStrategy::class;
}
