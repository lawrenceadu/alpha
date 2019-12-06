<?php 
    use Psr\Http\Message\ServerRequestInterface;
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    if (!function_exists('params')) {
        function params(ServerRequestInterface $request, Bool $as_array = false)
        {
            return json_decode($request->getBody(), $as_array);
        }
    };

    if (!function_exists('splitName')) {
        function splitName($fullname)
        {
            $fullname = explode(' ', Str::title($fullname));
            return [$fullname[0], end($fullname)];
        }
    }

    if (!function_exists('now')) {
        function now()
        {
            return Carbon::now();
        }
    }

    if (!function_exists('today')) {
        function today()
        {
            return Carbon::today();
        }
    }