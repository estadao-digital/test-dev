<?php

/**
 * Description of registro
 *
 * @author gerlisson Paulino
 */

namespace Registry;

use Closure;

class Registry
{

    /**
     * @Var DOP A conexão com o banco de dados
     */
    protected static $registry = array();

    /**
     * Adicione um novo resolvedor para a matriz registro.
     * @ Param string $ name O id
     * Encerramento objeto @ param $ resolver que cria uma instância
     * @ Return void
     * /eturn void
     */
    public static function register($name, Closure $resolve) {
        static::$registry[$name] = $resolve;
    }

    /**
     * Criar a instância
     * @ Param string $ name O id
     * @ Return misturado
     */
    public static function resolve($name) {
        if (static::registered($name)) {
            $name = static::$registry[$name];
            return $name();
        }

        throw new \Exception('Nothing registered with that name, fool.');
    }

    /**
     * Determinar se o ID é registrado
     * @ Param string $ name O id
     * @ Return bool Se a ID existe ou não
     */
    public static function registered($name) {
        return array_key_exists($name, static::$registry);
    }

}