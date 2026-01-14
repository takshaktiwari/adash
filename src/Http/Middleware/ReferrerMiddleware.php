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
                if (empty(session('refer')['method']) || trim(strtolower(session('refer')['method'])) != trim(strtolower($request->method()))) {
                    return $next($request);
                } else {
                    return $this->redirectRoute($request);
                }
            }
        }

        $requestReferFrom = $request->input('refer_from') ?? $request->input('refer.refer_from');

        if ($requestReferFrom) {
            $requestMethod = $request->input('method') ?? $request->input('refer.method');
            $requestReferTo = $request->input('refer_to') ?? $request->input('refer.refer_to');
            if (!$requestReferTo) {
                $requestReferTo = url()->previous();
            }

            if ($requestReferTo && $requestReferFrom) {
                if (!is_array($requestReferFrom)) {
                    $requestReferFrom = [$requestReferFrom];
                }

                $refer = [
                    'refer_to'      =>  $requestReferTo,
                    'refer_from'    =>  $requestReferFrom,
                    'method'        =>  $requestMethod
                ];
                session(['refer' => $refer]);
            }
        }

        return $next($request);
    }

    public function redirectRoute($request)
    {
        $referTo = session('refer')['refer_to'];
        $request->session()->forget('refer');

        return redirect($referTo);
    }
}
