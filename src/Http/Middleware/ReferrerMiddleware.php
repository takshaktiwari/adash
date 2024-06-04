<?php

namespace Takshak\Adash\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReferrerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('refer') && session('refer')['refer_to'] && session('refer')['refer_from']) {
            if (in_array(url()->current(), session('refer')['refer_from'])) {
                if (empty(session('refer')['method'])) {
                    return $this->redirectRoute($request);
                } else {
                    if (trim(strtolower(session('refer')['method'])) != trim(strtolower($request->method()))) {
                        return $this->redirectRoute($request);
                    } else {
                        return $next($request);
                    }
                }
            }
        }

        if ($request->input('refer.refer_from')) {
            $method = '';
            $referTo = url()->previous();
            if ($request->input('refer.refer_to')) {
                $referTo = $request->input('refer.refer_to');
            }
            if ($request->input('refer.method')) {
                $method = $request->input('refer.method');
            }

            $referFrom = $request->input('refer.refer_from');

            if ($referTo && $referFrom) {
                if (!is_array($referFrom)) {
                    $referFrom = [$referFrom];
                }

                $refer = [
                    'refer_to'      =>  $referTo,
                    'refer_from'    =>  $referFrom,
                    'method'        =>  $method
                ];

                session(['refer' => $refer]);
            }
        }

        return $next($request);
    }

    public function redirectRoute($request)
    {
        $referTo = session('refer.refer_to');
        $request->session()->forget('refer');

        return redirect($referTo);
    }
}
