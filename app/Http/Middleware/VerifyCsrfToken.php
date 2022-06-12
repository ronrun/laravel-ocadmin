<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;
use Closure;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            return tap($next($request), function ($response) use ($request) {
                if ($this->shouldAddXsrfTokenCookie()) {
                    $this->addCookieToResponse($request, $response);
                }
            });
        }

        //throw new TokenMismatchException('CSRF token mismatch.');

        //logout
        if($request->route()->named('lang.logout')) {
            $this->except[] = route('lang.logout');
            return parent::handle($request, $next);
        }
        
        if($request->route()->named('lang.admin.logout')) {
            $this->except[] = route('lang.admin.logout');
            return parent::handle($request, $next);
        }

        throw new TokenMismatchException('CSRF token mismatch.');
    }
}
