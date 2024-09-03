<?php
require_once 'ConexaoMysqlAncora.php';
class instalacoes extends ConexaoMysqlAncora
{
    public $id;
    public $cnpj;
    public $cpf;
    public $rg;
    public $nome_representante;
    public $razao;
    public $nome_fantasia;
    public $user_name;
    public $telefone;
    public $email_resgiter;
    public $email;
    public $senha;
    public $estado_civil;
    public $nacionalidade;
    public $profissao;
    public $cep;
    public $rua;
    public $bairro;
    public $cidade;
    public $estado;
    public $numero;
    public $complemento;
    public $status;
    public $status_instalacao;
    public $created;
    public $updated;
    public $client_id;
    public $secret_id;
    public $dominio1;
    public $dominio2;
    public $access_token;
    public $webhooks;
    public $webhook_HMAC_SHA256_Secret;

    public function getId()
    {
        return $this->id;
    }
    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function getCpf()
    {
        return $this->cpf;
    }
    public function getRg()
    {
        return $this->rg;
    }
    public function getNome_representante()
    {
        return $this->nome_representante;
    }
    public function getRazao()
    {
        return $this->razao;
    }
    public function getNome_fantasia()
    {
        return $this->nome_fantasia;
    }
    public function getUser_name()
    {
        return $this->user_name;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function getEmail_resgiter()
    {
        return $this->email_resgiter;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function getEstado_civil()
    {
        return $this->estado_civil;
    }
    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }
    public function getProfissao()
    {
        return $this->profissao;
    }
    public function getCep()
    {
        return $this->cep;
    }
    public function getRua()
    {
        return $this->rua;
    }
    public function getBairro()
    {
        return $this->bairro;
    }
    public function getCidade()
    {
        return $this->cidade;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getNumero()
    {
        return $this->numero;
    }
    public function getComplemento()
    {
        return $this->complemento;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getStatus_instalacao()
    {
        return $this->status_instalacao;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function getClient_id()
    {
        return $this->client_id;
    }
    public function getSecret_id()
    {
        return $this->secret_id;
    }
    public function getDominio1()
    {
        return $this->dominio1;
    }
    public function getDominio2()
    {
        return $this->dominio2;
    }
    public function getAccessToken()
    {
        return $this->access_token;
    }
    public function getWebhooks()
    {
        return $this->webhooks;
    }
    public function getWebhookHMACSHA256Secret()
    {
        return $this->webhook_HMAC_SHA256_Secret;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }
    public function setRg($rg)
    {
        $this->rg = $rg;
    }
    public function setNome_representante($nome_representante)
    {
        $this->nome_representante = $nome_representante;
    }

    public function setRazao($razao)
    {
        $this->razao = $razao;
    }
    public function setNome_fantasia($nome_fantasia)
    {
        $this->nome_fantasia = $nome_fantasia;
    }
    public function setUser_name($user_name)
    {
        $this->user_name = $user_name;
    }
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
    public function setEmail_resgiter($email_resgiter)
    {
        $this->email_resgiter = $email_resgiter;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    public function setEstado_civil($estado_civil)
    {
        $this->estado_civil = $estado_civil;
    }
    public function setNacionalidade($nacionalidade)
    {
        $this->nacionalidade = $nacionalidade;
    }
    public function setProfissao($profissao)
    {
        $this->profissao = $profissao;
    }
    public function setCep($cep)
    {
        $this->cep = $cep;
    }
    public function setRua($rua)
    {
        $this->rua = $rua;
    }
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setStatus_instalacao($status_instalacao)
    {
        $this->status_instalacao = $status_instalacao;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function setClient_id($client_id)
    {
        $this->client_id = $client_id;
    }
    public function setSecret_id($secret_id)
    {
        $this->secret_id = $secret_id;
    }
    public function setDominio1($dominio1)
    {
        $this->dominio1 = $dominio1;
    }
    public function setDominio2($dominio2)
    {
        $this->dominio2 = $dominio2;
    }
    public function setAccessToken($token)
    {
        $this->access_token = $token;
    }
    public function setWebhooks($webhooks)
    {
        $this->webhooks = $webhooks;
    }
    public function setWebhookHMACSHA256Secret($secret)
    {
        $this->webhook_HMAC_SHA256_Secret = $secret;
    }
    public function Insert()
    {
        $instalacoes = $this->pdo->prepare("INSERT INTO instalacoes (
            
            cnpj,
            cpf,
            rg,
            nome_representante,
            data_nascimento,
            razao,
            nome_fantasia,
            user_name,
            telefone,
            email_resgiter,
            email,
            senha,
            estado_civil,
            nacionalidade,
            profissao,
            cep,
            rua,
            bairro,
            cidade,
            estado,
            numero,
            complemento,
            status,
            status_instalacao,
            created,
            client_id,
            secret_id,
            dominio1,
            dominio2,
            access_token,
            cep_ancora,
            rua_ancora,
            bairro_ancora,
            cidade_ancora,
            estado_ancora,
            numero_ancora,
            complemento_ancora
        ) VALUES (            
            :cnpj,
            :cpf,
            :rg,
            :nome_representante,
            :data_nascimento,
            :razao,
            :nome_fantasia,
            :user_name,
            :telefone,
            :email_resgiter,
            :email,
            :senha,
            :estado_civil,
            :nacionalidade,
            :profissao,
            :cep,
            :rua,
            :bairro,
            :cidade,
            :estado,
            :numero,
            :complemento,
            :status,
            :status_instalacao,
            :created,
            :client_id,
            :secret_id,
            :dominio1,
            :dominio2,
            :access_token,
            :cep_ancora,
            :rua_ancora,
            :bairro_ancora,
            :cidade_ancora,
            :estado_ancora,
            :numero_ancora,
            :complemento_ancora
        )");

        $instalacoes->bindValue(':cnpj', $this->getCnpj());
        $instalacoes->bindValue(':cpf', $this->getCpf());
        $instalacoes->bindValue(':rg', $this->getRg());
        $instalacoes->bindValue(':nome_representante', $this->getNome_representante());
        $instalacoes->bindValue(':data_nascimento', $this->getData_nascimento());
        $instalacoes->bindValue(':razao', $this->getRazao());
        $instalacoes->bindValue(':nome_fantasia', $this->getNome_fantasia());
        $instalacoes->bindValue(':user_name', $this->getUser_name());
        $instalacoes->bindValue(':telefone', $this->getTelefone());
        $instalacoes->bindValue(':email_resgiter', $this->getEmail_resgiter());
        $instalacoes->bindValue(':email', $this->getEmail());
        $instalacoes->bindValue(':senha', $this->getSenha());
        $instalacoes->bindValue(':estado_civil', $this->getEstado_civil());
        $instalacoes->bindValue(':nacionalidade', $this->getNacionalidade());
        $instalacoes->bindValue(':profissao', $this->getProfissao());
        $instalacoes->bindValue(':cep', $this->getCep());
        $instalacoes->bindValue(':rua', $this->getRua());
        $instalacoes->bindValue(':bairro', $this->getBairro());
        $instalacoes->bindValue(':cidade', $this->getCidade());
        $instalacoes->bindValue(':estado', $this->getEstado());
        $instalacoes->bindValue(':numero', $this->getNumero());
        $instalacoes->bindValue(':complemento', $this->getComplemento());
        $instalacoes->bindValue(':status', $this->getStatus());
        $instalacoes->bindValue(':status_instalacao', $this->getStatus_instalacao());
        $instalacoes->bindValue(':created', $this->getCreated());
        $instalacoes->bindValue(':client_id', $this->getClient_id());
        $instalacoes->bindValue(':secret_id', $this->getSecret_id());
        $instalacoes->bindValue(':dominio1', $this->getDominio1());
        $instalacoes->bindValue(':dominio2', $this->getDominio2());
        $instalacoes->bindValue(':access_token', $this->getAccessToken());
        $instalacoes->bindValue(':cep_ancora', $this->getCep_ancora());
        $instalacoes->bindValue(':rua_ancora', $this->getRua_ancora());
        $instalacoes->bindValue(':bairro_ancora', $this->getBairro_ancora());
        $instalacoes->bindValue(':cidade_ancora', $this->getCidade_ancora());
        $instalacoes->bindValue(':estado_ancora', $this->getEstado_ancora());
        $instalacoes->bindValue(':numero_ancora', $this->getNumero_ancora());
        $instalacoes->bindValue(':complemento_ancora', $this->getComplemento_ancora());
        try {
            if ($instalacoes->execute()) {
                $lastInsertId = $this->pdo->lastInsertId();
                return $lastInsertId;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Verifique se o código de erro é 23000 (violação de restrição de integridade)
            if ($e->getCode() == 23000) {
                // Retorne uma mensagem de erro indicando a duplicação de entrada
                return false;
            } else {
                // Retorne qualquer outra mensagem de erro
                return 'Erro: ' . $e->getMessage();
            }
        }
    }
    public function Update()
    {
        $instalacoes = $this->pdo->prepare("UPDATE instalacoes SET
            razao = :razao,
            nome_fantasia = :nome_fantasia,
            user_name = :user_name,
            data_nascimento=:data_nascimento,
            telefone = :telefone,
            email_resgiter = :email_resgiter,
            email = :email,
            senha = :senha,
            cep = :cep,
            rua = :rua,
            bairro = :bairro,
            cidade = :cidade,
            estado = :estado,
            numero = :numero,
            complemento = :complemento,
          
            cep_ancora = :cep_ancora,
            rua_ancora = :rua_ancora,
            bairro_ancora = :bairro_ancora,
            cidade_ancora = :cidade_ancora,
            estado_ancora = :estado_ancora,
            numero_ancora = :numero_ancora,
            complemento_ancora = :complemento_ancora
        WHERE  id = :id
        ");
        $instalacoes->bindValue(':id', $this->getId());
        $instalacoes->bindValue(':cnpj', $this->getCnpj());
        $instalacoes->bindValue(':razao', $this->getRazao());
        $instalacoes->bindValue(':nome_fantasia', $this->getNome_fantasia());
        $instalacoes->bindValue(':user_name', $this->getUser_name());
        $instalacoes->bindValue(':data_nascimento', $this->getData_nascimento());
        $instalacoes->bindValue(':telefone', $this->getTelefone());
        $instalacoes->bindValue(':email_resgiter', $this->getEmail_resgiter());
        $instalacoes->bindValue(':email', $this->getEmail());
        $instalacoes->bindValue(':senha', $this->getSenha());
        $instalacoes->bindValue(':cep', $this->getCep());
        $instalacoes->bindValue(':rua', $this->getRua());
        $instalacoes->bindValue(':bairro', $this->getBairro());
        $instalacoes->bindValue(':cidade', $this->getCidade());
        $instalacoes->bindValue(':estado', $this->getEstado());
        $instalacoes->bindValue(':numero', $this->getNumero());
        $instalacoes->bindValue(':complemento', $this->getComplemento());

        $instalacoes->bindValue(':cep_ancora', $this->getCep_ancora());
        $instalacoes->bindValue(':rua_ancora', $this->getRua_ancora());
        $instalacoes->bindValue(':bairro_ancora', $this->getBairro_ancora());
        $instalacoes->bindValue(':cidade_ancora', $this->getCidade_ancora());
        $instalacoes->bindValue(':estado_ancora', $this->getEstado_ancora());
        $instalacoes->bindValue(':numero_ancora', $this->getNumero_ancora());
        $instalacoes->bindValue(':complemento_ancora', $this->getComplemento_ancora());
        try {
            return $instalacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $instalacoes = $this->pdo->prepare("DELETE FROM instalacoes
            WHERE  id = :id
        ");
        $instalacoes->bindValue(':id', $this->getId());
        try {
            return $instalacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $instalacoes = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  id = :id
        ");
        $instalacoes->bindValue(':id', $this->getId());
        try {
            $instalacoes->execute();
            return $instalacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectCNPJ()
    {

        $instalacoes = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  cnpj = :cnpj
        ");
        $instalacoes->bindValue(':cnpj', $this->getCnpj());
        try {
            $instalacoes->execute();
            return $instalacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function VerificaDominios()
    {
        $instalacoes = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  dominio1 = :dominio1 or dominio2 = :dominio2
        ");
        $instalacoes->bindValue(':dominio1', $this->getDominio1());
        $instalacoes->bindValue(':dominio2', $this->getDominio2());

        try {
            $instalacoes->execute();
            return $instalacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function VeificaDominio2()
    {
        $instalacoes = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  dominio2 = :dominio2
        ");
        $instalacoes->bindValue(':dominio2', $this->getDominio2());
        try {
            $instalacoes->execute();
            return $instalacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function VeificaDominio1()
    {
        $instalacoes = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  dominio1 = :dominio1
        ");
        $instalacoes->bindValue(':dominio1', $this->getDominio1());
        try {
            $instalacoes->execute();
            return $instalacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function VeificaUserName()
    {
        $instalacoes = $this->pdo->prepare("SELECT * FROM instalacoes
            WHERE  user_name = :user_name
        ");
        $instalacoes->bindValue(':user_name', $this->getUser_name());
        try {
            $instalacoes->execute();
            return $instalacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public function WebhookCreate()
    {
        $instalacoes = $this->pdo->prepare("UPDATE instalacoes SET
         webhooks =:webhooks,
         webhook_HMAC_SHA256_Secret =:webhook_HMAC_SHA256_Secret  
        WHERE  id = :id
        ");
        $instalacoes->bindValue(':id', $this->getId());

        $instalacoes->bindValue(':webhooks', $this->getWebhooks());
        $instalacoes->bindValue(':webhook_HMAC_SHA256_Secret', $this->getWebhookHMACSHA256Secret());
        try {
            return $instalacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public static function find($id)
    {
        // Lógica para criar um novo registro

    }


    public static function UpdateUser($id, $data)
    {
        // Lógica para criar um novo registro

    }
}
