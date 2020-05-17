<?php

namespace App\Libs\Traits;


trait  Ratelimit
{
    public function getLimitKey(\Illuminate\Http\Request $request)
    {
        $limitKey = sha1(sprintf("%s|%s|%s", $request->method(), $request->path(), $request->ip()));
        return $limitKey;
    }
}