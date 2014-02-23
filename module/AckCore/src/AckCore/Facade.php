<?php
/**
 * classe que implementa o padrão de projeto facade oferecendo um meio facilitado
 * para se obter vários recursos e informações  do sistema
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
namespace AckCore;
use AckCore\HtmlEncapsulated,
\AckCore\Model\Versions,
\AckCore\Model\ZF2Modules;
/**
 * padrão facade
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Facade extends Object
{

    protected static $cache;
    protected static $dbInstances;
    protected $currentRow;
    protected $paramsRoute;
    public static $instance;
    protected static $controllerConfig = null;
    protected static $currentUser;
    protected static $configurações;
    protected static $serviceManager;

    /**
     * getter de ServiceManager
     *
     * @return ServiceManager
     */
    public static function getServiceManager()
    {
        return self::$serviceManager;
    }

    /**
     * setter de ServiceManager
     *
     * @param int $serviceManager
     *
     * @return $this retorna o próprio objeto
     */
    public static function setServiceManager($serviceManager)
    {
        self::$serviceManager = $serviceManager;
    }

//###################################################################################
//################################# funções do ack exclusivas ###########################################
//###################################################################################

    public static function getLayoutName()
    {
        return HtmlEncapsulated::$genericLayout;
    }

    public static function setLayoutName($name)
    {
        HtmlEncapsulated::$genericLayout = $name;

        return true;
    }

    public static function getAckVersion()
    {
        $modelVersions = new Versions;
        $version =  $modelVersions->toObject()->onlyAvailable()->getLast();

        return $version->getVersao()->getVal();
    }

    /**
     * retorna o valor de debug de todo o sistema
     * @return [type] [description]
     */
    public static function debugStatus()
    {
        if(self::$cache[__FUNCTION__]) return self::$cache[__FUNCTION__];

        $cfg = self::getGlobalConfig();
        $result = (isset($cfg['debug'])) ? $cfg['debug']  : false;

        return $result;
    }

    public static function &getLogWriter()
    {
        if(self::$cache[__FUNCTION__]) return self::$cache[__FUNCTION__];

        $writer = new \Zend\Log\Writer\Stream(self::getPublicPath()."/../logs/error");
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        self::$cache[__FUNCTION__] = $logger;

        return $logger;
    }

//###################################################################################
//################################# END funções do ack exclusivas ########################################
//###################################################################################
//###################################################################################
//################################# funções para dados de url ###########################################
//###################################################################################

    /**
     * retorna ums string contendo o nome do controlador e da ação atuais
     * @param  string $separator [description]
     * @return [type] [description]
     */
    public static function getControllerAction($separator = "/")
    {
        $params = self::getStaticParamsRoute();
        $result = $params["__CONTROLLER__"].$separator.$params["action"];

        return $result;
    }

    public static function getAuthInstance()
    {
        $auth = new \AckUsers\Auth\User;
        // $auth = new \AckUsers\Auth\User;
        // if (self::getPublicFolderOfMainModule() == "SiteJean") {
        //     $auth = new \AckUsers\Auth\Usuario;
        // }
        return $auth;
    }

    public static function getSpecificAssetsBlacklisted()
    {
        return array("Dashboard/index");
    }

    public static function getEnderecoSite()
    {
        if(!empty(self::$cache[__FUNCTION__])) return self::$cache[__FUNCTION__];

        if (isset($_SERVER["SERVER_NAME"])) {
            $result = "http://".$_SERVER["SERVER_NAME"];
            $result.= (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") ? ":".$_SERVER["SERVER_PORT"] :  "";
        } else {
            $result = "http://www.jeancarlomachado.com.br";
        }

        self::$cache[__FUNCTION__] = $result;

        return $result;
    }

    /**
     * monta a url atula
     * @return [type] [description]
     */
    public static function mountUrl()
    {
        $baseUrl = self::getServerName();
        $baseUrl = $baseUrl."/".self::getUrlController();

        return $baseUrl;
    }

    public static function getServerName()
    {
        $baseUrl = "http://";
        $baseUrl.= ($_SERVER["SERVER_PORT"] != "80") ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] : $_SERVER["SERVER_NAME"];

        return $baseUrl;
    }

    public static function getUrlId()
    {
        return self::getInstance()->paramsRoute["id"];
    }

    public function getParamsRoute()
    {
        return $this->paramsRoute;
    }

    public static function getStaticParamsRoute()
    {
        return self::getInstance()->paramsRoute;
    }

    /**
     * retorna o nome do controlador
     * Modulo/Controller/Name
     * que o zend 2 retorna
     *
     * @return [type] [description]
     */
    public static function getControllerName()
    {
        return self::getInstance()->paramsRoute["controller"];
    }

    /**
     * retorna o nome do controlador
     * Modulo/Controller/Name
     * que o zend 2 retorna
     *
     * @return [type] [description]
     */
    public static function getUrlController()
    {
        $controller =  self::getInstance()->paramsRoute["controller"];

        $controller = explode("\\",$controller);
        $controller = end($controller);
        $controller = strtolower($controller);

        return $controller;
    }

    /**
     * retorna o nome do controlador
     * Modulo/Controller/Name
     * que o zend 2 retorna
     *
     * @return [type] [description]
     */
    public static function getUrlAction()
    {
        $action =  self::getInstance()->paramsRoute["action"];
        $action = strtolower($action);

        return $action;
    }

    /**
     * retorna o nome completo do controlaor pronto para ser acessado
     * /Modulo/Controller/NameController
     * @return [type] [description]
     */
    public static function getFullControllerName()
    {
        return "\\".self::getInstance()->paramsRoute["controller"]."Controller";
    }

    public function getActionName()
    {
        return $this->paramsRoute["action"];
    }

    public function getSiteURI()
    {
        $endereco_site = 'http';
         if (@$_SERVER["HTTPS"] == "on") {$endereco_site .= "s";}
            $endereco_site .= "://";

        if(!isset($_SERVER["SERVER_NAME"])) return "";

        $endereco_site.= (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] : $_SERVER["SERVER_NAME"];

        return $endereco_site;
    }

