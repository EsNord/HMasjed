<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPermisstio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $permission = Permission::where('name',$permission)->first();
        if($permission && !Auth::user()->hasPermission($permission->index)){
            return [
                'status' => 200,
                'data' => 'This procedure is not available for this account because it does not have permissions'
            ];
        };
        return $next($request);
    }
}
