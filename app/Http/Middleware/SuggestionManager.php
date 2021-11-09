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
    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session()->get('popup') === true || session()->get('appealed') === true)
            return $next($request);
        if (!session()->exists('suggestion_count')) {
            session()->put('suggestion_count', 0);
            session()->put('transaction_count', 0);
        }
        if (session()->get('suggestion_count') < $this->setting->suggestion_max_count) {
            if (session()->get('transaction_count') < $this->setting->suggestion_freq) {
                session()->increment('transaction_count');
            } else {
                session()->now('popup', true);
                session()->increment('suggestion_count');
                session()->put('transaction_count', 0);
            }
        }
        return $next($request);
    }
}
