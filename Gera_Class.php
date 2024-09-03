<?php

function my_autoload($pClassName) {
    include('Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload"); // Carrega as classes 
$tabela = "";

$catch = 'catch (Exception $retorno) {
          
        
        }';
$colunas = new CFT();
$colunas->setTabel($tabela);
$campo = $colunas->Ler_Colunas();
$arquivo = fopen('Class/'.$tabela . '.class.php', 'w');
fwrite($arquivo, "<?php \n");
fwrite($arquivo, "require_once 'ConexaoMysql.php';\n");
fwrite($arquivo, "class " . $tabela . " extends ConexaoMysql {\n");

foreach ($campo as $ind) {
    $Field = $ind["Field"];
    $Type = $ind["Type"];
    $Null = $ind["Null"];
    $Key = $ind["Key"];
    $Default = $ind["Default"];
    fwrite($arquivo, "    public $" . strtolower($Field) . ";\n");
}

foreach ($campo as $ind) {
    $Field = $ind["Field"];
    $Type = $ind["Type"];
    $Null = $ind["Null"];
    $Key = $ind["Key"];
    $Default = $ind["Default"];
    $get = "    public function get" . ucfirst(strtolower($Field)) . "(){\n"
            . '        return $this->' . strtolower($Field) . ";"
            . "\n    }\n";
    fwrite($arquivo, $get);
}
foreach ($campo as $ind) {
    $Field = $ind["Field"];
    $Type = $ind["Type"];
    $Null = $ind["Null"];
    $Key = $ind["Key"];
    $Default = $ind["Default"];
    $set = "    public function set" . ucfirst(strtolower($Field)) . "($" . strtolower($Field) . "){\n"
            . '        $this->' . strtolower($Field) . " = $" . strtolower($Field) . ";"
            . "\n    }\n";
    fwrite($arquivo, $set);
}

// Insert function 
fwrite($arquivo, "    public function Insert() {\n");
fwrite($arquivo, '        $' . strtolower($tabela) . ' = $this->pdo->prepare("INSERT INTO ' . $tabela . " (\n");

foreach ($campo as $ind) {
    $Field = $ind["Field"];
    fwrite($arquivo, "            " . $Field . ",\n");
}
fwrite($arquivo, "        ) VALUES (\n");
$contador = count($campo);
$contador = $contador - 1;
foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    if ($key == $contador) {
        fwrite($arquivo, "            :" . strtolower($Field) . "\n");
    } else {
        fwrite($arquivo, "            :" . strtolower($Field) . ",\n");
    }
}
fwrite($arquivo, '        )");' . "\n");

foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    fwrite($arquivo, '        $' . strtolower($tabela) . "->bindValue(':" . strtolower($Field) . "'" . ' ,$this->get' . ucfirst(strtolower($Field)) . "());\n");
}
fwrite($arquivo, "        try {\n");
fwrite($arquivo, "            return $" . strtolower($tabela) . "->execute();\n");
fwrite($arquivo, "        }\n");
fwrite($arquivo, $catch . "\n");

fwrite($arquivo, "    }\n");

// Update
fwrite($arquivo, "    public function Update() {\n");
fwrite($arquivo, '        $' . strtolower($tabela) . ' = $this->pdo->prepare("UPDATE ' . $tabela . " SET\n");

foreach ($campo as $key => $ind) {
    $contador2 = count($campo);
    $Field = $ind["Field"];
    $contador2 = $contador2 - 1;
    if ($key === $contador2) {
        if ($ind["Key"] === "") {
            fwrite($arquivo, "            " . $Field . " = :" . strtolower($Field) . "\n");
        }
    } else {
        if ($ind["Key"] === "") {
            fwrite($arquivo, "            " . $Field . " = :" . strtolower($Field) . ",\n");
        }
    }
}
foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    if ($key === 0) {
        if ($ind["Key"] === "PRI") {
            fwrite($arquivo, "        WHERE  " . $Field . " = :" . strtolower($Field) . "\n");
        }
    } else {
        if ($ind["Key"] === "PRI") {
            fwrite($arquivo, "            AND " . $Field . " = :" . strtolower($Field) . "\n");
        }
    }
}
fwrite($arquivo, '        ");' . "\n");

foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    fwrite($arquivo, '        $' . strtolower($tabela) . "->bindValue(':" . strtolower($Field) . "'" . ' ,$this->get' . ucfirst(strtolower($Field)) . "());\n");
}
fwrite($arquivo, "        try {\n");
fwrite($arquivo, "            return $" . strtolower($tabela) . "->execute();\n");
fwrite($arquivo, "        }\n");
fwrite($arquivo, $catch . "\n");

fwrite($arquivo, "    }\n");

// Delete 
fwrite($arquivo, "    public function Delete() {\n");
fwrite($arquivo, '        $' . strtolower($tabela) . ' = $this->pdo->prepare("DELETE FROM ' . $tabela . "\n");
foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    if ($key === 0) {
        if ($ind["Key"] === "PRI") {
            fwrite($arquivo, "            WHERE  " . $Field . " = :" . strtolower($Field) . "\n");
        }
    } else {
        if ($ind["Key"] === "PRI") {
            fwrite($arquivo, "            AND " . $Field . " = :" . strtolower($Field) . "\n");
        }
    }
}
fwrite($arquivo, '        ");' . "\n");
foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    if ($ind["Key"] === "PRI") {
        fwrite($arquivo, '        $' . strtolower($tabela) . "->bindValue(':" . strtolower($Field) . "'" . ' ,$this->get' . ucfirst(strtolower($Field)) . "());\n");
    }
}
fwrite($arquivo, "        try {\n");
fwrite($arquivo, "            return $" . strtolower($tabela) . "->execute();\n");
fwrite($arquivo, "        }\n");
fwrite($arquivo, $catch . "\n");

fwrite($arquivo, "    }\n");

// SELECT
fwrite($arquivo, "    public function Select() {\n");
fwrite($arquivo, '        $' . strtolower($tabela) . ' = $this->pdo->prepare("SELECT * FROM ' . $tabela . "\n");
foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    if ($key === 0) {
        if ($ind["Key"] === "PRI") {
            fwrite($arquivo, "            WHERE  " . $Field . " = :" . strtolower($Field) . "\n");
        }
    } else {
        if ($ind["Key"] === "PRI") {
            fwrite($arquivo, "            AND " . $Field . " = :" . strtolower($Field) . "\n");
        }
    }
}
fwrite($arquivo, '        ");' . "\n");
foreach ($campo as $key => $ind) {
    $Field = $ind["Field"];
    if ($ind["Key"] === "PRI") {
        fwrite($arquivo, '        $' . strtolower($tabela) . "->bindValue(':" . strtolower($Field) . "'" . ' ,$this->get' . ucfirst(strtolower($Field)) . "());\n");
    }
}
fwrite($arquivo, "        try {\n");
fwrite($arquivo, "            $" . strtolower($tabela) . "->execute();\n");
fwrite($arquivo, "            return $" . strtolower($tabela) . "->fetchAll();\n");
fwrite($arquivo, "        }\n");
fwrite($arquivo, $catch . "\n");

fwrite($arquivo, "    }\n");

// Fecha a classe
fwrite($arquivo, "}\n");
fclose($arquivo);
