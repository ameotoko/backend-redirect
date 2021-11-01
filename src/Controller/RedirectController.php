<?php

/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\BackendRedirect\Controller;

use Contao\Backend;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RedirectController
{
    public function __invoke(Request $request, ContaoFramework $framework, RouterInterface $router): Response
    {
        // required for REQUEST_TOKEN to be defined
        $framework->initialize();
        $url = $router->generate('contao_backend');

        if ($srcQuery = $request->getQueryString()) {
            $url = StringUtil::ampersand(str_replace($request->getPathInfo(), $url, '/' . Backend::addToUrl($srcQuery)), false);
        }

        return new RedirectResponse($url);
    }
}
