<?php declare(strict_types=1);

namespace ApiClients\Middleware\UserAgent\UserAgentStrategy;

use ApiClients\Middleware\UserAgent\Options;
use ApiClients\Middleware\UserAgent\UserAgentStrategyInterface;
use InvalidArgumentException;
use Jean85\PrettyVersions;
use Psr\Http\Message\RequestInterface;
use function Composed\package;

final class PackageVersionStrategy implements UserAgentStrategyInterface
{
    const USER_AGENT = '%s %s%s powered by PHP API Clients https://php-api-clients.org/';

    public function determineUserAgent(RequestInterface $request, array $options): string
    {
        if (!isset($options[Options::PACKAGE])) {
            throw new InvalidArgumentException('Missing package option');
        }

        $package = $options[Options::PACKAGE];

        $chunks = [];
        $chunks[] = $package;
        $chunks[] = PrettyVersions::getVersion($package)->getShortVersion();
        $chunks[] = $this->getWebsite($package);

        return sprintf(
            self::USER_AGENT,
            ...$chunks
        );
    }

    protected function getWebsite(string $package)
    {
        $package = package($package);
        $homepage = $package->getConfig('homepage');

        if ($homepage === null) {
            return '';
        }

        if (filter_var($homepage, FILTER_VALIDATE_URL) === false) {
            return '';
        }

        return ' (' . $homepage . ') ';
    }
}
