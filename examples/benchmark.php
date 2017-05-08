<?php declare(strict_types=1);

use ApiClients\Middleware\UserAgent\Options;
use ApiClients\Middleware\UserAgent\UserAgentMiddleware;
use ApiClients\Middleware\UserAgent\UserAgentStrategy\PackageVersionStrategy;
use RingCentral\Psr7\Request;

require dirname(__DIR__) . '/vendor/autoload.php';

$options = [
    UserAgentMiddleware::class => [
        Options::STRATEGY => PackageVersionStrategy::class,
        Options::PACKAGE => 'api-clients/middleware-user-agent',
    ],
];
$request = new Request('GET', 'https://example.com/');
$middleware = new UserAgentMiddleware();

$start = time();
for ($i = 0; $i < 1000000; $i++) {
    $middleware->pre(clone $request, $options);
}
echo 'Took: ', (time() - $start), ' seconds', PHP_EOL;