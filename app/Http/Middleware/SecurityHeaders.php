<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking: allow same origin (safer default than DENY)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Control referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Enforce HTTPS (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // Content Security Policy
        $csp = "default-src 'self'; " .
               "font-src 'self' https://fonts.bunny.net; " .
               "img-src 'self' data: https://www.gravatar.com; ";

        // Base allowances (Alpine.js needs unsafe-inline/unsafe-eval)
        $scriptSrc = "'self' 'unsafe-inline' 'unsafe-eval'";
        $styleSrc = "'self' 'unsafe-inline' https://fonts.bunny.net";
        $connectSrc = "'self'";

        // Allow Vite dev server and other dev tools in local environment
        if (app()->isLocal()) {
            // Permissive policy for development: allow any http/https/ws source
            // This prevents blocking regardless of what port or host Vite uses
            $scriptSrc .= " http: https: 'unsafe-inline' 'unsafe-eval'";
            $styleSrc .= " http: https: 'unsafe-inline'";
            $connectSrc .= " http: https: ws: wss:";
        }

        $csp .= "script-src {$scriptSrc}; " .
                "style-src {$styleSrc}; " .
                "connect-src {$connectSrc};";

        // $response->headers->set('Content-Security-Policy', $csp);
        // Permissions Policy: Disable sensitive features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Prevent Flash/Acrobat cross-domain policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        return $response;
    }
}