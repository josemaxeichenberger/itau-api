<?php
@session_start();

class ConexaoMysqlAncora {
    protected $pdo;
    
    public function __construct() {
        try {
            // Tente estabelecer a conexão com o banco de dados
            $this->pdo = new PDO('mysql:host=localhost;dbname=law_ancoras', 'law_root', '^F!RXPZpNCB3');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $_SESSION['conect'] =  "Sucesso"; // Defina uma variável de sessão para indicar sucesso na conexão
        } catch (PDOException $e) {
            $_SESSION['conect'] =  "Falha"; // Defina uma variável de sessão para indicar falha na conexão
        }
    }
}


?>
