<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @SWG\Get (
     *     path="/api/users",
     *     summary="Lista todos os usuários da aplicação.",
     *     @SWG\Response(response=200, description="Listagem com todos os usuários da aplicação."),
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }
}
