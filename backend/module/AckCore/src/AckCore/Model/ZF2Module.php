<?php
/**
 * classe com funções que tratam de apenas um módulo do ack
 * descricao
 *
 * AckDefault - Cub
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\Model;
use AckCore\Object;
use AckCore\Utils\Cmd;
use AckCore\Utils\Arr as ArrayUtils;
use AckCore\Utils\File as FileUtils;
use AckCore\Utils\String as StringUtils;
/**
 * classe com funções que tratam de apenas um módulo do ack
 * descricao
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class ZF2Module extends Object
{
    const DEFAULT_SKELETON_SITE_MODULE = "SkeletonMainSite";
    protected $name;
    /**
     * array contendo os arquivos que são permitidos ficarem na pasta public em qualquer instalação do sistema
     * @var array
     */
    protected static $defaultPublicFiles = array("ack-core","galeria","plugins",".","..",".htaccess",".htaccess.online",".htaccess.local","index.php","README.md");
     /**
      * cria um novo módulo do zend framework 2
      * @param  [type] $moduleName [description]
      * @return [type]             [description]
      */
    public function create($moduleName)
    {
        Cmd::show("\nIncializando processo de criação...");
        if ( $this->checkModuleExistence($moduleName) ) {
            Cmd::out('Este módulo já existe.');
        }

        $publicPath = $totalPath = \AckCore\Facade::getPublicPath();
        //copia o módulo Skeleton Main Site
        $status = \AckCore\Utils\Directory::copyDirectory("$publicPath/../module/".self::DEFAULT_SKELETON_SITE_MODULE,"$publicPath/../module/$moduleName");

        if (!$status) {
            Cmd::out("Não foi possível copiar o módulo");
        } else {
            Cmd::show("Módulo copiado com sucesso");
        }

        Cmd::show("Customizando as variávies de acordo com o módulo");

        StringUtils::searchAndReplace("$publicPath/../module/$moduleName",self::DEFAULT_SKELETON_SITE_MODULE,$moduleName);
        Cmd::show("Renomeando os diretórios de namespaces");
        rename("$publicPath/../module/$moduleName/src/".self::DEFAULT_SKELETON_SITE_MODULE,"$publicPath/../module/$moduleName/src/$moduleName");

        $skeletonViewName = \AckCore\Model\ZF2Modules::getModulePublicFolder(self::DEFAULT_SKELETON_SITE_MODULE);
        $newModuleViewName = \AckCore\Model\ZF2Modules::getModulePublicFolder($moduleName);
        rename("$publicPath/../module/$moduleName/view/$skeletonViewName","$publicPath/../module/$moduleName/view/$newModuleViewName");
        StringUtils::searchAndReplace("$publicPath/../module/$moduleName","$skeletonViewName","$newModuleViewName");
        StringUtils::searchAndReplace("$publicPath/../module/$moduleName","#MAIN_DEFAULT_APPLICATION_MESSAGE","Modulo: $moduleName");
        StringUtils::searchAndReplace("$publicPath/../module/$moduleName",self::DEFAULT_SKELETON_SITE_MODULE,$moduleName);

        Cmd::show("Criação de módulo efetuada com sucesso!");

        return true;
    }
    /**
    * testa a consistencia de arquivos de instalação do ack
    * @return [type] [description]
    */
    public function checkModuleExistence($moduleName)
    {
        Cmd::show("Procurando a existência do módulo ...");
        $moduleMgr = new \AckCore\Model\ZF2Modules();

        if ($moduleMgr->moduleExists($moduleName)) {
            return true;
        }

        return false;
    }

    public function install($moduleName)
    {
        $mainModule = null;
        Cmd::show("\nIncializando processo de instalação...");
        //checa a consistência do arquivo de isntalação
        $configFilePath = $this->checkInstalationFilesConsistency($moduleName);
        $array = \AckCore\Utils\XML::toArray($configFilePath);

        $publicPath = $totalPath = \AckCore\Facade::getPublicPath();

        //========================= modulos =========================

        Cmd::show("Instalando os módulos Zend Framework");

        $zf2Modules = new \AckCore\Model\ZF2Modules;
        //testa a existência dos módulos passados pelo usuário
        foreach ($array["modules"]["module"] as $key => $module) {

                if (!$zf2Modules->moduleExists($module) &&
                    !Cmd::booleanQuestion("O módulo $module não foi encontrado, deseja mesmo assim instalá-lo?",true)) {
                    unset($array["modules"]["module"][$key]);
                }

                if(!$mainModule) $mainModule = $module;
        }
        //instala os módulos
        $moduleConfigStr = ArrayUtils::stringfy($array["modules"]["module"],",\n\t\t","'");

        $moduleConfigStr = "".'"modules" => array ('."\n\t\t".$moduleConfigStr."\n\t".'),#ENDMODULES_HASH'."\n";
        $applicationFilePath = \AckCore\Model\ZF2Application::getFullApplicationConfigPath();
        $applicationFileHandler = new FileUtils($applicationFilePath);
        $atualContent =  $applicationFileHandler->open("r")->read();
        $applicationFileHandler->close()->open("w+");
        $newContent = preg_replace('/"modules(.+)#ENDMODULES_HASH/s', $moduleConfigStr, $atualContent,1);
        $applicationFileHandler->write($newContent)->save()->close();

            Cmd::show("Módulos gravados com sucesso!");
        //======================= END modulos =======================
        //========================= database =========================
        //instala os módulos
        if (isset($array["database"])) {
            Cmd::show("gravando banco de dados");

            $newContent = '"db" => array('."\n";
            $databaseCfg =& $array["database"];
            if(isset($databaseCfg["username"]))
                $newContent.= "'username'=>'".$databaseCfg["username"]."',\n";
            if(isset($databaseCfg["password"]))
                $newContent.= "'password'=>'".$databaseCfg["password"]."',\n";
            if(isset($databaseCfg["dbname"]))
                $newContent.= "'dbname'=>'".$databaseCfg["dbname"]."',\n";

            $newContent.='),#ENDDATABASE_HASH';

            $localConfigFilePath = \AckCore\Model\ZF2Application::getConfigFilesPath()."/local.php";
            $applicationFileHandler = new FileUtils($localConfigFilePath);
            $atualContent =  $applicationFileHandler->open("r")->read();
            $applicationFileHandler->close()->open("w+");
            $newContent = preg_replace('/"db(.+)#ENDDATABASE_HASH/s', $newContent, $atualContent,1);
            $applicationFileHandler->write($newContent)->save()->close();
            Cmd::show("banco de dados gravado com sucesso!");
        }
        //======================= END database =======================
        //========================= desabilita os controllers bloquadoes =========================
        $modelZF2Controller = new \AckCore\Model\ZF2Controller;
        $modelZF2Controller->enableAll();

         if (isset($array["controllers"]["blacklist"])) {

            foreach ($array["controllers"]["blacklist"] as $item) {
                if(is_array($item))
                    foreach($item as $subItem)
                            $modelZF2Controller->disableByName($subItem);
                else
                    $modelZF2Controller->disableByName($item);
            }
         }
        //======================= END desabilita os controllers bloquadoes =======================

        //###################################################################################
        //################################# mover as pastas que estão em public para seu módulo respecitvo###########################################
        //###################################################################################
        if (\AckCore\Utils\Cmd::booleanQuestion("Deseja mover as pastas dos projetos de volta para seus respectivos módulos? ", true)) {
            $files = \AckCore\Utils\Directory::listAllFiles($publicPath);

           $modelZF2Modules = new \AckCore\Model\ZF2Modules;
            foreach ($files as $file) {

                //se estiver no array de arquivos default pula-o
                if(in_array($file, self::$defaultPublicFiles))
                    continue;
                $moduleCandidate = $this->makeModuleName($file);
                if ($modelZF2Modules->moduleExists($moduleCandidate)) {
                   //###################################################################################
                   //################################# move respectivamente###########################################
                   //###################################################################################
                    Cmd::show("Movendo as pasta de $moduleCandidate para seu respectivo projeto.");
                    if(file_exists("$publicPath/../module/$moduleCandidate/public/$file"))
                        if (\AckCore\Utils\Cmd::booleanQuestion("A pasta public módulo: $moduleCandidate já existe deseja que o sistema a sobreescreva (criando um backup)?",true)) {
                            $fromFolder = "$publicPath/../module/$moduleCandidate/public/$file";
                            $newFileName = $file."_backup".\AckCore\Utils\Date::now();
                            $toFolder = "$publicPath/../module/$moduleCandidate/public/".StringUtils::toUrl($newFileName);
                            if (rename($fromFolder,$toFolder)) {
                                \AckCore\Utils\Cmd::show("arquivos antigos renomeados com sucesso!");
                                rename("$publicPath/$file","$publicPath/../module/$moduleCandidate/public/$file");
                            }
                        } else {
                            Cmd::show("Pulando movimentacao");
                        } else {
                        \AckCore\Utils\Cmd::show("Sem duplicatas no projeto, movendo diretamente.  ");

                        $fileFrom = "$publicPath/$file";
                        $fileTo = "$publicPath/../module/$moduleCandidate/public/$file";
                        if(file_exists($fileFrom) && file_exists($fileTo))
                            rename($fileFrom,$fileTo);
                   }
                   //###################################################################################
                   //################################# END move respectivamente########################################
                   //###################################################################################

                }
            }

        }
        //###################################################################################
        //################################# END mover as pastas que estão em public para seu módulo respecitvo########################################
        //###################################################################################

        //###################################################################################
        //################################# criação de pastas de public###########################################
        //###################################################################################

        Cmd::show("Copiando pasta public");

        if (\AckCore\Utils\Cmd::booleanQuestion("Deseja remover os arquivos de outros projetos do diretório public?",false)) {
            if (\AckCore\Utils\Cmd::booleanQuestion("DESEJA REALMENTE FAZER ISSO? NOTA OS MÓDULOS QUE FORAM COPIADOS PARA O PUBLIC PODEM ES")) {

               Cmd::show("Removendo links anteriores");
               $files = shell_exec("ls $publicPath");
               $files = explode("\n",$files);

                foreach ($files as $key => $file) {
                    if (empty($file)) {
                        unset($files[$key]);
                        continue;
                    }
                    if (!in_array($file, \AckCore\Model\ZF2Application::$publicFilesWhitelist)) {
                        Cmd::show("Deletando o arquivo $file");
                        shell_exec("rm -rf $publicPath/$file");
                    }
               }
           }
       }

       $mainModulePublicFolder = $zf2Modules->getModulePublicFolder($mainModule);

        if (\AckCore\Utils\System::isUnix() && (\AckCore\Utils\Cmd::booleanQuestion("Deseja criar links simbólicos ao invés de copiar os diretórios? ", false))) {

               Cmd::show("Tentando criar links simbólicos");
               $command = "ln -s $publicPath/../module/$mainModule/public/$mainModulePublicFolder $publicPath/$mainModulePublicFolder";
               Cmd::show("Comando: $command");
               $result = exec($command);

               if(!empty($result))
                    Cmd::show("Algum problema ocorreu tentanto criar o link simbólico, o sistema tentará então copiar o diretorório");
                else
                    Cmd::show("Links criados com sucesso!");
       } else {
                Cmd::show("Copiando as pastas do módulo para o diretório public");
                if(file_exists("$publicPath/$mainModulePublicFolder"))
                    if (\AckCore\Utils\Cmd::booleanQuestion("A pasta do módulo já existe deseja que o sistema a sobreescreva (criando um backup)?",false)) {
                        $fromFolder = "$publicPath/$mainModulePublicFolder";
                        $newFileName = $mainModulePublicFolder."_backup".\AckCore\Utils\Date::now();
                        $toFolder = "$publicPath/".StringUtils::toUrl($newFileName);
                        if(rename($fromFolder,$toFolder))
                            \AckCore\Utils\Directory::copyDirectory("$publicPath/../module/$mainModule/public/$mainModulePublicFolder","$publicPath/$mainModulePublicFolder");

                    } else {
                        Cmd::show("Pulando cópia do arquivo");
                    } else
                    \AckCore\Utils\Directory::copyDirectory("$publicPath/../module/$mainModule/public/$mainModulePublicFolder","$publicPath/$mainModulePublicFolder");
       }
        //###################################################################################
        //################################# END criação de links simbólicos da pasta public########################################
        //###################################################################################
        Cmd::show("Fim do processo de instalação!");
    }
  /**
     * testa a consistencia de arquivos de instalação do ack
     * @return [type] [description]
     */
    public function checkInstalationFilesConsistency($moduleName)
    {
            Cmd::show("Procurando a existência do módulo ...");
            $moduleMgr = new \AckCore\Model\ZF2Modules();

            if (!$moduleMgr->moduleExists($moduleName)) {
                    Cmd::show("Este módulo não existe.");
                    exit(1);
            }
            Cmd::show("Módulo encontrado.");
            Cmd::show("Procurando por arquivo de configuração da instalação...");

            $path = $moduleMgr->getAckConfigFilePath($moduleName);
            if (!$path) {
                Cmd::show("Arquivo de configuração não encontrado.");
                exit(1);
            }
            Cmd::show("Arquivo de configuração encontrado.");

            return $path;
    }

    /**
     * transforma uma string em um nome possível de módulo do zf2
     * @param  [type] $str [description]
     * @return [type] [description]
     */
    public function makeModuleName($str)
    {
        $str = strtolower($str);
        $strCpy = $str;
        $upperStack = array();

        for ($i = 0; $i < strlen($strCpy); $i++) {
                if ($strCpy[$i] == "-") {
                    $upperStack[] = ($str[$i+1]);
                }

        }

        foreach ($upperStack as $char) {
                $newChar = strtoupper($char);
                $str = str_replace("-".$char, $newChar, $str);
        }

        $str = str_replace("-", "", $str);
        $str = ucfirst($str);

        return $str;
    }

     /**
     * retorna os nomes das pastas das views no padrão zf2
     *
     * @param [type] $str [description]
     *
     * @return [type] [description]
     */
    public static function getZF2ViewFormat(&$str)
    {
            $strCpy = $str;
            $upperStack = array();

            for ($i = 0; $i < strlen($strCpy); $i++) {
                    if (ctype_upper($strCpy[$i]) && $i != 0) {
                            $upperStack[] = $strCpy[$i];
                    }
            }

            foreach ($upperStack as $char) {
                    $newChar = strtolower($char);
                    $newChar = "-".$newChar;
                    $str = str_replace($char, $newChar, $str);
            }
            $str = strtolower($str);
            if($str[0] == "-")
                $str = substr($str,1);
    }

    public function getPublicFolder()
    {
        if(! $this->name) throw new \Exception("O nome do módulo não está setado", 1);

        $result =  $this->name;

        StringUtils::getZF2ViewFormat($result);

        return $result;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * pega os modelos de tabela de algum módulo
     * @param  string $moduleName nome do módulo
     * @return [type] [description]
     */
    public function getTableModelsMetaFromModule($moduleName)
    {
        $modelsMeta = $this->getAllModelsNamesFromModule($moduleName);

        foreach ($modelsMeta as $key => $model) {

            $modelName = $model['instantiableName'];

           try {
               $modelInstance = new $modelName;
               $modelInstance->getSchema();
           } catch (\Exception $e) {
                Cmd::show("Problema ao incluir table model: $modelName, mensagem: ".$e->getMessage());
                unset($modelsMeta[$key]);
                continue;
           }

            if (!$modelInstance instanceof \AckDb\ZF1\TableAbstract) {
                Cmd::show("Modelo $modelName não é uma instância de:  \AckDb\ZF1\TableAbstract");
                unset($modelsMeta[$key]);
                continue;
            }
        }

        return $modelsMeta;
    }

    public function getAllModelsNamesFromModule($moduleName)
    {
        if (!$this->checkModuleExistence($moduleName)) {
            Cmd::out('Este módulo não existe');
        }

        $result = array();
        $path  = \AckCore\Facade::getPublicPath(). "/../module/$moduleName/src/$moduleName/Model";
        $entrys = \AckCore\Utils\Directory::listAllFiles($path);

        if (!empty($entrys)) {
            foreach ($entrys as $entry) {

                $className = \AckCore\Utils\File::removeExtension($entry);

                if ( empty($className ) ) {
                    continue;
                }

                $tmp = array(
                    'instantiableName' => '\\'.$moduleName.'\\Model\\'.$className,
                    'name' => $className,
                    'fullPath' => $path.'/'.$className.'.php'
                );

                $entryName = $tmp['instantiableName'];
                try {
                $entryInstance = new $entryName;

                } catch (\Exception $e) {

                }

                if (method_exists($entryInstance, 'getTableName')) {
                    $tmp['table_name'] = $entryInstance->getTableName();
                }
                $result[] = $tmp;
            }
        }

        return $result;
    }
}
