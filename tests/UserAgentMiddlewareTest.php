<?php declare(strict_types=1);

namespace ApiClients\Tests\Middleware\UserAgent;

use ApiClients\Middleware\UserAgent\Options;
use ApiClients\Middleware\UserAgent\UserAgentMiddleware;
use ApiClients\Middleware\UserAgent\UserAgentStrategy\StringStrategy;
use ApiClients\Tools\TestUtilities\TestCase;
use function Clue\React\Block\await;
use React\EventLoop\Factory;
use RingCentral\Psr7\Request;

/**
 * @internal
 */
final class UserAgentMiddlewareTest extends TestCase
{
    public function testPre(): void
    {
        $request = new Request('GET', 'https://example.com/');
        $expectedRequest = new Request('GET', 'https://example.com/', ['User-Agent' => 'foo.bar',]);

        self::assertEquals(
            $expectedRequest,
            await(
                (new UserAgentMiddleware())->pre(
                    $request,
                    'abc',
                    [
                        UserAgentMiddleware::class => [
                            Options::STRATEGY   => StringStrategy::class,
                            Options::USER_AGENT => 'foo.bar',
                        ],
                    ]
                ),
                Factory::create()
            )
        );
    }
}
