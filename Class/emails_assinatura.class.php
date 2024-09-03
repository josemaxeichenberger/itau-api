<?php
require_once 'ConexaoMysql.php';
class emails_assinatura extends ConexaoMysql
{
    public $id;
    public $recipient_email;
    public $subject;
    public $body;
    public $status;
    public $type;
    public $created_at;
    public $data_sendto;
    public $sent_at;
    public function getId()
    {
        return $this->id;
    }
    public function getRecipient_email()
    {
        return $this->recipient_email;
    }
    public function getSubject()
    {
        return $this->subject;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getCreated_at()
    {
        return $this->created_at;
    }
    public function getData_sendto()
    {
        return $this->data_sendto;
    }
    public function getSent_at()
    {
        return $this->sent_at;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setRecipient_email($recipient_email)
    {
        $this->recipient_email = $recipient_email;
    }
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    public function setBody($body)
    {
        $this->body = $body;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }
    public function setData_sendto($data_sendto)
    {
        $this->data_sendto = $data_sendto;
    }
    public function setSent_at($sent_at)
    {
        $this->sent_at = $sent_at;
    }
    public function Insert()
    {
        $emails_assinatura = $this->pdo->prepare("INSERT INTO emails_assinatura (
            recipient_email,
            subject,
            body,
            status,
            type,
            created_at,
            data_sendTo,
            sent_at
        ) VALUES (
            :recipient_email,
            :subject,
            :body,
            :status,
            :type,
            :created_at,
            :data_sendto,
            :sent_at
        )");
        $emails_assinatura->bindValue(':recipient_email', $this->getRecipient_email());
        $emails_assinatura->bindValue(':subject', $this->getSubject());
        $emails_assinatura->bindValue(':body', $this->getBody());
        $emails_assinatura->bindValue(':status', $this->getStatus());
        $emails_assinatura->bindValue(':type', $this->getType());
        $emails_assinatura->bindValue(':created_at', $this->getCreated_at());
        $emails_assinatura->bindValue(':data_sendto', $this->getData_sendto());
        $emails_assinatura->bindValue(':sent_at', $this->getSent_at());
        try {
            return $emails_assinatura->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $emails_assinatura = $this->pdo->prepare("UPDATE emails_assinatura SET
            status = :status,
            sent_at = :sent_at
             WHERE id = :id
        ");
        $emails_assinatura->bindValue(':id', $this->getId());
        $emails_assinatura->bindValue(':status', $this->getStatus());
        $emails_assinatura->bindValue(':sent_at', $this->getSent_at());
        try {
            return $emails_assinatura->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Delete()
    {
        $emails_assinatura = $this->pdo->prepare("DELETE FROM emails_assinatura
        ");
        try {
            return $emails_assinatura->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Select()
    {
        $emails_assinatura = $this->pdo->prepare("SELECT * FROM emails_assinatura
        ");
        try {
            $emails_assinatura->execute();
            return $emails_assinatura->fetchAll();
        } catch (Exception $retorno) {
        }
    }
    public function SelectStatus()
    {
        $emails_assinatura = $this->pdo->prepare("SELECT * FROM emails_assinatura WHERE data_sendto <= :data_sendto and status = :status");
        $emails_assinatura->bindValue(':data_sendto', $this->getData_sendto());
        $emails_assinatura->bindValue(':status', $this->getStatus());
        try {
            $emails_assinatura->execute();
            return $emails_assinatura->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
        }
    }
    
}
