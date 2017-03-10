<?php declare(strict_types=1);

namespace ApiClients\Tests\Middleware\UserAgent\UserAgentStrategy;

use ApiClients\Middleware\UserAgent\Options;
use ApiClients\Middleware\UserAgent\UserAgentStrategy\PackageVersionStrategy;
use ApiClients\Tools\TestUtilities\TestCase;
use InvalidArgumentException;
use PackageVersions\Versions;
use Psr\Http\Message\RequestInterface;

final class PackageVersionStrategyTest extends TestCase
{
    public function testWorking()
    {
        self::assertSame(
            'api-clients/middleware-user-agent ' . explode('@', Versions::getVersion('api-clients/middleware-user-agent'))[0] . ' powered by PHP API Clients https://php-api-clients.org/',
            (new PackageVersionStrategy())->determineUserAgent(
                $this->prophesize(RequestInterface::class)->reveal(),
                [
                    Options::PACKAGE => 'api-clients/middleware-user-agent',
                ]
            )
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Missing package option
     */
    public function testFail()
    {
        (new PackageVersionStrategy())->determineUserAgent(
            $this->prophesize(RequestInterface::class)->reveal(),
            []
        );
    }
}
