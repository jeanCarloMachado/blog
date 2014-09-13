<?php
/**
 * mapeador automático para as relações do sistema ack
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
namespace AckDevel\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AckCore\Utils\Cmd;
use AckCore\Utils\Arr as ArrayUtils;
/**
 * mapeador automático para as relação do ack
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class TableModels implements ServiceLocatorAwareInterface
{

    protected $moduleName;

    protected $serviceLocator;

    const CACHE_FILE = '/../../../var/mappedTableColumnsAliases';

    public function getCacheFilePath()
    {
        return __DIR__.self::CACHE_FILE;
    }

    public function __construct($moduleName = null)
    {
        $this->moduleName = $moduleName;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        if (empty($this->serviceLocator)) {

            $this->serviceLocator = Facade::getServiceManager();
        }

        return $this->serviceLocator;
    }

    public function mapAliasesFromModule($moduleName)
    {
        if (!empty($moduleName)) {
            $this->moduleName = $moduleName;
        }

        $models = $this->getServiceLocator()->get('ZF2Module')->getTableModelsMetaFromModule($moduleName);

        $cacheFile = $this->getCacheFilePath();

        foreach ($models as $modelMeta) {

            Cmd::show("Adicionando aliases para o modelo: ".$modelMeta['name']);

            $modelName = $modelMeta['instantiableName'];

            $modelInstance = new $modelName;

            $columns = $this->getServiceLocator()->get('DBUtils')->getColumnsNames($modelInstance);

            $newNames = array();

            foreach ($columns as $columnName) {

                //remove as colunas renomeadas automaticamente
                if ($columnName == 'id' || $columnName == 'status' || $columnName == 'visivel' || $columnName == 'ordem') {
                    continue;
                }

                $columnValue = `grep '^$columnName:' $cacheFile | cut -d ':' -f2 `;

                if (!empty($columnValue)) {

                    $candidate = ucfirst($columnName);

                    if ($candidate != $columnValue) {
                        $newNames[$columnName] = $columnValue;
                    }
                } else {

                    $candidate = ucfirst($columnName);

                    $value = Cmd::interact("Digite a correta versão para a coluna $columnName - default: $candidate", $candidate);

                    $this->setCacheAlias($columnName, $value);

                    if ($candidate != $value) {
                        $newNames[$columnName] = $value;
                    }
                }

            }

            if (!empty($newNames)) {

                $this->removeNamesAliases($modelMeta);
                //seta os nomes nos modelos:
                $newNames = ArrayUtils::transformProcessTimeArrayIntoRespectivePhpInlineArray($newNames);
                $newNames = 'protected $colsNicks = '.$newNames.';';

                $this->addNamesAliases($modelMeta, $newNames);

            }
        }
    }

    public function addNamesAliases($modelMeta, $array)
    {
        $modelFullPath = $modelMeta['fullPath'];

        $file = `cat $modelFullPath`;

        if (preg_match('% extends Table.*\s.*%', $file)) {

            $replace = ' extends Table'.PHP_EOL.'{'.PHP_EOL.'    '.$array;

            $file = preg_replace('% extends Table.*\s.*%', $replace, $file);

            $file = str_replace("'", '"', $file);

        } else {
            Cmd::show('!!!!!!!!!!!!!Não deu match com o extends Table ARRUMAR '.$modelFullPath.'!!!!!!!!!!!!!');

            return false;
        }

        $result = `echo '$file' > $modelFullPath`;

        return true;
    }

    public function removeNamesAliases($modelMeta)
    {
        $modelFullPath = $modelMeta['fullPath'];

        $file = `cat $modelFullPath`;
        $file = preg_replace('/protected \$colsNicks.[^\$]+;/s', '', $file);
        $file = str_replace("'", '"', $file);

        $result = `echo '$file' > $modelFullPath`;

        return true;
    }

    public function setCacheAlias($columnName,$columnValue)
    {
        $cacheFile = $this->getCacheFilePath();

        `echo $columnName:$columnValue >> $cacheFile`;

        return true;
    }

    /**
     * getter de ModuleName
     *
     * @return ModuleName
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * setter de ModuleName
     *
     * @param int $moduleName
     *
     * @return $this retorna o próprio objeto
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }
}
