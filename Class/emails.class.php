<?php
require_once 'ConexaoMysql.php';
class emails extends ConexaoMysql
{
    public $id;
    public $recipient_email;
    public $subject;
    public $body;
    public $status;
    public $type;
    public $created_at;
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
    public function setSent_at($sent_at)
    {
        $this->sent_at = $sent_at;
    }
    public function Insert()
    {
        $emails = $this->pdo->prepare("INSERT INTO emails (
            recipient_email,
            subject,
            body,
            status,
            type,
            created_at,
            sent_at
        ) VALUES (
            :recipient_email,
            :subject,
            :body,
            :status,
            :type,
            :created_at,
            :sent_at
        )");
        $emails->bindValue(':recipient_email', $this->getRecipient_email());
        $emails->bindValue(':subject', $this->getSubject());
        $emails->bindValue(':body', $this->getBody());
        $emails->bindValue(':status', $this->getStatus());
        $emails->bindValue(':type', $this->getType());
        $emails->bindValue(':created_at', $this->getCreated_at());
        $emails->bindValue(':sent_at', $this->getSent_at());
        try {
            return $emails->execute();
        } catch (Exception $retorno) {
            $retorno->getMessage();
        }
    }
    public function Update()
    {
        $emails = $this->pdo->prepare("UPDATE emails SET
            recipient_email = :recipient_email,
            subject = :subject,
            body = :body,
            status = :status,
            type = :type,
            created_at = :created_at,
            sent_at = :sent_at
        WHERE  id = :id
        ");
        $emails->bindValue(':id', $this->getId());
        $emails->bindValue(':recipient_email', $this->getRecipient_email());
        $emails->bindValue(':subject', $this->getSubject());
        $emails->bindValue(':body', $this->getBody());
        $emails->bindValue(':status', $this->getStatus());
        $emails->bindValue(':type', $this->getType());
        $emails->bindValue(':created_at', $this->getCreated_at());
        $emails->bindValue(':sent_at', $this->getSent_at());
        try {
            return $emails->execute();
        } catch (Exception $retorno) {
        }
    }
    public function UpdateStatus()
    {
        $emails = $this->pdo->prepare("UPDATE emails SET
            status = :status
        WHERE  id = :id
        ");
        $emails->bindValue(':id', $this->getId());
        $emails->bindValue(':status', $this->getStatus());
        try {
            return $emails->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Delete()
    {
        $emails = $this->pdo->prepare("DELETE FROM emails
            WHERE  id = :id
        ");
        $emails->bindValue(':id', $this->getId());
        try {
            return $emails->execute();
        } catch (Exception $retorno) {
        }
    }
    public function Select()
    {
        $emails = $this->pdo->prepare("SELECT * FROM emails
            WHERE  id = :id
        ");
        $emails->bindValue(':id', $this->getId());
        try {
            $emails->execute();
            return $emails->fetchAll();
        } catch (Exception $retorno) {
        }
    }
    public function SelectStatus()
    {
        $emails = $this->pdo->prepare("SELECT * FROM `emails` WHERE `status` = :status ORDER BY `created_at` LIMIT 100;

        ");
        $emails->bindValue(':status', $this->getStatus());
        try {
            $emails->execute();
            return $emails->fetchAll();
        } catch (Exception $retorno) {
        }
    }



    public function UpdateSend()
    {
        $emails = $this->pdo->prepare("UPDATE emails SET
            status = :status,
            sent_at = :sent_at
        WHERE  id = :id
        ");
        $emails->bindValue(':id', $this->getId());
        $emails->bindValue(':status', $this->getStatus());
        $emails->bindValue(':sent_at', $this->getSent_at());
        try {
            return $emails->execute();
        } catch (Exception $retorno) {
        }
    }

    public function selectFilter(array $filters)
    {
        $query = "SELECT * FROM emails ";
        $whereClauses = [];
        $parameters = [];

        // Verifique e adicione filtros conforme necessário
        if (isset($filters[0])) {
            $whereClauses[] = " status = :status ";
            $parameters[':status'] = $filters[0];
        }

        if (isset($filters[1])) {
            $whereClauses[] = " DATE(sent_at) = :sent_at ";
            $parameters[':sent_at'] = $filters[1];
        }
        if (count($whereClauses) > 0) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        $stmt = $this->pdo->prepare($query);
        foreach ($parameters as $param => $value) {
            if (is_array($value)) {
                // Se for um array, escolha como transformá-lo em um valor que possa ser vinculado
                $stmt->bindValue($param, implode(',', $value));  // Exemplo: converter array em uma string separada por vírgulas
            } else {
                $stmt->bindValue($param, $value);  // Valor único
            }
        }
        
        try {
            $stmt->execute();  
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (Exception $e) {
            throw new Exception("Erro ao executar a consulta: " . $e->getMessage());
        }
    }
}
