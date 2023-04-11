<?php

class Pessoa {
    
    private static $conn;

    public static function getConnection() {
        
        if (empty(self::$conn)) { 
            $conexao = parse_ini_file('../config/livro.ini');
            $host = $conexao['host'];
            $db = $conexao['db'];
            $user = $conexao['user'];
            $pass = $conexao['pass'];

            self::$conn = new PDO("mysql:host={$host};dbname={$db}, {$user}, {$pass}");
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    public static function save($pessoa) {
        
        $conn = self::getConnection();

        if (empty($pessoa['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM pessoa");
            $row = $result->fetch();
            $pessoa['id'] = (int) $row['next'] + 1;
            
            $sql = "INSERT INTO pessoa (id, nome, endereco, bairro, telefone, email, id_cidade)
            VALUES (:id, :nome, :endereco, :bairro, :telefone, :email, :id_cidade)";
        }
        else {
            $sql = "UPDATE pessoa SET nome = :nome, endereco = :endereco,
            bairro = :bairro, telefone = :telefone, email = :email,
            email = :email, id_cidade = :id_cidade";
        }

        $conn->prepare($sql);
        $conn->execute([':id' =>  $pessoa['id'],
        ':nome' => $pessoa['nome'],
        ':endereco' => $pessoa['endereco'],
        ':bairro' => $pessoa['bairro'],
        ':telefone' => $pessoa['telefone'],
        ':email' => $pessoa['email'],
        ':id_cidade' => $pessoa['id_cidade']]); 
    }

    public static function find($id) {
        $conn = self::getConnection();
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $result = $conn->query("SELECT * FROM pessoa WHERE id = '{$id}'");
        return $result->fetch();
    }

    public static function delete($id) {
        $conn = self::getConnection();
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->query("DELETE FROM pessoa WHERE id = '{$id}'");
        return $result->fetch();
    }

    public static function all() {
        $conn = new PDO('mysql:host=localhost;dbname=livro', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->query("SELECT * FROM pessoa ORDER BY id");
        return $result->fetchAll();

    }
}