//###################################################################################
//################################# END funções para dados de url ########################################
//###################################################################################
////###################################################################################
//################################# funções para pegar configurações ###########################################
//###################################################################################

    /**
     * retorna o caminho para o logo de e-mail do sistema
     * @return [type] [description]
     */
    public static function getEmailLogoPath()
    {
        $config = self::getModuleConfig();
        $result = $config["ack"]["emailLogo"];
        $result = str_replace("#sitename#", self::getPublicFolderOfMainModule(), $result);
        $result = self::getEnderecoSite().$result;

        return $result;
    }

    /**
     * retorna o nome do diretório público do módulo
     * principal atualmente instalado
     * @return [type] [description]
     */
    public static function getPublicFolderOfMainModule()
    {
        $modules = new ZF2Modules;
        $module = $modules->getMainModuleInstance();
        $result = $module->getPublicFolder();

        return $result;
    }

    public static function getMainModuleName()
    {
        $modules = new ZF2Modules;
        $module = $modules->getMainModuleName();

        return $module;
    }

    public static function getModulesEnabled()
    {
        $cfg = self::getApplicationConfig();

        return $cfg["modules"];
    }

    public function getControllerConfig()
    {
        return self::$controllerConfig;
    }

    public function setControllerConfig(&$controllerConfig)
    {
        self::$controllerConfig = $controllerConfig;

        return $this;
    }

    /**
     * retorna um merge dos arquivos de configuração
     * @param  [type] $object [description]
     * @return [type] [description]
     */
    public function getMergedConfig(&$object)
    {
        if($object instanceof \AckMvc\Controller\Base)

        return $object->getServiceLocator()->get("Config");
    }

    public static function getModuleConfig($moduleName = "\AckCore\Module")
    {
        if(!empty(self::$cache[__FUNCTION__.$moduleName])) return self::$cache[__FUNCTION__.$moduleName];

        $obj = new $moduleName();
        $result = $obj->getConfig();

        self::$cache[__FUNCTION__.$moduleName] = $result;

        return $result;
    }
    public static function getGlobalConfig()
    {
        if (empty(self::$cache["globalConfig"])) {
            // $global = include $_SERVER["DOCUMENT_ROOT"]."/../config/autoload/global.php";
            // $local = include $_SERVER["DOCUMENT_ROOT"]."/../config/autoload/local.php";
            $global = include __DIR__."/../../../../../config/autoload/global.php";
            $local = include __DIR__."/../../../../../config/autoload/local.php";

            if (is_array($local))  $global = \AckCore\Utils\Arr::mergeReplacingOnlyFinalKeys($global,$local);

            self::$cache["globalConfig"] = $global;
        }

        return self::$cache["globalConfig"];
    }

    public function setParamsRoute($paramsRoute)
    {
        $this->paramsRoute = $paramsRoute;

        return $this;
    }

    public static function getCurrentModulePath()
    {
        return $_SERVER["DOCUMENT_ROOT"]."/../module/".self::getCurrentModuleName()."/";
    }

    public static function getCurrentModuleName()
    {
        $module = (self::getInstance()->paramsRoute["__NAMESPACE__"]);
        $module = explode("\\",$module);
        $module =  reset($module);

        return $module;
    }

    public function getMainMenuConfig()
    {
        $config =  $this->getModuleConfig();

        return $config["main_menu"];
    }

    /**
     * a leitura de controladores deve ser automatizada
     * @return [type] [description]
     */
    public static function getAllControllersNames()
    {
        $config = self::getGlobalConfig();

        return $config["content_managed_controllers"];
    }
