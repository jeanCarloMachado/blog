<?php

ob_start();

define("LOG_UPLOAD",0);

$arquivoLog = "/../logs/upload";

if (LOG_UPLOAD) {
    require_once '../../vendor/system/1.6/System/Object/File/File.php';
    $file = new \AckCore\Object\File($arquivoLog);
    $file->open()->write("==========================================\n
    Inicializando log de upload em ".date("d-m-Y h:i:s")."\n")->save();
}

if (!empty($_FILES)) {
    $criaFoto=true;
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER["DOCUMENT_ROOT"].$_REQUEST['folder'];

    if(LOG_UPLOAD)
    $file->write("Valor de erro: ".$_FILES["Filedata"]["error"]."\nVariável FILES".serialize($_FILES)."\n")->save();

    $extensao = explode(".",$_FILES['Filedata']['name']);
    // Pega extensão do arquivo
    $extensao = end($extensao);
    // Cria um nome único para o arquivo
    $uid = uniqid (rand ()) . "." . $extensao;

    // Cria o caminho do arquivo
    $targetFile =  $targetPath ."/". $uid;

    if (LOG_UPLOAD) {
        $file->write("Movendo os seguintes enderecos de: $tempFile \npara: $targetFile \n")->save();
    }

    $result = move_uploaded_file($tempFile,$targetFile);

    if (LOG_UPLOAD) {
        $file->write("\nResultado da movimentação: $result \n")->save();
        $file->write("\nConteúdo do arquivo: $data\n")->save();

    }

    echo $uid."|cub|".$_FILES['Filedata']['name'];
} else {
    $criaFoto=false;
}

$buffer = ob_get_contents();
ob_end_clean();

if (LOG_UPLOAD) {
    $file->write("Saída do buffer: $buffer \n")->save();
    $file->write("Finalizando log de upload em ".date("d-m-Y h:i:s")."\n")->save()->close();
}
echo $buffer;
