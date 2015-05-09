<?php
namespace AckMvc\View;
use AckCore\Object;
class Utils extends Object
{
    public static function getRealViewFile($wantedViewFile,$config)
    {
        $path = \AckCore\Facade::getCurrentModulePath();

        $wanted = $path ."view/" . $wantedViewFile;
        if(file_exists($wanted) && !isset($config["automaticRenderView"])) return $wantedViewFile;

        $fileName = explode("/", $wantedViewFile);
        $fileName = end($fileName);

        $real = "ack-core/default/".$fileName;

        return $real;
    }

    /**
     * retorna o caminho completo de uma ariquvo que se encontre na pasta de um
     * controlador no momento da renderização naquel controller, caso não
     * encontrar retorna uma exceção
     * @param  [type] $wantedViewFile [description]
     * @param  [type] $config         [description]
     * @return [type] [description]
     */
    public static function getRealViewFullFilePath($wantedViewFile,$config)
    {
        $path = \AckCore\Facade::getCurrentModulePath();

        $wanted = $path ."view/" . $wantedViewFile;
        if(file_exists($wanted))

            return $wanted;

        throw new \Exception("Arquivo $wantedViewFile não exite");
    }
}