//###################################################################################
//################################# END funções para pegar configurações ########################################
//###################################################################################
//###################################################################################
//################################# relativo ao retorno de objetos ###########################################
//###################################################################################

    public function getCurrentRow()
    {
        if (empty($this->currRow))
            throw new \Exception("Linha atual não foi definida");

        return $this->currRow;
    }

    /**
     * retorna o usuário atual do sistema
     * @return [type] [description]
     */
    public static function getCurrentUser()
    {
        return self::$currentUser;
    }

    public static function setCurrentUser($user)
    {
        self::$currentUser = $user;
        $result = null;

        //guarda cache somente se haver um usuário já guardado
        //if(self::$cache[__FUNCTION__] && self::$cache[__FUNCTION__]->getId()->getBruteVal()) return self::$cache[__FUNCTION__];

        $auth = static::getAuthInstance();
        $result = $auth->getUserObject();

        //self::$cache[__FUNCTION__] = $result;
        return $result;
    }

    /**
     * seta uma instãncia de banco de dados
     * @param [type] $database [description]
     * @param [type] $key      [description]
     */
    public static function setDatabaseIntance($database,$key)
    {
        self::$dbInstances[$key] = $database;

        return true;
    }

    public static function getDatabaseIntance($key)
    {
        return self::$dbInstances[$key];
    }

    public static function getDbInstance()
    {
        return \Zend_Registry::get("db");
    }

    public static function getInstance()
    {
        if(empty(self::$instance))
            self::$instance = new Facade;

        return self::$instance;
    }

//###################################################################################
//################################# END relativo ao retorno de objetos ########################################
//###################################################################################
//###################################################################################
//################################# configurações configurações de caminhos ###########################################
//###################################################################################

    public function getDefaultPermissionLevel()
    {
        return 1;
    }

    /**
     * retorna o caminho das views default do sistema
     * @return [type] [description]
     */
    public static function getDefaulViewsFolder()
    {
        return self::getPublicPath().'/../module/SiteJean/view/SiteJean/default';
    }

    public function getCurrentLanguage()
    {
        return "pt";
    }

    public function getAjaxPackageName()
    {
        $module = self::getCurrentModuleName();

        if ($module  == "SkeletonMainSite") {
            return "ajaxData";
        }

        return "ajaxACK";
    }

    public static function getLanguageSuffixes()
    {
        return array("pt", "en", "es");
    }

    public static function getMainLanguage()
    {
        return 'pt';
    }

    public function setCurrentRow(&$row)
    {
        $this->currRow = $row;

        return $this;
    }

    /**
     * retorna o caminho completo para a pasta public do sistema
     * @return [type] [description]
     */
    public static function getPublicPath()
    {
        //se não existe document root o sistema
        //leva em consideração que o usuário está na pasta public
        if ($_SERVER['DOCUMENT_ROOT']) {
            return $_SERVER['DOCUMENT_ROOT'];
        }

        return __DIR__.'/../../../../public';
    }
//###################################################################################
//################################# END configurações de caminhos ########################################
//###################################################################################
}
