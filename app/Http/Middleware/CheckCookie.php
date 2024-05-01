<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ModulController;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!auth()->check()) {
        //     return redirect()->route('login');
        // }
        //Handle this user can access this config route or not
        $class = explode('/', Route::current()->uri);
        $method = Route::current()->getActionMethod();
        $authuser = json_decode($_COOKIE['user']);

        $checkmodul = (new ModulController())->getModulByUser($authuser->uuid);

        if (!$this->findObjectByFolder(json_decode($checkmodul), $class[1])) {
            abort(403, 'Unauthorized');
        } else {
            if (array_key_exists(2, $class)) {
                $status = [
                    'config_modul' => $class[1],
                ];
                $checkaccess  = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                    ->withOptions(['verify' => false])
                    ->withToken($_COOKIE['access-token'])
                    ->get(config('app.api_url') . 'getmenu', $status);

                if (!$this->findObjectByLink(json_decode($checkaccess), $class[1] . "/" . $class[2])) {
                    abort(403, 'Unauthorized');
                }
            }
        }
        // if (isset($_COOKIE['access-token'])) {
        //     try {
        //         dd(config('jwt.key'), config('jwt.alg'));
        //         $payload = JWT::decode($_COOKIE['access-token'], new Key(config('jwt.key'), config('jwt.alg')));

        //         Auth::loginUsingId($payload->sub);

        //         return $next($request);
        //     } catch (\Throwable $th) {
        //         throw $th;
        //     }
        // }

        return $next($request);

        // return redirect()->route('login');
    }

    function findObjectByFolder($array, $folder)
    {
        foreach ($array as $object) {
            if ($object->folder == $folder) {
                return true;
            }
        }
        return false;
    }

    function findObjectByLink($array, $link)
    {
        foreach ($array as $object) {
            if ($object->link === $link) {
                return true;
            }
            // If the object has children, recursively search through them
            if (!empty($object->child)) {
                $found = $this->findObjectByLink($object->child, $link);
                if ($found !== null) {
                    return true;
                }
            }
        }
        return null; // If object not found
    }
}
