<?php
require_once 'ConexaoMysqlAncora.php';
class ancora extends ConexaoMysqlAncora
{

    public $id;
    public $razao;
    public $email;
    public $cnpj;
    public $senha;
    public function getId()
    {
        return $this->id;
    }
    public function getRazao()
    {
        return $this->razao;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function getSenha()
    {
        return $this->cnpj;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setRazao($razao)
    {
        $this->razao = $razao;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }
    public function setSenha($cnpj)
    {
        $this->cnpj = $cnpj;
    }
    public function Insert()
    {
        $ancora = $this->pdo->prepare("INSERT INTO ancora (
            razao,
            email,
            cnpj,
            senha
        ) VALUES (
            :id,
            :razao,
            :email,
            :cnpj,
            :senha
        )");
        $ancora->bindValue(':razao', $this->getRazao());
        $ancora->bindValue(':email', $this->getEmail());
        $ancora->bindValue(':cnpj', $this->getCnpj());
        $ancora->bindValue(':senha', $this->getSenha());

        try {
            return $ancora->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $ancora = $this->pdo->prepare("UPDATE ancora SET
            razao = :razao,
            email = :email,
            cnpj = :cnpj
        WHERE  id = :id
        ");
        $ancora->bindValue(':id', $this->getId());
        $ancora->bindValue(':razao', $this->getrazao());
        $ancora->bindValue(':email', $this->getemail());
        $ancora->bindValue(':cnpj', $this->getcnpj());
        try {
            return $ancora->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $ancora = $this->pdo->prepare("DELETE FROM ancora
            WHERE  id = :id
        ");
        $ancora->bindValue(':id', $this->getId());
        try {
            return $ancora->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $ancora = $this->pdo->prepare("SELECT * FROM ancora
            WHERE  id = :id
        ");
        $ancora->bindValue(':id', $this->getId());
        try {
            $ancora->execute();
            return $ancora->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectAll()
    {
        $ancora = $this->pdo->prepare("SELECT * FROM ancora ");
        try {
            $ancora->execute();
            return $ancora->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public function login()
    {
        $ancora = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  email = :email and senha =:senha
        ");
        $ancora->bindValue(':email', $this->getEmail());
        $ancora->bindValue(':senha', $this->getSenha());
        try {
            $ancora->execute();
            return $ancora->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    
}
