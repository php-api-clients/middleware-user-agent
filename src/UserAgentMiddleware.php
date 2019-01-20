<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent;

use ApiClients\Foundation\Middleware\ErrorTrait;
use ApiClients\Foundation\Middleware\MiddlewareInterface;
use ApiClients\Foundation\Middleware\PostTrait;
use Psr\Http\Message\RequestInterface;
use React\Promise\CancellablePromiseInterface;
use function React\Promise\resolve;

final class UserAgentMiddleware implements MiddlewareInterface
{
    use PostTrait;
    use ErrorTrait;

    private $cache = [];

    /**
     * @param  RequestInterface            $request
     * @param  array                       $options
     * @return CancellablePromiseInterface
     */
    public function pre(
        RequestInterface $request,
        string $transactionId,
        array $options = []
    ): CancellablePromiseInterface {
        if (!isset($options[UserAgentMiddleware::class][Options::STRATEGY])) {
            return resolve($request);
        }

        $strategy = $options[UserAgentMiddleware::class][Options::STRATEGY];

        if (!\class_exists($strategy)) {
            return resolve($request);
        }

        if (!\is_subclass_of($strategy, UserAgentStrategyInterface::class)) {
            return resolve($request);
        }

        $hash = \md5(\serialize($options[UserAgentMiddleware::class]));
        if (!isset($this->cache[$hash])) {
            /** @var UserAgentStrategyInterface $strategy */
            $strategy = new $strategy();

            $this->cache[$hash] = $strategy->determineUserAgent($request, $options[UserAgentMiddleware::class]);
        }

        return resolve(
            $request->withAddedHeader(
                'User-Agent',
                $this->cache[$hash]
            )
        );
    }
}
