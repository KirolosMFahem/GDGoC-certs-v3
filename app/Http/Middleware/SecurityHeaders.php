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

        // CSP Defaults
        $defaultSrc = "'self'";
        $scriptSrc = "'self' 'unsafe-inline' 'unsafe-eval'";
        $styleSrc = "'self' 'unsafe-inline' https://fonts.bunny.net";
        $fontSrc = "'self' https://fonts.bunny.net";
        $imgSrc = "'self' data: https://www.gravatar.com";
        $connectSrc = "'self'";

        // Allow Vite dev server in local environment
        if (app()->environment('local')) {
            // Vite default port is 5173.
            // We allow localhost and the current request host (for Docker/network access)
            $host = $request->getHost();
            $viteUrls = [
                "http://localhost:5173",
                "ws://localhost:5173",
                "http://{$host}:5173",
                "ws://{$host}:5173"
            ];

            $vitePolicy = implode(' ', array_unique($viteUrls));

            $scriptSrc .= " " . $vitePolicy;
            $styleSrc .= " " . $vitePolicy;
            $connectSrc .= " " . $vitePolicy;
            $imgSrc .= " " . $vitePolicy; // Vite often serves assets from its own server
        }

        // Content Security Policy
        // Allows scripts and styles from self and necessary external sources (fonts.bunny.net)
        // 'unsafe-inline' and 'unsafe-eval' are kept for Alpine.js compatibility for now
        $csp = "default-src {$defaultSrc}; " .
               "script-src {$scriptSrc}; " .
               "style-src {$styleSrc}; " .
               "font-src {$fontSrc}; " .
               "img-src {$imgSrc}; " .
               "connect-src {$connectSrc};";

        $response->headers->set('Content-Security-Policy', $csp);
        // Permissions Policy: Disable sensitive features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Prevent Flash/Acrobat cross-domain policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        return $response;
    }
}
