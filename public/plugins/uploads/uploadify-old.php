<?php
include("../../src/config.php");
include("../../src/helpers.php");

global $endereco_fisico;

$criaFoto=true;
$tempFile = $_FILES['Filedata']['tmp_name'];
$targetPath = $endereco_fisico . $_REQUEST['folder'];

// Pega extensão do arquivo
$extensao = extensao($_FILES['Filedata']['name']);
// Cria um nome único para o arquivo
$foto = uniqid (rand ()) . "." . $extensao;

// Cria o caminho do arquivo
$targetFile =  $targetPath ."/". $foto;

move_uploaded_file($tempFile,$targetFile);

echo $foto."|cub|".$_FILES['Filedata']['name'];

?>