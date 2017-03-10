<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent;

use ApiClients\Foundation\Middleware\DefaultPriorityTrait;
use ApiClients\Foundation\Middleware\ErrorTrait;
use ApiClients\Foundation\Middleware\MiddlewareInterface;
use ApiClients\Foundation\Middleware\PostTrait;
use Psr\Http\Message\RequestInterface;
use React\Promise\CancellablePromiseInterface;
use function React\Promise\resolve;

final class UserAgentMiddleware implements MiddlewareInterface
{
    use DefaultPriorityTrait;
    use PostTrait;
    use ErrorTrait;

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return CancellablePromiseInterface
     */
    public function pre(RequestInterface $request, array $options = []): CancellablePromiseInterface
    {
        if (!isset($options[UserAgentMiddleware::class][Options::STRATEGY])) {
            return resolve($request);
        }

        $strategy = $options[UserAgentMiddleware::class][Options::STRATEGY];

        if (!class_exists($strategy)) {
            return resolve($request);
        }

        if (!is_subclass_of($strategy, UserAgentStrategyInterface::class)) {
            return resolve($request);
        }

        /** @var UserAgentStrategyInterface $strategy */
        $strategy = new $strategy();

        return resolve(
            $request->withAddedHeader(
                'User-Agent',
                $strategy->determineUserAgent($request, $options[UserAgentMiddleware::class])
            )
        );
    }
}
