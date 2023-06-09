<?php declare(strict_types=1);

namespace AshleyHardy\Framework;

use Exception;
use AshleyHardy\Framework\Dispatcher;
use AshleyHardy\Framework\Request;
use AshleyHardy\Framework\Response;
use AshleyHardy\Framework\SystemResponse;
use AshleyHardy\Framework\Middleware;

class Api
{
    public static function run(): void
    {
        try {
            $request = new Request();
            $middlewareResponse = Middleware::checkMiddleware($request);
            if($middlewareResponse instanceof Response) {
                $middlewareResponse->render();
            }

            $dispatcher = new Dispatcher($request);

            $response = $dispatcher->validate() ? $dispatcher->dispatch() : SystemResponse::bad404();
        } catch(Exception $issue) {
            $response = SystemResponse::bad500($issue);
        }

        $response->render();
    }
}