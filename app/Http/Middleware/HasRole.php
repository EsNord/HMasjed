<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $role = Role::where('name',$role)->first();
        if($role && !Auth::user()->hasRole($role->index)){
            return [
                'status' => 200,
                'data' => 'This procedure is not available for this account because it does not have permissions'
            ];
        };
        return $next($request);
    }
}
