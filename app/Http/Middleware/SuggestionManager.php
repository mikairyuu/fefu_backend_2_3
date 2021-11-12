<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class SuggestionManager
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
        if (session()->get('appealed') === true)
            return $next($request);
        if (!session()->exists('suggestion_count')) {
            session()->put('suggestion_count', 0);
            session()->put('transaction_count', 0);
        }
        $setting = app(Setting::class);
        if (session()->get('suggestion_count') < $setting->suggestion_max_count) {
            if (session()->get('transaction_count') < $setting->suggestion_freq) {
                session()->increment('transaction_count');
            } else {
                session()->now('popup', true);
                session()->put('popup_message_shown', false);
                session()->increment('suggestion_count');
                session()->put('transaction_count', 0);
            }
        }
        return $next($request);
    }
}
