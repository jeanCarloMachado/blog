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
use AckCore\Facade;
/**
 * mapeador automático para as relação do ack
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class RelationsMapper implements ServiceLocatorAwareInterface
{
    protected $moduleName;

    protected $serviceLocator;

    public function __construct($moduleName = null)
    {
        $this->moduleName = $moduleName;
    }

    public function mapModule($moduleName = null)
    {
        if (!empty($moduleName)) {
            $this->moduleName = $moduleName;
        }

        $models = $this->getModelsNames();

        foreach ($models as $modelMeta) {

            Cmd::show(PHP_EOL.'#################### '.strtoupper($modelMeta['name']).' #####################');

            //se setou o identificador, busca relações para mapear
            if ( $this->setHumanizedIdentifier($modelMeta) ) {

                Cmd::show(PHP_EOL);
                Cmd::show('Mapeando as relações para o modelo '.$modelMeta['name']);

                if ($this->buildModelRelations($modelMeta)) {
                    Cmd::show ('Sucesso ao adiconar as relações em '.$modelMeta['name']);
                } else {
                    continue;
                }
            }

        }
    }

    public function hasModelRelations($modelMeta)
    {
        $modelFullPath = $modelMeta['fullPath'];

        $scan = `grep relations $modelFullPath`;

        return $scan;
    }

    /**
     * mapeia as relações de um modelo
     *
     * @param array $modelMeta metadados do modelo
     *
     * @return boolean true if success
     */
    public function buildModelRelations($modelMeta)
    {
        $override = false;

        if ($this->hasModelRelations($modelMeta)) {
            if (Cmd::booleanQuestion('Já existe mapeamento de relações para esta tabela deseja pular?', true)) {
                return true;
            } else {
                $override = true;
            }
        }

        $tablesNames = $this->getServiceLocator()->get('DBUtils')->getAllTablesNames();

        $columns = $this->getRelationCandidatesColumns($modelMeta);

        if (empty($columns)) {
            Cmd::show('Nenhuma coluna candidata à relacionamentos externos - pulando');

            return false;
        } else {

            Cmd::show('Procurando em outras tabelas por possíveis relacionamentos com as colunas da tabela');

            $newRelations = array();
            foreach ($columns as $column) {

                $relationAdded = false;

                Cmd::show('Iniciando pesquisa para a coluna: '.$column);
                $relevantName = preg_replace("%_id%", '', $column);
                foreach ($tablesNames as $tableName) {
                    if (preg_match("/[a-zA-Z]*_$relevantName$/", $tableName) && $modelMeta['table_name'] != $tableName) {

                        $default = true;

                        if (preg_match('%categoria|status%', $relevantName)) {
                            $default = false;
                        }

                         if ( Cmd::booleanQuestion('A tabela '.$modelMeta['name'].'.'.$column.' parece se relacionar com '.$tableName.', você confirma essa relação?', $default)) {

                            $newRelations['1:n'][] = $this->addRelationEntry($modelMeta, $column, $tableName);

                            $relationAdded = true;

                        } else {
                            Cmd::show ('Pulando relacionamento candidato..');

                            continue;
                        }

                    }
                }

                if (! $relationAdded &&
                    Cmd::booleanQuestion('Nenhum mapeamento foi encontrado para a coluna '.$column.' deseja adicionar um manualmente?',false)
                    ) {
                    $newRelations['1:n'][] = $this->addRelationEntry($modelMeta, $column);
                }

            }

            //========================= pega as relações atuais da classe para dar merge =========================
            $modelName = $modelMeta['instantiableName'];
            $modelInstance = new $modelName;
            $relations = $modelInstance->getRelations();

            if (!empty($relations) && is_array($relations['1:n'])) {
                foreach ($relations['1:n'] as $key => $value) {

                    if (!array_key_exists($key, $newRelations)) {
                        if (Cmd::booleanQuestion('A relação '.$key.' existia antigamente na configuração deseja manter? ')) {
                            $newRelations[$key] = $value;
                        }
                    }
                }
            }

            //======================= END pega as relações atuais da classe para dar merge =======================

            if (empty($newRelations)) {
                Cmd::show('Novas relações vazias, terminando o mapeamento.');
            }

            $newRelations = ArrayUtils::transformProcessTimeArrayIntoRespectivePhpInlineArray($newRelations);

            $newRelations = 'protected $relations = '.$newRelations.';';
            Cmd::show ('================ Adiconando às relações no arquivo ================');

            if ($override) {
                $this->removeRelationsArray($modelMeta);
            }

            $this->addRelationsArray($modelMeta, $newRelations);

            //instancia novamento o modelo para testes
            try {
                $modelInstance = new $modelName;

                return true;
            } catch (\Exception $e) {
                Cmd::out('Problema inesperado na classe: '.$modelMeta['name'].' ajuste antes de continuar');

                return false;
            }
        }

        return false;
    }

    public function addRelationEntry($modelMeta, $column,  $relatedTableName = null)
    {
        $relevantName = preg_replace("%_id%", '', $column);

        if (empty($relatedTableName)) {
            $relatedTableName = Cmd::interact('Digite o nome da tabela à se relacionar.');
        }

        $relatedModelMeta = $this->getServiceLocator()->get('ZF2Modules')->getModelMetaFromTableName($relatedTableName);

        if (empty($relatedModelMeta)) {
            Cmd::show('Não encontrou modelo que mapeie a tabela '.$relatedTableName.', pulando...');

            continue;
        }

        $elementTitle = Cmd::interact('Digite o título da sessão:', ucfirst($relevantName));

        $relatedRowUrlTemplate = '/'.strtolower($relatedModelMeta['name']).'/editar/{id}';

        $relatedRowUrlTemplate = Cmd::interact('Digite a url a relacionar:', $relatedRowUrlTemplate);

         return array('model' =>$relatedModelMeta['instantiableName'],'reference'=>$column,'elementTitle'=>$elementTitle, 'relatedRowUrlTemplate'=> $relatedRowUrlTemplate);
    }

    public function removeRelationsArray($modelMeta)
    {
        $modelFullPath = $modelMeta['fullPath'];

        $file = `cat $modelFullPath`;
        $file = preg_replace('/protected \$relations.[^\$]+;/s', '', $file);
        $file = str_replace("'", '"', $file);

        $result = `echo '$file' > $modelFullPath`;

        return true;
    }

    public function addRelationsArray($modelMeta, $array)
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

    public function hasRelationsArray($modelFullPath)
    {
        $scan = `grep relations $modelFullPath`;

        return $scan;
    }

    public function getRelationCandidatesColumns($modelMeta)
    {

        $modelName = $modelMeta['instantiableName'];
        $modelInstance = new $modelName;

        $columns = $this->getServiceLocator()->get('DBUtils')->getColumnsNames($modelInstance);

        $result = array();
        foreach ($columns as $column) {

            if (preg_match("/^.*_id$/", $column)) {
                $result[] = $column;
            }
        }

        return $result;
    }

    public function setHumanizedIdentifier($modelMeta)
    {
        if ($this->hasRelationsArray($modelMeta['fullPath'])) {
            return true;
        }

        $modelName = $modelMeta['instantiableName'];

        try {
            $modelInstance = new $modelName;
            $modelInstance->getSchema();
        } catch (\Exception $e) {
            return;
        }

        if (!$modelInstance instanceof \AckDb\ZF1\TableAbstract) {
            Cmd::show($modelMeta['name'].' não herda de TableAbstract, pulando');

            return;
        }

        if (! $this->hasHumanizedIdentifier($modelMeta['fullPath'])) {
            Cmd::show('Adicionando humanized identifier ao modelo: '.$modelMeta['name']);
            $this->addHumanizedIdentifier($modelMeta);

            //instancia novamento o modelo para testes
            try {
                $modelInstance = new $modelName;
            } catch (\Exception $e) {
                Cmd::out('Problema inesperado na classe: '.$modelMeta['name'].' ajuste antes de continuar');
            }

            return true;
        } else {
            Cmd::show('Modelo: '.$modelMeta['name'].' já tem o identificador humanizado.');

            return true;
        }

        return false;
    }

    public function hasHumanizedIdentifier($modelFullPath)
    {
        $scan = `grep humanizedIdentifier $modelFullPath`;

        return $scan;
    }

    public function addHumanizedIdentifier($modelMeta)
    {
        $modelFullPath = $modelMeta['fullPath'];

        $file = `cat $modelFullPath`;

        if (preg_match('% extends Table.*\s.*%', $file)) {

            $identifier = $this->getHuminizedIdentifiersCandidates($modelMeta);

            Cmd::show('Identificador: '.$identifier.' escolhido');

            $replace = ' extends Table'.PHP_EOL.'{'.PHP_EOL.'    protected $meta = array('.PHP_EOL.'        "humanizedIdentifier" => "'.$identifier.'",'.PHP_EOL.'   );';

            $file = preg_replace('% extends Table.*\s.*%', $replace, $file);

            $file = str_replace("'", '"', $file);
        } else {
            Cmd::show('!!!!!!!!!!!!!Não deu match com o extends Table ARRUMAR '.$modelFullPath.'!!!!!!!!!!!!!');
        }

        $result = `echo '$file' > $modelFullPath`;
    }

    /**
     * menu iterativo para a escolha da coluna
     * que será o identificador humanizado
     * @param  [type] $modelMeta [description]
     * @return [type] [description]
     */
    public function getHuminizedIdentifiersCandidates($modelMeta)
    {
        $modelName = $modelMeta['instantiableName'];

        $modelInstance = new $modelName;
        $schema = $modelInstance->getSchema();

        Cmd::show('Colunas da tabela');

        foreach ($schema as $key => $columnData) {

            Cmd::show($key.' - '.$columnData['Field']);

        }

        $index = Cmd::interact('Digite o índice da escolhida: ', 0);

        return $schema[$index]['Field'];
    }

    public function getModelsNames()
    {
        return $this->getServiceLocator()->get('ZF2Module')->getAllModelsNamesFromModule($this->getModuleName());
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
