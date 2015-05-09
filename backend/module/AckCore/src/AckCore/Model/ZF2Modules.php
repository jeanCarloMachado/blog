<?php
namespace AckCore\Model;
use AckCore\Object;
class ZF2Modules extends Object
{
    const INSTALL_MODULE_FILE = "config/ack.config.xml";
    protected function transformModuleControllersArrayToInstantiableClasses($array)
    {
        $result = array();
        foreach ($array as $moduleName => $controllersArray) {
            foreach($controllersArray as $controller)
                $result[] = "\\$moduleName\Controller\\$controller";
        }

        return $result;
    }
    /**
     * retorna o nome do módulo principal do sistema
     * (o primeiro módulo do array de confi.)
     * @return [type] [description]
     */
    public function getMainModuleName()
    {
        $config = \AckCore\Facade::getServiceManager()->get('ApplicationConfig');

        return $config["modules"][0];
    }

    /**
     * retorna a instância de um objeto representando módulo do
     * zend princiapl
     * @return [type] [description]
     */
    public function getMainModuleInstance()
    {
        $module = new ZF2Module();
        $module->setName($this->getMainModuleName());

        return $module;
    }

    /**
     * retorna todos os módulos habilitados no application config
     * @return [type] [description]
     */
    public function getModulesEnabled()
    {
        $config = \AckCore\Facade::getApplicationConfig();

        return $config["modules"];
    }

    public function getAllModulesAvailable()
    {
        $path  = \AckCore\Facade::getPublicPath(). "/../module";

        $entrys = \AckCore\Utils\Directory::listAllFiles($path);

        foreach ($entrys as $key => $entry) {
            if(preg_match('/^\./',$entry))
                unset($entrys[$key]);
        }

        return $entrys;
    }
    /**
     * retorna todos os controllers habilitados no sistema
     * @return [type] [description]
     */
    public function getControllersEnabled()
    {
        $modules = $this->getModulesEnabled();
        $controllers = array();

        foreach ($modules as $module) {

            //remove módulos de controllers diferenciados
            if($module == 'AckMvc' || $module == 'AckCmd') continue;

            $tmp = $this->getControllersFromModule($module);
            if(is_array($tmp))
            $controllers = array_merge($controllers,$tmp);
        }

        return $controllers;
    }
    /**
     * retorna todos os controllers habilitados no sistema
     * @return [type] [description]
     */
    public function getInstantiableControllersEnabled()
    {
        $controllers = $this->getControllersEnabled();
        $controllers = $this->transformModuleControllersArrayToInstantiableClasses($controllers);

        return $controllers;
    }

    public function listAllModulesFromModuleDirectory()
    {
    }

    public function getControllersFromModule($moduleName)
    {
        if (empty($moduleName)) {
            throw new \Exception("Deve-se passar como argumento principal um nome de módulo válido e existente (string vazia).");
        }

        $result = null;
        $path  = \AckCore\Facade::getPublicPath(). "/../module/$moduleName/src/$moduleName/Controller";
        $entrys = \AckCore\Utils\Directory::listAllFiles($path);

        if(!empty($entrys))
        foreach ($entrys as $entry) {
            $className = \AckCore\Utils\File::removeExtension($entry);
            if (preg_match('/Controller/', $className)) {
                $result[$moduleName][] = $className;
            }
        }

        return $result;
    }

    /**
     * testa se o módulo passado existe dentro
     * da pasta /module no ack
     * @param  [type] $moduleName [description]
     * @return [type] [description]
     */
    public function moduleExists($moduleName)
    {
        $modules = $this->getAllModulesAvailable();

        if (in_array($moduleName, $modules)) {
            return true;
        }

        return false;
    }

    /**
     * função depreciada utilizar a de zfmodule
     * @param  [type] $moduleName [description]
     * @return [type] [description]
     */
    public function getModulePublicFolder($moduleName)
    {
        \AckCore\Utils\String::getZF2ViewFormat($moduleName);

        return $moduleName;
    }

    public function getModulePath($moduleName)
    {
        if(!$this->moduleExists($moduleName))
            throw new \Exception("Módulo inexistente", 1);

        return \AckCore\Facade::getPublicPath(). "/../module/$moduleName";
    }

    /**
     * testa se o módulo contém o arquiov de configuração do ack
     * @param  [type]  $moduleName [description]
     * @return boolean [description]
     */
    public function getAckConfigFilePath($moduleName)
    {
        if (empty($moduleName)) {
            throw new \Exception("Deve-se passar como argumento principal um nome de módulo válido e existente (string vazia).");
        }

        $totalPath = \AckCore\Facade::getPublicPath(). "/../module/$moduleName/".self::INSTALL_MODULE_FILE;

        if(file_exists($totalPath)) return $totalPath;

        return null;
    }

    public function getModelMetaFromTableName($tableName)
    {
        $modules = $this->getServiceLocator()->get('ApplicationConfig');
        $modules = $modules['modules'];

        foreach ($modules as $module) {

            $modelsMeta = $this->getServiceLocator()->get('ZF2Module')->getAllModelsNamesFromModule($module);

            foreach ($modelsMeta as $modelMeta) {

                $modelName = $modelMeta['instantiableName'];

                if (! is_a($modelName, '\AckDb\ZF1\TableAbstract', true)) {
                    continue;
                }

                try {
                    $modelInstance  = new $modelName;

                    if (!$modelInstance instanceof \AckDb\ZF1\TableAbstract) {

                        continue;
                    }

                    $modelInstance->getSchema();

                    $modelMeta['table_name'] = $modelInstance->getTableName();

                } catch (\Exception $e) {
                    continue;
                }

                $tableNameOfInstance = $modelInstance->getTableName();

                if (!empty($tableNameOfInstance) && $tableName == $tableNameOfInstance) {
                    return $modelMeta;
                }

            }
        }
    }
}
