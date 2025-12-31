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
        // Allows scripts and styles from self and necessary external sources (fonts.bunny.net)
        // 'unsafe-inline' and 'unsafe-eval' are kept for Alpine.js compatibility for now

        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval'; " .
               "style-src 'self' 'unsafe-inline' https://fonts.bunny.net; " .
               "font-src 'self' https://fonts.bunny.net; " .
               "img-src 'self' data: https://www.gravatar.com; " .
               "connect-src 'self';";

        // Dynamically allow Vite dev server origin only in debug mode
        if (config('app.debug')) {
            $host = $request->getHost();
            $scheme = $request->getScheme();
            $vitePort = 5173;

            // Handle HTTP/HTTPS for Vite
            $viteUrl = ($scheme === 'https' ? 'https' : 'http') . "://{$host}:{$vitePort}";
            $viteWs = ($scheme === 'https' ? 'wss' : 'ws') . "://{$host}:{$vitePort}";

            // We also need to allow localhost explicitly if we are accessing via IP
            // because Vite might be serving hot file from localhost:5173 inside the loopback
            // but actually Laravel-Vite plugin usually renders the script tag with the accessible URL.
            // Let's stick to the requested host + localhost for safety in dev.

            $devOrigins = "{$viteUrl} http://localhost:{$vitePort} ws://localhost:{$vitePort}";

            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' {$devOrigins}; " .
                   "style-src 'self' 'unsafe-inline' https://fonts.bunny.net {$devOrigins}; " .
                   "font-src 'self' https://fonts.bunny.net; " .
                   "img-src 'self' data: https://www.gravatar.com; " .
                   "connect-src 'self' {$devOrigins} {$viteWs};";
        }

        $response->headers->set('Content-Security-Policy', $csp);
        // Permissions Policy: Disable sensitive features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Prevent Flash/Acrobat cross-domain policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        return $response;
    }
}
