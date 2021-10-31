<?php

/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\BackendRedirect\ContaoManager;

use Ameotoko\BackendRedirect\AmeotokoBackendRedirectBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(AmeotokoBackendRedirectBundle::class)->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
