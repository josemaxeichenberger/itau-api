<?php
require_once 'ConexaoMysql.php';
class acessos extends ConexaoMysql
{
    public $id;
    public $cpf_cnpj;
    public $id_user;
    public $email_user;
    public $data_hora;
    public function getId()
    {
        return $this->id;
    }
    public function getCpf_cnpj()
    {
        return $this->cpf_cnpj;
    }
    public function getId_user()
    {
        return $this->id_user;
    }
    public function getEmail_user()
    {
        return $this->email_user;
    }
    public function getData_hora()
    {
        return $this->data_hora;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCpf_cnpj($cpf_cnpj)
    {
        $this->cpf_cnpj = $cpf_cnpj;
    }
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }
    public function setEmail_user($email_user)
    {
        $this->email_user = $email_user;
    }
    public function setData_hora($data_hora)
    {
        $this->data_hora = $data_hora;
    }
    public function Insert()
    {
        $acessos = $this->pdo->prepare("INSERT INTO acessos (
            
            cpf_cnpj,
            id_user,
            email_user,
            data_hora
        ) VALUES (
            
            :cpf_cnpj,
            :id_user,
            :email_user,
            :data_hora
        )");
        $acessos->bindValue(':cpf_cnpj', $this->getCpf_cnpj());
        $acessos->bindValue(':id_user', $this->getId_user());
        $acessos->bindValue(':email_user', $this->getEmail_user());
        $acessos->bindValue(':data_hora', $this->getData_hora());
        try {
            return $acessos->execute();
        } catch (Exception $retorno) {

            $retorno->getMessage();
        }
    }
    public function Update()
    {
        $acessos = $this->pdo->prepare("UPDATE acessos SET
            cpf_cnpj = :cpf_cnpj,
            id_user = :id_user,
            email_user = :email_user,
            data_hora = :data_hora
        WHERE  id = :id
        ");
        $acessos->bindValue(':id', $this->getId());
        $acessos->bindValue(':cpf_cnpj', $this->getCpf_cnpj());
        $acessos->bindValue(':id_user', $this->getId_user());
        $acessos->bindValue(':email_user', $this->getEmail_user());
        $acessos->bindValue(':data_hora', $this->getData_hora());
        try {
            return $acessos->execute();
        } catch (Exception $retorno) {
            $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $acessos = $this->pdo->prepare("DELETE FROM acessos
            WHERE  id = :id
        ");
        $acessos->bindValue(':id', $this->getId());
        try {
            return $acessos->execute();
        } catch (Exception $retorno) {
            $retorno->getMessage();
        }
    }
    public function Select()
    {
        $acessos = $this->pdo->prepare("SELECT * FROM acessos
            WHERE  id = :id
        ");
        $acessos->bindValue(':id', $this->getId());
        try {
            $acessos->execute();
            return $acessos->fetchAll();
        } catch (Exception $retorno) {
            $retorno->getMessage();
        }
    }
    public function SelectAll()
    {
        $acessos = $this->pdo->prepare("SELECT * FROM acessos ");

        try {
            $acessos->execute();
            return $acessos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            $retorno->getMessage();
        }
    }
    public function SelectUltimoAcesso()
    {
        $acessos = $this->pdo->prepare("SELECT * 
        FROM acessos
        WHERE id IN (
            SELECT MAX(id)
            FROM acessos
            GROUP BY id_user
        ) ");

        try {
            $acessos->execute();
            return $acessos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            $retorno->getMessage();
        }
    }
}
