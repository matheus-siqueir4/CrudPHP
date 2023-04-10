<?php

class Cidade {
    public static function all() {
        $conn = new PDO('mysql:host=localhost;dbname=livro', 'root', '');
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn -> query("SELECT id, nome FROM cidade");
        return $result -> fetchAll();
    }
}