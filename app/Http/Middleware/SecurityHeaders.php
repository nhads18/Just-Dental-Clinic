<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds baseline security response headers to every web response.
 *
 * The Content-Security-Policy is intentionally permissive (allows the inline
 * scripts/styles this app currently uses plus its known CDNs) so it hardens
 * clickjacking / mixed-content without breaking pages. Tighten it over time.
 * Toggle CSP with SECURITY_CSP_ENABLED=false if needed.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-XSS-Protection', '0');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        // Do not advertise the exact PHP version.
        $response->headers->remove('X-Powered-By');

        // HSTS only over HTTPS (never on plain-HTTP local dev).
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        if (filter_var(env('SECURITY_CSP_ENABLED', true), FILTER_VALIDATE_BOOL)) {
            $csp = implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://js.pusher.com https://cdn.jsdelivr.net",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdnjs.cloudflare.com",
                "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com",
                "img-src 'self' data: https:",
                "connect-src 'self' https://api.groq.com https://*.pusher.com wss://*.pusher.com",
                "frame-src 'self' https://www.google.com",
                "frame-ancestors 'self'",
                "base-uri 'self'",
                "form-action 'self'",
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
