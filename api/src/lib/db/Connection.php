<?php

namespace app\lib\db;

use DateTime;
use DateTimeZone;
use Exception;
use PDO;

abstract class Connection {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                $db = include_once __DIR__ . '/../../../config/db.php';
                $tz = (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))->format('P');
                $host = "mysql:dbname={$db['database']};host={$db['dsn']};charset=utf8";
                self::$instance = new PDO($host, $db['user'], $db['password']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec("SET time_zone='$tz';");
            } catch (Exception $e) {
                $e->getMessage(); die;
            }
        }

        return self::$instance;
    }
}