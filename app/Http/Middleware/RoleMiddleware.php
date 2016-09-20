<?php

// namespace App\Http\Middleware;

// use Closure;
// use App;
// use Auth;

// class RoleMiddleware
// {    
//     public function handle($request, Closure $next, $role)
//     {
//         if (Auth::user() && Auth::user()->role != $role) {
//             return App::abort(Auth::check() ? 403 : 401, Auth::check() ? 'Forbidden' : 'Unauthorized');
//         }

//         return $next($request);
//     }
//     $user = JWTAuth::parseToken()->toUser();

// $hasAdminRole = $user>hasRole('Admin');

//             if (!$hasAdminRole) {
//                 return $this->setStatusCode(403)->respondWithError('User does not have permission!');
//             }﻿
//}

