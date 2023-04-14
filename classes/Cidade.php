<?php

class Cidade {

    private static $conn;

    public static function getConnection() {
        if (empty(self::$conn)) {
            $conexao = parse_ini_file('../config/livro.ini');
            $host = $conexao['host'];
            $db = $conexao['db'];
            $user = $conexao['user'];
            $pass = $conexao['pass'];

            self::$conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$conn;
    }
    public static function all() {
        $conn = self::getConnection();

        $result = $conn->prepare("SELECT id, nome FROM cidade");
        $result->execute();
        return $result->fetchAll();

    }
}