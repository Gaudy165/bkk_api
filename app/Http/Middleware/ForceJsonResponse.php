<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Ensure API routes always negotiate JSON responses even without Accept headers.
     */
    public function handle(Request $request, Closure $next)
    {
        // Make downstream checks (validation, exceptions) treat the request as JSON-capable.
        $request->headers->set('Accept', 'application/json');

        /** @var mixed $response */
        $response = $next($request);

        // Normalize content type on typical responses.
        if ($response instanceof JsonResponse) {
            $response->header('Content-Type', 'application/json');
        }

        return $response;
    }
}
