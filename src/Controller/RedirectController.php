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

class RedirectController
{
    public function __invoke(Request $request, ContaoFramework $framework): Response
    {
        // required for REQUEST_TOKEN to be defined
        $framework->initialize();

        if ($srcQuery = $request->getQueryString()) {
            $targetQuery = str_replace('/redirect', '', Backend::addToUrl($srcQuery));
            $url = '/' . StringUtil::ampersand($targetQuery, false);
        } else {
            $url = '/contao';
        }

        return new RedirectResponse($url);
    }
}
