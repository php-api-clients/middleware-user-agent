<?php declare(strict_types=1);

namespace ApiClients\Tests\Foundation\Transport\UserAgentStrategy;

use ApiClients\Middleware\UserAgent\Options;
use ApiClients\Middleware\UserAgent\UserAgentStrategy\StringStrategy;
use ApiClients\Tools\TestUtilities\TestCase;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

final class StringStrategyTest extends TestCase
{
    public function testWorking()
    {
        $userAgent = 'abc';

        self::assertSame(
            $userAgent,
            (new StringStrategy())->determineUserAgent(
                $this->prophesize(RequestInterface::class)->reveal(),
                [
                    Options::USER_AGENT => $userAgent,
                ]
            )
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Missing user agent option
     */
    public function testFail()
    {
        (new StringStrategy())->determineUserAgent(
            $this->prophesize(RequestInterface::class)->reveal(),
            []
        );
    }
}
