<?php
$dbFileName  = __DIR__ . "/../db/carros.db.json";
// Função responsável por ler o arquivo json usado como base de dados, e reponde com o seu conteúdo. 
function readDb($retJson = false)
{
    global $dbFileName;
    checkDb();
    if (is_readable($dbFileName)) {
        $dbContent = file_get_contents($dbFileName);
        if (!$retJson) {
            $dbContent = json_decode($dbContent);
        } else {
            $dbContent = json_encode($dbContent);
        }
        return $dbContent;
    } else {
        throw new Exception("Erro ao interagir com a base de dados.", 500);
    }
}
// Função responsável por escrever no arquivo json o que foi passado por parâmetro.
function writeDb($content)
{
    global $dbFileName;

    checkDb();
    if (is_writable($dbFileName)) {
        $dbFile = fopen($dbFileName, "w+");
        $dbContentJson = json_encode($content);
        fwrite($dbFile, $dbContentJson);
        fclose($dbFile);
    } else {
        // Sobe uma exceção caso ocorra um erro na escrita da base de dados.
        throw new Exception("Erro ao interagir com a base de dados.", 500);
    }
}


function checkDb()
{
    global $dbFileName;
    if (!file_exists($dbFileName)) {
        $tmpFile = fopen($dbFileName, 'w') or die('Cannot open file:  ' . "carros.db.json");
        fwrite($tmpFile, "[]");
        fclose($tmpFile);
        return true;
    } else {
        return false;
    }
}
