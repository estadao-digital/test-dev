<?php 

namespace App\Http\Middleware;

class CorsMiddleware {
  public function handle($request, \Closure $next)
  {
    $response = $next($request);
    $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
    $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Accept', 'application/json'); 
    //$response->header('Access-Control-Allow-Origin', 'http://localhost:4200');
    return $response;
  }
}