<?php declare(strict_types=1);

namespace App\Http\Controllers\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarrosService;

class HomeController extends Controller
{
    /**
     * Renderiza a home da aplicação.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function default()
    {
        return view('welcome', [
            'section' => 'home'
        ]);
    }
}