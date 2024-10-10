<?php
require_once('../config/config.inc.php');

class Database {
    
    static public $lastId;

    public static function getInstance() { 
        try { 
            return new PDO(DSN, USUARIO, SENHA);
        } catch (PDOException $e) { 
            error_log("Connection error: " . $e->getMessage()); // Log error
            throw new Exception("Database connection error."); // Re-throw exception for further handling
        }
    }

    public static function conectar() {
        return self::getInstance();
    }

    public static function preparar($conexao, $sql) {
        return $conexao->prepare($sql);
    }

    public static function vincular($comando, $parametros = []) {
        foreach ($parametros as $key => $value) {
            $comando->bindValue($key, $value); 
        }
        return $comando;
    }

    public static function executar($sql, $parametros = []) {
        $conexao = self::conectar();
        $comando = self::preparar($conexao, $sql);
        $comando = self::vincular($comando, $parametros);
        try {
            $comando->execute();
            return $comando;
        } catch (PDOException $e) {
            error_log("Execution error: " . $e->getMessage()); // Log error
            throw new Exception("Error executing the SQL command."); // Re-throw exception
        }
    }
}
