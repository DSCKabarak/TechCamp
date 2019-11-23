<?php

namespace App\Http\Middleware;

use App\Attendize\Utils;
use App\Models\Organiser;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use JavaScript;

class SetViewVariables
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Utils::installed()) {
            /*
             * Share the organizers across all views
             */
            View::share('organisers', Organiser::scope()->get());

            /*
             * Set up JS across all views
             */
            JavaScript::put([
                'User'                => [
                    'full_name'    => Auth::check() ? Auth::user()->full_name : '',
                    'email'        => Auth::check() ? Auth::user()->email : '',
                    'is_confirmed' => Auth::check() ? Auth::user()->is_confirmed : false,
                ],
                'DateTimeFormat'      => config('attendize.default_date_picker_format'),
                'DateSeparator'       => config('attendize.default_date_picker_seperator'),
                'GenericErrorMessage' => trans('Controllers.whoops'),
            ]);
        }

        return $next($request);
    }
}
