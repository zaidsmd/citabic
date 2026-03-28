<?php

namespace App\Http\Middleware;

use App\Services\GuestPageCache;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvalidateGuestPageCache
{
    public function __construct(private GuestPageCache $guestPageCache) {}

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (
            in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)
            && $response->getStatusCode() < 400
        ) {
            $this->guestPageCache->bump();
        }

        return $response;
    }
}
