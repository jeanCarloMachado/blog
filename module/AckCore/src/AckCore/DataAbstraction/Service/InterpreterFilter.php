<?php
/**
 * interpretador dos filtros de busca do ack
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
namespace AckCore\DataAbstraction\Service;
/**
 * interpretador dos filtros de busca do ack
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class InterpreterFilter extends InterpreterAbstract
{

    public function __invoke(array $params=null)
    {
        $this->setCustomConfig($params);

        return $this->getFromRow($params['row']);
    }

    /**
     * retorna um set de objetos filtros para serem renderizados
     * à partir de uma linha do banco de dados
     *
     * @param AckDbZF1RowAbstract $row tabela que servirá de fonte para os filtros
     *
     * @return array array com html elements
     */
    public function getFromRow(\AckDb\ZF1\RowAbstract $row)
    {

        $result = array();
        foreach ($row->vars as $key => $column) {

            if (!$this->isAllowedToRender($row,$key)) {
                continue;
            }

            $config = $this->getConfigFromVariable($column);

            if((isset($config['renderFilter']) && $config['renderFilter'] == false)
               || !\AckCore\Model\Language::isAPtColumn($column->getColumnName())){
             continue;
            }

            //instancia o elemento
            $elementName = $this->getFiltersPreffix().$config['FilterHTMLType'];
            $htmlElement = $elementName::Factory($column);

            if (isset($config['FilterDefaultValue'])) {
                $htmlElement->setDefaultValue($config['FilterDefaultValue']);
            }

            if (isset($config['title'])) {
                $htmlElement->setTitle($config['title']);
            }
            $result[] = $htmlElement;
        }

        return $result;
    }

    /**
     * testa se é permitido renderizar alguma coluna
     * @param  [type]  $row [description]
     * @param  [type]  $key [description]
     * @return boolean [description]
     */
    protected function isAllowedToRender(&$row,$key)
    {

        $customConfig = $this->getCustomConfig();
        if(isset($customConfig['filters']['blacklist']) && in_array($key,$customConfig['filters']['blacklist'])) return false;

        /**
         * testa o caso especial do fakeid
         * @var string
         */
        if ($key == 'id') {
            if(isset($customConfig['whitelist']) && in_array('fakeid',$customConfig['whitelist'])) return true;
        } else if($key == 'id') return false;
        else if($key == 'visivel' && isset($this->customConfig['disableVisible'])) return false;

        if(!$this->renderColumnApproved($row->vars[$key],$key,$row,$customConfig)) return false;

        return true;
    }

    /**
     * retoana o prefixo dos objetos do tipo filtro
     * @return [type] [description]
     */
    public function getFiltersPreffix()
    {
        $cfg = $this->getMergedConfig();

        return $cfg['elementsSettings']['FilterHTMLTypePreffix'];
    }
}
