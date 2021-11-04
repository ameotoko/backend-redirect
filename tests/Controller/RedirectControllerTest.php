<?php
/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\BackendRedirect\Test\Controller;

use Ameotoko\BackendRedirect\Controller\RedirectController;
use Contao\System;
use Contao\TestCase\ContaoTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

class RedirectControllerTest extends ContaoTestCase
{
    public function testBackendRedirectResponse(): void
    {
        $request = Request::create('https://localhost/contao/redirect?do=members&act=edit&id=42');
        $request->attributes->set('_contao_referer_id', '_OY4TOxP');

        \define('TL_SCRIPT', substr($request->getBaseUrl().$request->getPathInfo(), \strlen($request->getBasePath().'/')));

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $container = $this->getContainerWithContaoConfiguration();
        $container->set('request_stack', $requestStack);

        $framework = $this->mockContaoFramework();
        $framework->expects($this->atLeastOnce())->method('initialize');

        System::setContainer($container);

        $router = $this->createMock(Router::class);
        $router->method('generate')->with('contao_backend')->willReturn('/contao');

        $controller = new RedirectController();

        /** @var RedirectResponse $response */
        $response = $controller($request, $framework, $router);

        $this->assertInstanceOf(RedirectResponse::class, $response);

        $parsedUrl = parse_url($response->getTargetUrl());

        // Path must become /contao instead of /contao/redirect
        $this->assertSame('/contao', $parsedUrl['path']);

        parse_str($parsedUrl['query'], $query);

        // Original query params must be preserved
        $this->assertSame('members', $query['do']);
        $this->assertSame('edit', $query['act']);
        $this->assertSame('42', $query['id']);

        // ref and request token must be added to the response url
        $this->assertSame('_OY4TOxP', $query['ref']);
        $this->assertArrayHasKey('rt', $query);
    }
}
