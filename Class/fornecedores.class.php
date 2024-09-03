<?php
require_once 'ConexaoMysql.php';
class fornecedores extends ConexaoMysql
{
    public $id;
    public $razao;
    public $tipo;
    public $cnpj;
    public $email;
    public $telefone;
    public $representante;
    public $cpf;
    public $rua;
    public $numero;
    public $bairro;
    public $cidade;
    public $estado;
    public $cep;
    public $boleto;
    public $ted;
    public $tac;
    public $limite;
    public $juros;
    public $status;
    public $clicksign_key;
    public $banco;
    public $conta;
    public $agencia;
    public $updated;
    public function getId()
    {
        return $this->id;
    }
    public function getRazao()
    {
        return $this->razao;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function getRepresentante()
    {
        return $this->representante;
    }
    public function getCpf()
    {
        return $this->cpf;
    }
    public function getRua()
    {
        return $this->rua;
    }
    public function getNumero()
    {
        return $this->numero;
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
    public function getCep()
    {
        return $this->cep;
    }
    public function getBoleto()
    {
        return $this->boleto;
    }
    public function getTed()
    {
        return $this->ted;
    }
    public function getTac()
    {
        return $this->tac;
    }
    public function getLimite()
    {
        return $this->limite;
    }
    public function getJuros()
    {
        return $this->juros;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getClicksign_key()
    {
        return $this->clicksign_key;
    }
    public function getBanco()
    {
        return $this->banco;
    }
    public function getConta()
    {
        return $this->conta;
    }
    public function getAgencia()
    {
        return $this->agencia;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setRazao($razao)
    {
        $this->razao = $razao;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
    public function setRepresentante($representante)
    {
        $this->representante = $representante;
    }
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }
    public function setRua($rua)
    {
        $this->rua = $rua;
    }
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
    public function setCep($cep)
    {
        $this->cep = $cep;
    }
    public function setBoleto($boleto)
    {
        $this->boleto = $boleto;
    }
    public function setTed($ted)
    {
        $this->ted = $ted;
    }
    public function setTac($tac)
    {
        $this->tac = $tac;
    }
    public function setLimite($limite)
    {
        $this->limite = $limite;
    }
    public function setJuros($juros)
    {
        $this->juros = $juros;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setClicksign_key($clicksign_key)
    {
        $this->clicksign_key = $clicksign_key;
    }
    public function setBanco($banco)
    {
        $this->banco = $banco;
    }
    public function setConta($conta)
    {
        $this->conta = $conta;
    }
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function Insert()
    {
        $fornecedores = $this->pdo->prepare("INSERT INTO fornecedores (
            razao,
            tipo,
            cnpj,
            email,
            telefone,
            representante,
            cpf,
            rua,
            numero,
            bairro,
            cidade,
            estado,
            cep,
            boleto,
            ted,
            tac,
            limite,
            juros,
            status,
            clicksign_key,
            banco,
            conta,
            agencia,
            updated
        ) VALUES (
            :id,
            :razao,
            :tipo,
            :cnpj,
            :email,
            :telefone,
            :representante,
            :cpf,
            :rua,
            :numero,
            :bairro,
            :cidade,
            :estado,
            :cep,
            :boleto,
            :ted,
            :tac,
            :limite,
            :juros,
            :status,
            :clicksign_key,
            :banco,
            :conta,
            :agencia,
            :updated
        )");
        $fornecedores->bindValue(':razao', $this->getRazao());
        $fornecedores->bindValue(':tipo', $this->getTipo());
        $fornecedores->bindValue(':cnpj', $this->getCnpj());
        $fornecedores->bindValue(':email', $this->getEmail());
        $fornecedores->bindValue(':telefone', $this->getTelefone());
        $fornecedores->bindValue(':representante', $this->getRepresentante());
        $fornecedores->bindValue(':cpf', $this->getCpf());
        $fornecedores->bindValue(':rua', $this->getRua());
        $fornecedores->bindValue(':numero', $this->getNumero());
        $fornecedores->bindValue(':bairro', $this->getBairro());
        $fornecedores->bindValue(':cidade', $this->getCidade());
        $fornecedores->bindValue(':estado', $this->getEstado());
        $fornecedores->bindValue(':cep', $this->getCep());
        $fornecedores->bindValue(':boleto', $this->getBoleto());
        $fornecedores->bindValue(':ted', $this->getTed());
        $fornecedores->bindValue(':tac', $this->getTac());
        $fornecedores->bindValue(':limite', $this->getLimite());
        $fornecedores->bindValue(':juros', $this->getJuros());
        $fornecedores->bindValue(':status', $this->getStatus());
        $fornecedores->bindValue(':clicksign_key', $this->getClicksign_key());
        $fornecedores->bindValue(':banco', $this->getBanco());
        $fornecedores->bindValue(':conta', $this->getConta());
        $fornecedores->bindValue(':agencia', $this->getAgencia());
        $fornecedores->bindValue(':updated', $this->getUpdated());
        try {
            return $fornecedores->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $fornecedores = $this->pdo->prepare("UPDATE fornecedores SET
            email = :email,
            telefone = :telefone,
            representante = :representante,
            cpf = :cpf,
            rua = :rua,
            numero = :numero,
            bairro = :bairro,
            cidade = :cidade,
            estado = :estado,
            cep = :cep,
            boleto = :boleto,
            ted = :ted,
            tac = :tac,
            limite = :limite,
            juros = :juros,
            banco = :banco,
            conta = :conta,
            agencia = :agencia,
            updated = :updated
            WHERE  id = :id
        ");
        $fornecedores->bindValue(':id', $this->getId());
        $fornecedores->bindValue(':email', $this->getEmail());
        $fornecedores->bindValue(':telefone', $this->getTelefone());
        $fornecedores->bindValue(':representante', $this->getRepresentante());
        $fornecedores->bindValue(':cpf', $this->getCpf());
        $fornecedores->bindValue(':rua', $this->getRua());
        $fornecedores->bindValue(':numero', $this->getNumero());
        $fornecedores->bindValue(':bairro', $this->getBairro());
        $fornecedores->bindValue(':cidade', $this->getCidade());
        $fornecedores->bindValue(':estado', $this->getEstado());
        $fornecedores->bindValue(':cep', $this->getCep());
        $fornecedores->bindValue(':boleto', $this->getBoleto());
        $fornecedores->bindValue(':ted', $this->getTed());
        $fornecedores->bindValue(':tac', $this->getTac());
        $fornecedores->bindValue(':limite', $this->getLimite());
        $fornecedores->bindValue(':juros', $this->getJuros());
        $fornecedores->bindValue(':banco', $this->getBanco() ?? null);
        $fornecedores->bindValue(':conta', $this->getConta() ?? null);
        $fornecedores->bindValue(':agencia', $this->getAgencia() ?? null);
        
        $fornecedores->bindValue(':updated', $this->getUpdated());
        try {
            return $fornecedores->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Delete()
    {
        $fornecedores = $this->pdo->prepare("DELETE FROM fornecedores
            WHERE  id = :id
        ");
        $fornecedores->bindValue(':id', $this->getId());
        try {
            return $fornecedores->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $fornecedores = $this->pdo->prepare("SELECT * FROM fornecedores ");
        try {
            $fornecedores->execute();
            return $fornecedores->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectTipo()
    {
        $fornecedores = $this->pdo->prepare("SELECT * FROM fornecedores WHERE tipo = :tipo");
        $fornecedores->bindValue(':tipo', $this->getTipo());

        try {
            $fornecedores->execute();
            return $fornecedores->fetchAll();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Login()
    {
        $fornecedores = $this->pdo->prepare("SELECT * FROM fornecedores
            WHERE  email = :email and cnpj = :cnpj
        ");
        $fornecedores->bindValue(':email', $this->getEmail());
        $fornecedores->bindValue(':cnpj', $this->getCnpj());

        try {
            $fornecedores->execute();
            return $fornecedores->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectCnpj()
    {
        $fornecedores = $this->pdo->prepare("SELECT * FROM fornecedores
            WHERE   cnpj = :cnpj
        ");
        $fornecedores->bindValue(':cnpj', $this->getCnpj());

        try {
            $fornecedores->execute();
            return $fornecedores->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectID()
    {
        $fornecedores = $this->pdo->prepare("SELECT * FROM fornecedores
            WHERE   id = :id
        ");
        $fornecedores->bindValue(':id', $this->getId());

        try {
            $fornecedores->execute();
            return $fornecedores->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function UpdateFornecedor()
    {
        $fornecedores = $this->pdo->prepare("UPDATE fornecedores SET
            email = :email,
            telefone = :telefone,
            representante = :representante,
            cpf = :cpf,
            rua = :rua,
            numero = :numero,
            bairro = :bairro,
            cidade = :cidade,
            estado = :estado,
            cep = :cep,
            banco = :banco,
            conta = :conta,
            agencia = :agencia,
            updated  =:updated
            WHERE  id = :id
        ");
        $fornecedores->bindValue(':id', $this->getId());
        $fornecedores->bindValue(':email', $this->getEmail());
        $fornecedores->bindValue(':telefone', $this->getTelefone());
        $fornecedores->bindValue(':representante', $this->getRepresentante());
        $fornecedores->bindValue(':cpf', $this->getCpf());
        $fornecedores->bindValue(':rua', $this->getRua());
        $fornecedores->bindValue(':numero', $this->getNumero());
        $fornecedores->bindValue(':bairro', $this->getBairro());
        $fornecedores->bindValue(':cidade', $this->getCidade());
        $fornecedores->bindValue(':estado', $this->getEstado());
        $fornecedores->bindValue(':cep', $this->getCep());
        $fornecedores->bindValue(':banco', $this->getBanco());
        $fornecedores->bindValue(':conta', $this->getConta());
        $fornecedores->bindValue(':agencia', $this->getAgencia());
        $fornecedores->bindValue(':updated', $this->getUpdated());
        try {
            return $fornecedores->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function UpdateCliente()
    {
        $fornecedores = $this->pdo->prepare("UPDATE fornecedores SET
            email = :email,
            telefone = :telefone,
            representante = :representante,
            cpf = :cpf,
            rua = :rua,
            numero = :numero,
            bairro = :bairro,
            cidade = :cidade,
            estado = :estado,
            updated  =:updated
            WHERE  id = :id
        ");
        $fornecedores->bindValue(':id', $this->getId());
        $fornecedores->bindValue(':email', $this->getEmail());
        $fornecedores->bindValue(':telefone', $this->getTelefone());
        $fornecedores->bindValue(':representante', $this->getRepresentante());
        $fornecedores->bindValue(':cpf', $this->getCpf());
        $fornecedores->bindValue(':rua', $this->getRua());
        $fornecedores->bindValue(':numero', $this->getNumero());
        $fornecedores->bindValue(':bairro', $this->getBairro());
        $fornecedores->bindValue(':cidade', $this->getCidade());
        $fornecedores->bindValue(':estado', $this->getEstado());
        $fornecedores->bindValue(':updated', $this->getUpdated());
        try {
            return $fornecedores->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public function Status()
    {
        $fornecedores = $this->pdo->prepare("UPDATE fornecedores SET
            status = :status    
            WHERE  id = :id
        ");
        $fornecedores->bindValue(':id', $this->getId());
        $fornecedores->bindValue(':status', $this->getStatus());
        try {
            return $fornecedores->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function NotAcess()
    {
        $fornecedores = $this->pdo->prepare("SELECT *
        FROM fornecedores
        WHERE id NOT IN (SELECT id_user FROM acessos)
        ");
        
        
        try {
            $fornecedores->execute();

            return $fornecedores->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function InconsitentesEmail()
    {
        $fornecedores = $this->pdo->prepare("SELECT *    FROM fornecedores     WHERE       email IS NULL OR TRIM(email) = '' OR      email like '%@alteraremail.teste%'
        ");
        
        
        try {
            $fornecedores->execute();

            return $fornecedores->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function VerificaBlock()
    {
        $fornecedores = $this->pdo->prepare("SELECT * FROM fornecedores    WHERE   email = :email ");
        $fornecedores->bindValue(':email', $this->getEmail());

        try {
            $fornecedores->execute();
            return $fornecedores->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
}
