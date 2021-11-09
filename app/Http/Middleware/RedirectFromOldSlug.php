<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class RedirectFromOldSlug
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $full_url = parse_url($request->url());
        $url_tail = array_key_exists("path", $full_url) ? $full_url['path'] : '';
        $redirect = Redirect::where('old_slug', $url_tail)->orderByDesc('created_at')->orderByDesc('id')->first();
        $last_redirect = null;
        while ($redirect !== null) {
            $url_tail = $redirect->new_slug;
            $last_redirect = $redirect;
            $redirect = Redirect::where('old_slug', $url_tail)->where('created_at', '>', $redirect->created_at)->orderByDesc('created_at')->orderByDesc('id')->first();
        }
        if ($last_redirect != null) {
            return redirect($url_tail);
        }

        return $next($request);
    }
}
