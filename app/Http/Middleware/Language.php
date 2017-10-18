<?php

namespace App\Http\Middleware;

use App\Utils\Models\Language\SelectedLanguage;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class Language
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $defaultLanguageId = 1;


        $lang = $defaultLanguageId;
        $headerlang = null;
        if (Request::server('HTTP_ACCEPT_LANGUAGE') !== null)
        {
            $headerlang = substr(Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        }
        if ($headerlang !== null)
        {
            $language = \App\Models\Language\Language::whereCode($headerlang)->first();
            $lang = $language->id;
        }

        App::singleton(SelectedLanguage::class);
        $instance = App::make(SelectedLanguage::class);
        $instance->setLanguageId($lang);

        return $next($request);
    }
}
