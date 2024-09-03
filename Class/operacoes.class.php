<?php
require_once 'ConexaoMysql.php';
class operacoes extends ConexaoMysql
{
    public $id;
    public $cnpj;
    public $nota;
    public $vencimento;
    public $valor;
    public $dataope;
    public $tipo;
    public $status;
    public $clicksign_key;
    public $confirmada;
    public function getId()
    {
        return $this->id;
    }
    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function getNota()
    {
        return $this->nota;
    }
    public function getVencimento()
    {
        return $this->vencimento;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function getDataope()
    {
        return $this->dataope;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getClicksign_key()
    {
        return $this->clicksign_key;
    }
    public function getConfirmada()
    {
        return $this->confirmada;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }
    public function setNota($nota)
    {
        $this->nota = $nota;
    }
    public function setVencimento($vencimento)
    {
        $this->vencimento = $vencimento;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
    public function setDataope($dataope)
    {
        $this->dataope = $dataope;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setClicksign_key($clicksign_key)
    {
        $this->clicksign_key = $clicksign_key;
    }
    public function setConfirmada($confirmada)
    {
        $this->confirmada = $confirmada;
    }
    public function Insert()
    {
        $operacoes = $this->pdo->prepare("INSERT INTO operacoes (
            id,
            cnpj,
            nota,
            vencimento,
            valor,
            dataOPE,
            tipo,
            status,
            clicksign_key,
            confirmada,
        ) VALUES (
            :id,
            :cnpj,
            :nota,
            :vencimento,
            :valor,
            :dataope,
            :tipo,
            :status,
            :clicksign_key,
            :confirmada
        )");
        $operacoes->bindValue(':id', $this->getId());
        $operacoes->bindValue(':cnpj', $this->getCnpj());
        $operacoes->bindValue(':nota', $this->getNota());
        $operacoes->bindValue(':vencimento', $this->getVencimento());
        $operacoes->bindValue(':valor', $this->getValor());
        $operacoes->bindValue(':dataope', $this->getDataope());
        $operacoes->bindValue(':tipo', $this->getTipo());
        $operacoes->bindValue(':status', $this->getStatus());
        $operacoes->bindValue(':clicksign_key', $this->getClicksign_key());
        $operacoes->bindValue(':confirmada', $this->getConfirmada());
        try {
            return $operacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update()
    {
        $operacoes = $this->pdo->prepare("UPDATE operacoes SET
            cnpj = :cnpj,
            nota = :nota,
            vencimento = :vencimento,
            valor = :valor,
            dataOPE = :dataope,
            tipo = :tipo,
            status = :status,
            clicksign_key = :clicksign_key,
            confirmada = :confirmada
        WHERE  id = :id
        ");
        $operacoes->bindValue(':id', $this->getId());
        $operacoes->bindValue(':cnpj', $this->getCnpj());
        $operacoes->bindValue(':nota', $this->getNota());
        $operacoes->bindValue(':vencimento', $this->getVencimento());
        $operacoes->bindValue(':valor', $this->getValor());
        $operacoes->bindValue(':dataope', $this->getDataope());
        $operacoes->bindValue(':tipo', $this->getTipo());
        $operacoes->bindValue(':status', $this->getStatus());
        $operacoes->bindValue(':clicksign_key', $this->getClicksign_key());
        $operacoes->bindValue(':confirmada', $this->getConfirmada());
        try {
            return $operacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Delete()
    {
        $operacoes = $this->pdo->prepare("DELETE FROM operacoes
            WHERE  id = :id
        ");
        $operacoes->bindValue(':id', $this->getId());
        try {
            return $operacoes->execute();
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select()
    {
        $operacoes = $this->pdo->prepare("SELECT * FROM operacoes
            WHERE  id = :id
        ");
        $operacoes->bindValue(':id', $this->getId());
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Total_Postergado()
    {
        $operacoes = $this->pdo->prepare("select sum(postergacoesDetalhes.juros) as juros, sum(postergacoesDetalhes.taxas) as taxas from operacoes
        inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_operacao
        where operacoes.status = 5");
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Total_PostergadoValor()
    {
        $operacoes = $this->pdo->prepare("select sum(postergacoesDetalhes.valorOriginal) as valor from operacoes
         inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_operacao
         where operacoes.status = 5");
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Count()
    {
        $operacoes = $this->pdo->prepare("SELECT count(*) as totaloperacoes FROM operacoes");
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function CountCnpj()
    {
        $operacoes = $this->pdo->prepare("SELECT count(*) as	totaloperacoes FROM operacoes WHERE cnpj = :cnpj");
        $operacoes->bindValue(':cnpj', $this->getCnpj());

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function CountCnpjCliente()
    {
        $operacoes = $this->pdo->prepare("SELECT count(*) as	totaloperacoes FROM operacoes WHERE cnpj = :cnpj");
        $operacoes->bindValue(':cnpj', $this->getCnpj());

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function CountCnpjClientePostergadas()
    {
        $operacoes = $this->pdo->prepare("SELECT COUNT(*) AS totaldupli
        FROM operacoes o
        INNER JOIN postergacoesDetalhes pd ON o.id = pd.id_operacao
        INNER JOIN postergacoes p ON pd.id_postergacao = p.id
        WHERE o.cnpj  = :cnpj");
        $operacoes->bindValue(':cnpj', $this->getCnpj());

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    //Fluxo Disponível
    public function Total_PostergadoFluxoDisponivel()
    {
        $operacoes = $this->pdo->prepare("select COALESCE(sum(postergacoesDetalhes.valorOriginal),0) as valor, 
            count(*) as total_titulos from operacoes
            inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_postergada
            inner join boletos on boletos.operacao =  postergacoesDetalhes.id_operacao
              where operacoes.confirmada = 1");
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function ValorTotalOperado()
    {
        $operacoes = $this->pdo->prepare("SELECT SUM(valor) as valor FROM operacoes");
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Total_PostergadoMes()
    {
        $operacoes = $this->pdo->prepare("select sum(postergacoesDetalhes.valorOriginal) as valor, count(*) as total_titulos from operacoes
            inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_operacao
            where operacoes.confirmada =1 and operacoes.status = 5 
              and MONTH(operacoes.dataOPE) = MONTH(CURRENT_DATE)");
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    // Últimas Operações Realizadas/ancora
    public function UltimasOperacoesRealizadas_ancora($status, $inicio, $termino)
    {
        $query = "SELECT DISTINCT GROUP_CONCAT(id_operacao) as multiple_ids, id_postergacao as id
                      FROM postergacoesDetalhes
                      INNER JOIN operacoes ON operacoes.id LIKE postergacoesDetalhes.id_postergada
                      WHERE 1";

        $params = array();

        if (isset($status)) {
            if ($status == "4") {
                $query .= " AND operacoes.status = 5";
            } elseif ($status == "6") {
                $query .= " AND operacoes.status = 6";
            }
        }

        if ($inicio) {
            $query .= " AND operacoes.dataOPE >= :inicio";
            $params[':inicio'] = $inicio;
        }

        if ($termino) {
            $query .= " AND operacoes.dataOPE <= :termino";
            $params[':termino'] = $termino;
        }

        $query .= " GROUP BY id_postergacao HAVING COUNT(postergacoesDetalhes.id) > 0";
        $stmt = $this->pdo->prepare($query);

        try {
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Antecipadas_Agrupadas($values)
    {
        // Verificar se $values é um array
        if (!is_array($values)) {
            throw new InvalidArgumentException('O parâmetro $values deve ser um array.');
        }

        // Certifique-se de que os valores são inteiros ou converta-os conforme necessário
        $values = array_map('intval', $values);

        // Criar a lista de placeholders para o número de valores fornecidos
        $placeholders = implode(',', array_fill(0, count($values), '?'));

        // Preparar a consulta usando a lista de placeholders
        $query = "SELECT cnpj, max(tipo) as tipo , max(status) as status,max(dataOPE) as dataOPE,max(vencimento) as vencimento,max(confirmada) as confirmada, SUM(valor) as valor FROM operacoes WHERE id IN ($placeholders) GROUP BY cnpj";
        $operacoes = $this->pdo->prepare($query);

        try {
            // Vincular os valores aos placeholders
            $i = 1;
            foreach ($values as $value) {
                $operacoes->bindValue($i++, $value, PDO::PARAM_INT); // Ou ajuste o tipo de dado conforme necessário
            }

            // Executar a consulta
            $operacoes->execute();

            // Retornar os resultados
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            // Logar a mensagem de erro para facilitar a depuração
            error_log('Erro na execução da consulta: ' . $ex->getMessage());

            // Lançar uma exceção para que o código chamador possa lidar com o erro
            throw new RuntimeException('Erro na execução da consulta.', 0, $ex);
        }
    }

    public function getAntecipadasQuery($status = null, $inicio = null, $termino = null)
    {
        $antecipadas_query = "SELECT
        antec_id,
        MAX(confirmada_sec) AS confirmada_sec,
        MAX(valor) AS valor,
        MAX(confirmada) AS confirmada,
        MAX(id) AS id,
        MAX(id_oper) AS id_oper,
        MAX(real_antec_id) AS real_antec_id,
        MAX(descontoJuros) AS descontoJuros,
        MAX(descontoTaxas) AS descontoTaxas,
        MAX(statusReal) AS statusReal,
        MAX(cnpj) AS cnpj,
        MAX(tipo) AS tipo,
        MAX(dataOPE) AS dataOPE,
        MAX(vencimento) AS vencimento,  -- Ajuste feito aqui
        MAX(statusAntecipada) AS statusAntecipada,
        MAX(valorOriginal) AS valorOriginal
    FROM (
        SELECT
            IFNULL(
                antecipadas.valorOriginal,
                operacoes.valor
            ) AS valor,
            operacoes.confirmada AS confirmada,
            IFNULL(antecipadas.id, operacoes.id) AS id,
            operacoes.id AS id_oper,
            antecipadas.id AS real_antec_id,
            antecipadas.descontoJuros AS descontoJuros,
            antecipadas.descontoTaxas AS descontoTaxas,
            operacoes.status AS statusReal,
            IFNULL(antecipadas.id, UUID()) AS antec_id,
            (
                SELECT
                    confirmada
                FROM
                    operacoes
                WHERE
                    operacoes.id = postergacoesDetalhes.id_postergada
            ) AS confirmada_sec,
            operacoes.cnpj AS cnpj,
            operacoes.tipo AS tipo,
            operacoes.dataOPE AS dataOPE,
            operacoes.vencimento AS vencimento,  -- Ajuste feito aqui
            antecipadas.status AS statusAntecipada,
            antecipadas.valorOriginal AS valorOriginal
        FROM
            operacoes
        LEFT JOIN antecipadasDetalhes ON antecipadasDetalhes.operacao = operacoes.id
        LEFT JOIN postergacoesDetalhes ON operacoes.id = postergacoesDetalhes.id_operacao
        LEFT JOIN antecipadas ON antecipadas.id = antecipadasDetalhes.antecipada
        WHERE
             ";
        if ($status) {
            if ($status == "4") {
                $antecipadas_query .= "  operacoes.status = 5";
            } else {
                $antecipadas_query .= "  operacoes.status = 6";
            }
        } else {
            $antecipadas_query .= " operacoes.status != 0 AND operacoes.status != 4 AND operacoes.status != 6 ";
        }
        if ($inicio) {
            $antecipadas_query .= " AND operacoes.dataOPE >= '{$inicio}'";
        }

        if ($termino) {
            $antecipadas_query .= " AND operacoes.dataOPE <= '{$termino}'";
        }

        $antecipadas_query .= "

    ) AS subquery
    GROUP BY
        antec_id
    ORDER BY
        antec_id ASC;
    
    
    ";
        $stmt = $this->pdo->prepare($antecipadas_query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Total_Operacoes_Mes()
    {
        $operacoes = $this->pdo->prepare("select month(postergacoes.data) as mes, sum(postergacoesDetalhes.juros) as valor_juros, sum(postergacoesDetalhes.taxas) as valor_taxas
		from operacoes
		  left join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_postergada
		  left join postergacoes on postergacoesDetalhes.id_postergacao = postergacoes.id
				where operacoes.status = 4
				  and (select status from operacoes where operacoes.id = postergacoesDetalhes.id_operacao) = 5
				  and YEAR(postergacoes.data) = YEAR(CURRENT_DATE)
				group by MONTH(postergacoes.data)
		  UNION select month(antecipadas.data) as mes, antecipadas.descontoJuros as valor_juros, antecipadas.descontoTaxas as valor_taxas
		  from antecipadas
		     left join antecipadasDetalhes on antecipadasDetalhes.antecipada = antecipadas.id
		     inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
		       and operacoes.status = 5
			 where YEAR(antecipadas.data) = YEAR(CURRENT_DATE)
		  group by MONTH(antecipadas.data), antecipadas.id
		 UNION select month(movimentacao.data) as mes, (sum(movimentacao.valor) * -1) as valor_juros, 0 as valor_taxas
		 from movimentacao 
		 where YEAR(movimentacao.data) = YEAR(CURRENT_DATE)
		   and (movimentacao.tipo = 'despesa' or movimentacao.tipo = 'retirada')
		 group by MONTH(movimentacao.data)");
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Total_UsadoLimite()
    {
        $operacoes = $this->pdo->prepare("SELECT SUM(valor) as totalUsado FROM operacoes WHERE cnpj = :cnpj AND status = 5 AND confirmada = 1 ");
        $operacoes->bindValue(':cnpj', $this->getCnpj());

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Get_Operacoes_By_Cnpj_order_by_Vencimento()
    {
        $operacoes = $this->pdo->prepare("SELECT * FROM operacoes WHERE cnpj = :cnpj and status = 0 and vencimento >= :vencimento ORDER BY vencimento DESC");
        $operacoes->bindValue(':cnpj', $this->getCnpj());
        $operacoes->bindValue(':vencimento', date('Y-m-d'));

        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Total_AntecipadoAncora()
    {
        $operacoes = $this->pdo->prepare("select distinct sum(antecipadasDetalhes.valorOriginal) as valor from antecipadas
        left join antecipadasDetalhes on antecipadasDetalhes.antecipada = antecipadas.id
        inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
          and operacoes.status = 5
        ");

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Total_PostergadoAncora()
    {
        $operacoes = $this->pdo->prepare("select sum(postergacoesDetalhes.valorOriginal) as valor from operacoes
        inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_operacao
        where operacoes.status = 5
        ");

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Total_PostergadoCliente()
    {
        $operacoes = $this->pdo->prepare("select sum(postergacoesDetalhes.taxas) as taxas , SUM(postergacoesDetalhes.juros) as juros from operacoes
        inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_operacao
        where (operacoes.status = 5 or  operacoes.status = 6) AND operacoes.cnpj = :cnpj
        ");
        $operacoes->bindValue(':cnpj', $this->getCnpj());
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_OperacoesVencomentoMaior()
    {
        $operacoes = $this->pdo->prepare("SELECT * FROM operacoes WHERE vencimento >= :vencimento and status != 4 and status != 1 ORDER BY vencimento DESC");
        $operacoes->bindValue(':vencimento', $this->getVencimento());
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function total_operacoes_mes_postergacoesDetalhes()
    {
        $operacoes = $this->pdo->prepare("select month(postergacoes.data) as mes, sum(postergacoesDetalhes.valorOriginal) as valor_total from operacoes
        left join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_postergada
        left join postergacoes on postergacoesDetalhes.id_postergacao = postergacoes.id
              where operacoes.status = 4
                and (select status from operacoes OPER_stat where OPER_stat.id = postergacoesDetalhes.id_operacao) = 5
                and YEAR(postergacoes.data) = YEAR(postergacoes.data)
              group by MONTH(postergacoes.data)
        UNION select month(antecipadas.data) as mes, sum(antecipadasDetalhes.valorOriginal) as valor_total
        from antecipadas
            left join antecipadasDetalhes on antecipadasDetalhes.antecipada = antecipadas.id
            inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
            and operacoes.status = 5
            where YEAR(antecipadas.data) = YEAR(antecipadas.data)
        group by MONTH(antecipadas.data)");
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function Get_Operaco($id_postergacao)
    {
        try {
            $operacoes = $this->pdo->prepare("
                SELECT *, 
                juros as descontoJuros, 
                taxas as descontoTaxas, 
                (
                    SELECT cnpj 
                    FROM operacoes 
                    WHERE operacoes.id = (
                        SELECT id_operacao 
                        FROM postergacoesDetalhes 
                        WHERE postergacoesDetalhes.id_postergacao = postergacoes.id 
                        LIMIT 1
                    )
                ) as cnpj 
                FROM postergacoes 
                WHERE id = :id_postergacao
            ");

            $operacoes->bindValue(':id_postergacao', $id_postergacao, PDO::PARAM_INT);
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public function Get_OperacoAndId()
    {
        try {
            $operacoes = $this->pdo->prepare("SELECT
            operacoes.id,
            operacoes.cnpj,
            operacoes.nota,
            operacoes.vencimento,
            operacoes.valor,
            operacoes.dataOPE,
            operacoes.tipo,
            operacoes.status,
            operacoes.clicksign_key,
            operacoes.confirmada,
        
            postergacoesDetalhes.valorOriginal AS valorOriginal,
            SUM(postergacoesDetalhes.juros) AS descontoJuros,
            SUM(postergacoesDetalhes.taxas) AS descontoTaxas
        FROM
            operacoes
        LEFT JOIN postergacoesDetalhes ON operacoes.id IN (
                postergacoesDetalhes.id_operacao,
                postergacoesDetalhes.id_postergada,
                postergacoesDetalhes.id_postergada
            )
        WHERE
            operacoes.id = :id
        GROUP BY
            operacoes.id, operacoes.cnpj, operacoes.nota, operacoes.vencimento,
            operacoes.valor, operacoes.dataOPE, operacoes.tipo, operacoes.status,
            operacoes.clicksign_key, operacoes.confirmada, postergacoesDetalhes.valorOriginal;
         ");

            $operacoes->bindValue(':id', $this->getId());
            // return   $operacoes ;
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_NotaOperaco($id)
    {
        try {
            $operacoes = $this->pdo->prepare("SELECT *, documento as nota, valor as valorOriginal FROM boletos WHERE operacao = :id");

            $operacoes->bindValue(':id', $id, PDO::PARAM_INT);
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_NotaOperacao_boletoPostergado($id)
    {
        try {
            $operacoes = $this->pdo->prepare("SELECT *, boletos.status as status_boleto, boletos.id as id_boleto, postergacoesDetalhes.taxas as taxas, postergacoesDetalhes.juros as juros, postergacoesDetalhes.valorOriginal as valorOriginal FROM operacoes  left join boletos on boletos.operacao = operacoes.id inner join postergacoesDetalhes on postergacoesDetalhes.id_operacao = operacoes.id WHERE operacoes.id  = :id");

            $operacoes->bindValue(':id', $id, PDO::PARAM_INT);
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Get_NotaOperacao_boletAntecipado($id)
    {
        try {
            $operacoes = $this->pdo->prepare("SELECT *, boletos.status as status_boleto, boletos.id as id_boleto FROM operacoes left join boletos on boletos.operacao = operacoes.id inner join antecipadasDetalhes on antecipadasDetalhes.operacao = operacoes.id WHERE operacoes.id = :id");

            $operacoes->bindValue(':id', $id, PDO::PARAM_INT);
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function FluxoCaixa()
    {
        $operacoes = $this->pdo->prepare("select distinct COALESCE(SUM(antecipadasDetalhes.valor),0)+COALESCE(SUM((select oper.valor from operacoes oper where oper.id = operacoes.id and operacoes.status = 4)),0) AS valor, antecipadas.descontoTaxas as taxas from operacoes left join antecipadasDetalhes on antecipadasDetalhes.operacao = operacoes.id inner join antecipadas on antecipadasDetalhes.antecipada = antecipadas.id where (operacoes.status = 4 and operacoes.vencimento = :vencimento) or (operacoes.id = antecipadasDetalhes.operacao and operacoes.status = 5  and operacoes.dataOPE = :dataope ) and operacoes.confirmada = 1 group by antecipadas.id");
        $operacoes->bindValue(':vencimento', $this->getVencimento());
        $operacoes->bindValue(':dataope', $this->getDataope());
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function FluxoData($inicio, $termino, $tipo, $status)
    {
        $query = "
            SELECT DISTINCT
                (SELECT razao FROM fornecedores 
                    WHERE cnpj LIKE operacoes.cnpj LIMIT 1) AS razao,
                operacoes.cnpj AS cnpj,
                operacoes.tipo AS tipo,
                antecipadasDetalhes.antecipada AS antec_id,
                IFNULL(antecipadasDetalhes.antecipada, UUID()) AS antec_id_uniq, 
                operacoes.id AS id_oper,
                vencimento,
                SUM(operacoes.valor) AS valor,
                operacoes.status AS status,
                operacoes.confirmada AS confirmada,
                antecipadasDetalhes.data AS data_antec,
                SUM(antecipadasDetalhes.valorOriginal) AS valor_antec,
                antecipadas.valor AS valor_antec_saida
            FROM
                operacoes
                LEFT JOIN postergacoesDetalhes ON postergacoesDetalhes.id_operacao = operacoes.id OR postergacoesDetalhes.id_postergada = operacoes.id
                    AND operacoes.confirmada = 1
                LEFT JOIN antecipadasDetalhes ON antecipadasDetalhes.operacao = operacoes.id  
                    AND (operacoes.confirmada = 1 OR antecipadasDetalhes.antecipada IS NOT NULL 
                        AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5)
                LEFT JOIN antecipadas ON antecipadas.id = antecipadasDetalhes.antecipada
                    AND (operacoes.confirmada = 1 OR antecipadasDetalhes.antecipada IS NOT NULL 
                        AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5)
            WHERE
                operacoes.status NOT IN (0, 1, 6)
                AND (operacoes.confirmada = 1 
                    OR (postergacoesDetalhes.id_operacao = operacoes.id 
                        AND (SELECT status FROM operacoes oper WHERE oper.id = postergacoesDetalhes.id_operacao) = 5)
                    OR (antecipadasDetalhes.antecipada IS NOT NULL 
                        AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5)
                )
        ";

        if ($inicio) {
            $query .= " AND vencimento >= :inicio AND operacoes.dataOPE >= :inicio";
        }

        if ($termino) {
            $query .= " AND vencimento <= :termino AND operacoes.dataOPE <= :termino";
        }

        if ($tipo) {
            if ($tipo == 'saida') {
                $query .= " AND (operacoes.id != postergacoesDetalhes.id_operacao OR postergacoesDetalhes.id IS NULL)";
            } else {
                $query .= " AND operacoes.status NOT IN (1, 4)";
            }
        }

        if ($status) {
            if ($status == "4") {
                $query .= " AND operacoes.status IN (4, 5) AND antecipadasDetalhes.antecipada IS NULL 
                            AND (SELECT status FROM operacoes oper WHERE oper.id = postergacoesDetalhes.id_operacao) = 5";
            } else {
                $query .= " AND operacoes.status IN (1, 5) AND antecipadasDetalhes.antecipada IS NOT NULL 
                            AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5";
            }
        }

        $query .= "     GROUP BY
        operacoes.id,
        antec_id_uniq,
        razao,
        operacoes.cnpj,
        operacoes.tipo,
        antecipadasDetalhes.antecipada,
        operacoes.id,
        vencimento,
        operacoes.status,
        operacoes.confirmada,
        antecipadasDetalhes.data,
        antecipadas.valor
    ORDER BY operacoes.vencimento";

        $stmt = $this->pdo->prepare($query);

        if ($inicio) {
            $stmt->bindParam(':inicio', $inicio);
        }

        if ($termino) {
            $stmt->bindParam(':termino', $termino);
        }


        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function getMovimentacao($inicio, $termino, $tipo)
    {
        $query_mov = "SELECT * FROM movimentacao WHERE 1 = 1";

        if ($inicio) {
            $query_mov .= " AND data >= :inicio";
        }

        if ($termino) {
            $query_mov .= " AND data <= :termino";
        }

        if ($tipo) {
            if ($tipo == 'saida') {
                $query_mov .= " AND (tipo LIKE 'despesa' OR tipo LIKE 'retirada')";
            } else {
                $query_mov .= " AND tipo LIKE 'aporte'";
            }
        }

        $stmt = $this->pdo->prepare($query_mov);

        if ($inicio) {
            $stmt->bindParam(':inicio', $inicio);
        }

        if ($termino) {
            $stmt->bindParam(':termino', $termino);
        }

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function TotalOperadoSaidasVencimento()
    {
        try {
            $operacoes = $this->pdo->prepare("select distinct COALESCE(SUM(antecipadasDetalhes.valor),0)+COALESCE(SUM((select oper.valor from operacoes oper where oper.id = operacoes.id and operacoes.status = 4)),0) AS valor from operacoes left join antecipadasDetalhes on antecipadasDetalhes.operacao = operacoes.id where (operacoes.status = 4 and operacoes.vencimento = :vencimento) or (operacoes.id = antecipadasDetalhes.operacao and operacoes.status = 5 and operacoes.dataOPE = :dataope)");
            $operacoes->bindValue(':vencimento', $this->getVencimento());
            $operacoes->bindValue(':dataope', $this->getDataope());

            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    // public function getYourDataSaidas($inicio, $termino, $tipo, $status)
    // {
    //     $query = "
    //         SELECT 
    //             (SELECT razao FROM fornecedores 
    //                 WHERE cnpj LIKE operacoes.cnpj LIMIT 1) AS razao,
    //             operacoes.cnpj AS cnpj,
    //             operacoes.tipo AS tipo,
    //             antecipadasDetalhes.antecipada AS antec_id,
    //             IFNULL(antecipadasDetalhes.antecipada, UUID()) AS antec_id_uniq,
    //             GROUP_CONCAT(operacoes.id) AS id_oper,
    //             vencimento,
    //             SUM(operacoes.valor) AS valor,
    //             operacoes.status AS status,
    //             antecipadasDetalhes.data AS data_antec,
    //             antecipadas.valor AS valor_antec
    //         FROM
    //             operacoes
    //             LEFT JOIN postergacoesDetalhes ON postergacoesDetalhes.id_operacao = operacoes.id OR postergacoesDetalhes.id_postergada = operacoes.id
    //             LEFT JOIN antecipadasDetalhes ON antecipadasDetalhes.operacao = operacoes.id AND antecipadasDetalhes.antecipada IS NOT NULL
    //             LEFT JOIN antecipadas ON antecipadas.id = antecipadasDetalhes.antecipada
    //         WHERE
    //             operacoes.status NOT IN (0, 1, 6) AND (operacoes.id != postergacoesDetalhes.id_operacao OR postergacoesDetalhes.id IS NULL)
    //             AND operacoes.confirmada = 0
    //     ";

    //     if ($inicio) {
    //         $query .= " AND vencimento >= :inicio AND operacoes.dataOPE >= :inicio";
    //     }

    //     if ($termino) {
    //         $query .= " AND vencimento <= :termino AND operacoes.dataOPE <= :termino";
    //     }

    //     if ($tipo) {
    //         if ($tipo == 'saida') {
    //             $query .= " AND (operacoes.id != postergacoesDetalhes.id_operacao OR postergacoesDetalhes.id IS NULL)";
    //         } else {
    //             $query .= " AND operacoes.status NOT IN (1, 4)";
    //         }
    //     }

    //     if ($status) {
    //         if ($status == "4") {
    //             $query .= " AND operacoes.status IN (4, 5) AND antecipadasDetalhes.antecipada IS NULL AND (SELECT status FROM operacoes oper WHERE oper.id = postergacoesDetalhes.id_operacao) = 5";
    //         } else {
    //             $query .= " AND operacoes.status IN (1, 5) AND antecipadasDetalhes.antecipada IS NOT NULL AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5";
    //         }
    //     } else {
    //         $query .= " AND ((operacoes.status IN (4, 5) AND antecipadasDetalhes.antecipada IS NULL AND (SELECT status FROM operacoes oper WHERE oper.id = postergacoesDetalhes.id_operacao) = 5)
    //         OR (operacoes.status IN (1, 5) AND antecipadasDetalhes.antecipada IS NOT NULL AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5))";
    //     }

    //     $query .= " AND operacoes.confirmada = 0";

    //    echo  $query .= " GROUP BY razao, cnpj, tipo, antec_id, antec_id_uniq, vencimento, status, data_antec, valor_antec ORDER BY operacoes.vencimento";
    //     return;
    //     $stmt = $this->pdo->prepare($query);

    //     if ($inicio) {
    //         $stmt->bindParam(':inicio', $inicio);
    //     }

    //     if ($termino) {
    //         $stmt->bindParam(':termino', $termino);
    //     }

    //     try {
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (Exception $retorno) {
    //         return $retorno->getMessage();
    //     }
    // }
    public function getYourDataSaidas($inicio, $termino, $tipo, $status)
    {
        $query = "
        SELECT 
            (SELECT razao FROM fornecedores 
                WHERE cnpj LIKE operacoes.cnpj LIMIT 1) AS razao,
            operacoes.cnpj AS cnpj,
            operacoes.tipo AS tipo,
            antecipadasDetalhes.antecipada AS antec_id,
            IFNULL(antecipadasDetalhes.antecipada, UUID()) AS antec_id_uniq,
            GROUP_CONCAT(operacoes.id) AS id_oper,
            vencimento,
            SUM(operacoes.valor) AS valor,
            operacoes.status AS status,
            antecipadasDetalhes.data AS data_antec,
            antecipadas.valor AS valor_antec
        FROM
            operacoes
            LEFT JOIN postergacoesDetalhes ON postergacoesDetalhes.id_postergada = operacoes.id
            LEFT JOIN antecipadasDetalhes ON antecipadasDetalhes.operacao = operacoes.id AND antecipadasDetalhes.antecipada IS NOT NULL
            LEFT JOIN antecipadas ON antecipadas.id = antecipadasDetalhes.antecipada
        WHERE
            operacoes.status NOT IN (0, 1, 6) AND operacoes.confirmada = 0";

        if ($inicio) {
            $query .= " AND vencimento >= :inicio AND operacoes.dataOPE >= :inicio";
        }

        if ($termino) {
            $query .= " AND vencimento <= :termino AND operacoes.dataOPE <= :termino";
        }

        if ($tipo) {
            if ($tipo == 'saida') {
                $query .= " AND (operacoes.id != postergacoesDetalhes.id_postergada OR postergacoesDetalhes.id IS NULL)";
            } else {
                $query .= " AND operacoes.status NOT IN (1, 4)";
            }
        }

        if ($status) {
            if ($status == "4") {
                $query .= " AND operacoes.status IN (4, 5) AND antecipadasDetalhes.antecipada IS NULL AND (SELECT status FROM operacoes oper WHERE oper.id = postergacoesDetalhes.id_postergada) = 5";
            } else {
                $query .= " AND operacoes.status IN (1, 5) AND antecipadasDetalhes.antecipada IS NOT NULL AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5";
            }
        } else {
            $query .= " AND ((operacoes.status IN (4, 5) AND antecipadasDetalhes.antecipada IS NULL AND (SELECT status FROM operacoes oper WHERE oper.id = postergacoesDetalhes.id_postergada) = 5)
        OR (operacoes.status IN (1, 5) AND antecipadasDetalhes.antecipada IS NOT NULL AND (SELECT status FROM operacoes oper WHERE oper.id = antecipadasDetalhes.operacao) = 5))";
        }

        $query .= " GROUP BY razao, cnpj, tipo, antec_id, antec_id_uniq, vencimento, status, data_antec, valor_antec ORDER BY operacoes.vencimento";

        echo $query;

        return;
        $stmt = $this->pdo->prepare($query);

        if ($inicio) {
            $stmt->bindParam(':inicio', $inicio);
        }

        if ($termino) {
            $stmt->bindParam(':termino', $termino);
        }

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update_confirmada()
    {
        $operacoes = $this->pdo->prepare("UPDATE operacoes SET
            confirmada = :confirmada
        WHERE  id = :id
        ");
        $operacoes->bindValue(':id', $this->getId());
        $operacoes->bindValue(':confirmada', $this->getConfirmada());
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Update_Status()
    {
        $operacoes = $this->pdo->prepare("UPDATE operacoes SET
            status = :status
        WHERE  id = :id
        ");
        $operacoes->bindValue(':id', $this->getId());
        $operacoes->bindValue(':status', $this->getStatus());

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function Select_confirmada()
    {
        $operacoes = $this->pdo->prepare("SELECT *, antecipadas.id as oper_id, operacoes.dataOPE as data_oper, antecipadasDetalhes.valor as valor_antecip, antecipadas.valor as valor_antecip_liq FROM antecipadasDetalhes 
		inner join boletos on boletos.operacao = antecipadasDetalhes.operacao
		inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
		inner join antecipadas on antecipadas.id = antecipadasDetalhes.antecipada
		inner join fornecedores on fornecedores.cnpj = operacoes.cnpj 
		WHERE antecipadasDetalhes.operacao in (:id)
        ");
        $operacoes->bindValue(':id', $this->getId());
        try {
            $operacoes->execute();

            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    function consultarOperacoesAntecipadas($status, $inicio, $termino)
    {
        try {
            $antecipadas_query = "SELECT DISTINCT antecipadasDetalhes.*, 
                (SELECT confirmada FROM operacoes WHERE operacoes.id = postergacoesDetalhes.id_operacao) as confirmada_sec, 
                IFNULL(antecipadas.valorOriginal, operacoes.valor) as valor, 
                operacoes.confirmada as confirmada, 
                IFNULL(antecipadas.id, operacoes.id) as id, 
                operacoes.id as id_oper, 
                antecipadas.id as real_antec_id, 
                operacoes.status as statusReal, 
                IFNULL(antecipadas.id, UUID()) as antec_id 
            FROM operacoes 
            LEFT JOIN antecipadasDetalhes ON antecipadasDetalhes.operacao = operacoes.id 
            LEFT JOIN postergacoesDetalhes ON operacoes.id = postergacoesDetalhes.id_operacao
            LEFT JOIN antecipadas ON antecipadas.id = antecipadasDetalhes.antecipada 
            WHERE operacoes.status != 0 AND operacoes.status != 4 ";

            if ($status) {
                if ($status == "4") {
                    $antecipadas_query .= " AND operacoes.status = 5";
                } else {
                    $antecipadas_query .= " AND operacoes.status = 6";
                }
            }

            if ($inicio) {
                $antecipadas_query .= " AND operacoes.dataOPE >= :inicio";
            }

            if ($termino) {
                $antecipadas_query .= " AND operacoes.dataOPE <= :termino";
            }

            $antecipadas_query .= " GROUP BY antec_id, 
                antecipadasDetalhes.id, 
                postergacoesDetalhes.id_operacao, 
                operacoes.valor, 
                operacoes.confirmada, 
                operacoes.id, 
                operacoes.status, 
                operacoes.dataOPE 
            ORDER BY `antecipadasDetalhes`.`antecipada` ASC";

            $stmt = $this->pdo->prepare($antecipadas_query);

            if ($inicio) {
                $stmt->bindParam(':inicio', $inicio, PDO::PARAM_STR);
            }

            if ($termino) {
                $stmt->bindParam(':termino', $termino, PDO::PARAM_STR);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }




    public function SomaOperacaoId()
    {
        $operacoes = $this->pdo->prepare("select *, sum(valor) as valor from operacoes where id in (:id) group by cnpj
        ");
        $operacoes->bindValue(':id', $this->getId());
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function ValorTotalOperadoCnpj()
    {
        try {
            $operacoes = $this->pdo->prepare("SELECT SUM(valor) as valor FROM operacoes WHERE cnpj = :cnpj AND status = :status");
            $operacoes->bindValue(':cnpj', $this->getCnpj());
            $operacoes->bindValue(':status', $this->getStatus());

            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectOpDescontoAncora()
    {
        try {
            $operacoes = $this->pdo->prepare("SELECT * FROM operacoes WHERE cnpj= :cnpj AND status=:status AND vencimento >= :vencimento ORDER BY vencimento ASC");
            $operacoes->bindValue(':cnpj', $this->getCnpj());
            $operacoes->bindValue(':status', $this->getStatus());
            $operacoes->bindValue(':vencimento', $this->getVencimento());

            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    ////modo cliente
    public function SelectOpe_BolClientes()
    {
        try {
            $operacoes = $this->pdo->prepare("select operacoes.*, 
            boletos.id as id_boleto ,
            boletos.status as status_boleto
            from operacoes
            left join boletos 
              on operacoes.id = boletos.operacao
            where operacoes.cnpj = :cnpj AND operacoes.vencimento >= :vencimento AND operacoes.status != 4");
            $operacoes->bindValue(':cnpj', $this->getCnpj());
            $operacoes->bindValue(':vencimento', $this->getVencimento());

            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function BuscaNotaPostergadaOriginal()
    {
        $operacoes = $this->pdo->prepare("SELECT * FROM operacoes WHERE nota = :nota and status =4");
        $operacoes->bindValue(':nota', $this->getNota());

        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function GetOperacoesSaindasDia()
    {
        // postergadas
        $operacoes = $this->pdo->prepare("SELECT
        subquery.*,
        f.razao
    FROM
        (SELECT
            pd.id_postergacao,
            MAX(pd.id) AS detalhe_id,
            MAX(pd.id_operacao) AS detalhe_id_operacao,
            SUM(pd.valorOriginal) AS total_detalhe_valorOriginal,
            SUM(pd.juros) AS total_detalhe_juros,
            SUM(pd.taxas) AS total_detalhe_taxas,
            SUM(pd.valor) AS total_detalhe_valor,
            MAX(pd.status) AS detalhe_status,
            MAX(pd.tipo) AS detalhe_tipo,
            MAX(pd.confirmada) AS detalhe_confirmada,
            MAX(pd.id_postergada) AS id_postergada,
            MAX(p.id) AS postergacao_id,
            MAX(p.data) AS postergacao_data,
            SUM(p.valorOriginal) AS total_valorOriginal,
            SUM(p.juros) AS total_juros,
            SUM(p.taxas) AS total_taxas,
            SUM(p.valor) AS total_valor,
            MAX(p.status) AS postergacao_status,
            MAX(p.tipo) AS postergacao_tipo,
            MAX(p.confirmada) AS postergacao_confirmada,
            MAX(o.id) AS operacao_id,
            MAX(o.cnpj) AS cnpj,
            MAX(o.nota) AS nota,
            MAX(o.vencimento) AS vencimento,
            SUM(o.valor) AS total_operacao_valor,
            MAX(o.dataOPE) AS dataOPE,
            MAX(o.tipo) AS operacao_tipo,
            MAX(o.status) AS operacao_status,
            MAX(o.clicksign_key) AS clicksign_key,
            MAX(o.confirmada) AS operacao_confirmada
        FROM
            postergacoes p
        JOIN postergacoesDetalhes pd ON p.id = pd.id_postergacao
        JOIN operacoes o ON pd.id_operacao = o.id
        WHERE
            o.status NOT IN (0, 1, 6) AND o.confirmada = 0
        GROUP BY
            pd.id_postergacao) AS subquery
    JOIN fornecedores f ON f.cnpj = subquery.cnpj;
    
    ");

        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function GetOperacoesEntradasDia()
    {
        // postergadas
        $operacoes = $this->pdo->prepare("SELECT
        subquery.*,
        f.razao
    FROM
        (SELECT
            ad.antecipada,
            MAX(ad.id) AS detalhe_id,
            MAX(ad.operacao) AS detalhe_id_operacao,
            SUM(ad.valorOriginal) AS total_detalhe_valorOriginal,
            SUM(ad.descontoJuros) AS total_detalhe_juros,
            SUM(ad.valor) AS total_detalhe_valor,
            MAX(a.id) AS antecipacao_id,
            MAX(a.data) AS antecipacao_data,
            SUM(a.valorOriginal) AS antecipacao_total_valorOriginal,
            SUM(a.descontoJuros) AS antecipacao_total_juros,
            max(a.descontoTaxas) AS antecipacao_total_taxas,
            SUM(a.valor) AS antecipacao_total_valor,
            MAX(a.status) AS antecipacao_status,
            MAX(a.tipo) AS antecipacao_tipo,
            MAX(a.confirmada) AS postergacao_confirmada,
            MAX(o.id) AS operacao_id,
            MAX(o.cnpj) AS cnpj,
            MAX(o.nota) AS nota,
            MAX(o.vencimento) AS vencimento,
            SUM(o.valor) AS total_operacao_valor,
            MAX(o.dataOPE) AS dataOPE,
            MAX(o.tipo) AS operacao_tipo,
            MAX(o.status) AS operacao_status,
            MAX(o.clicksign_key) AS clicksign_key,
            MAX(o.confirmada) AS operacao_confirmada
        FROM
        antecipadas a
        JOIN antecipadasDetalhes ad ON a.id = ad.antecipada
        JOIN operacoes o ON ad.operacao = o.id
        WHERE
            o.status NOT IN (0, 1, 4) AND o.confirmada = 0
        GROUP BY
            ad.antecipada) AS subquery
    JOIN fornecedores f ON f.cnpj = subquery.cnpj;
    
    ");

        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public function SelectPostegacoesCNPJ()
    {
        $operacoes = $this->pdo->prepare("SELECT
        o.status,
        o.clicksign_key,
        o.confirmada,
        p.data,
        COUNT(pd.id_postergada) as qtd,
        MAX(p.id) AS id_postergacao,
        p.valorOriginal AS valorOriginal,
        p.valor AS valor
    FROM
        operacoes o
    INNER JOIN postergacoesDetalhes pd ON
        o.id = pd.id_operacao
    INNER JOIN postergacoes p ON
        pd.id_postergacao = p.id
    WHERE
        o.status IN(5, 6) AND o.cnpj = :cnpj
    GROUP BY
        o.status,
        o.clicksign_key,
        o.confirmada,
        p.valorOriginal,
        pd.id_postergacao;
        ");
        $operacoes->bindValue(':cnpj', $this->getCnpj());
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    public function SelectOpeDisponiveis()
    {
        $operacoes = $this->pdo->prepare("SELECT * FROM operacoes WHERE cnpj=:cnpj AND status=0 AND vencimento>=:vencimento ORDER BY vencimento ASC
        ");
        $operacoes->bindValue(':cnpj', $this->getCnpj());
        $operacoes->bindValue(':vencimento', $this->getVencimento());
        try {
            $operacoes->execute();
            return $operacoes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }


    public function Operou()
    {
        $operacoes = $this->pdo->prepare("SELECT COUNT(*) as COUNT FROM operacoes WHERE cnpj=:cnpj AND status !=0   ");
        $operacoes->bindValue(':cnpj', $this->getCnpj());        
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }

    public function ExiteOP()
    {
        $operacoes = $this->pdo->prepare("SELECT COUNT(*) as COUNT FROM operacoes WHERE cnpj=:cnpj   ");
        $operacoes->bindValue(':cnpj', $this->getCnpj());        
        try {
            $operacoes->execute();
            return $operacoes->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $retorno) {
            return $retorno->getMessage();
        }
    }
    
}
