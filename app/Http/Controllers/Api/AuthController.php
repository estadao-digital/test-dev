<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @SWG\Post (
     *     path="/api/auth/login",
     *     summary="Efetua o login do usuário para obter o token",
     *     @SWG\Response(response=200, description="Exibe as informações do token"),
     *     @SWG\Response(response=401, description="Usuário sem permissão de acesso."),
     *          @SWG\Parameter (
     *              description="E-mail do usuário",
     *              name="email",
     *              in="query",
     *              required=true,
     *              type="string"
     *          ),
     *          @SWG\Parameter (
     *              description="Senha do usuário",
     *              name="password",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Usuário sem permissão de acesso.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @SWG\Get (
     *     path="/api/auth/me",
     *     summary="Exibe as informações do usuário logado.",
     *     @SWG\Response(response=200, description="Exibe as informações do usuário logado."),
     *          @SWG\Parameter (
     *              description="Bearer Token",
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *          ),
     * )
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * @SWG\Post (
     *     path="/api/auth/logout",
     *     summary="Efetua o logout do usuário.",
     *     @SWG\Response(response=200, description="Logout efetuado com sucesso."),
     *          @SWG\Parameter (
     *              description="Bearer Token",
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *          ),
     * )
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    /**
     * @SWG\Post (
     *     path="/api/auth/refresh",
     *     summary="Atualiza o token.",
     *     @SWG\Response(response=200, description="Retorna as informações do token."),
     *          @SWG\Parameter (
     *              description="Bearer Token",
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *          ),
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        );
    }
}
