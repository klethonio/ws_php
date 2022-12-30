<?php

/**
 * Dresciption of Conn [DB]
 * connection abstact Class. Sigleton Pattern
 * Return a PDO Object through getConn();
 * @author Klethônio Ferreira
 */
class Conn
{
    private static $host = HOST;
    private static $user = USER;
    private static $pass = PASS;
    private static $dbsa = DBSA;

    /** @var PDO */
    private static $connect = null;

    /**
     * Connect to database with Singleton Pattern.
     * Return a PDO Object.
     */
    private static function toConnect(): PDO
    {
        try {
            if (self::$connect == null) {
                $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbsa;
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$connect = new PDO($dsn, self::$user, self::$pass, $options);
            }
        } catch (PDOException $e) {
            PHPError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }

        self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$connect;
    }

    /** Retorna um objeto Sigleton Pattern. */
    final public static function getConn(): PDO
    {
        return self::toConnect();
    }

}
