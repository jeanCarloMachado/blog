<?php
/**
 * classe pai para elementos html de relação
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

namespace AckCore\HtmlElements;

/**
 * classe pai para elementos html de relação
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
abstract class RelationBlockAbstract extends ElementAbstract
{

    protected $elementsDescriptionCol;
    protected $relatedModelName;
    protected $relatedColumnName;
    protected $currentRow;
    protected $relatedRowUrlTemplate;
    protected $exibitionTemplate;
    /**
     * linhas do banco de dados
     * contendo os objeos relationados
     * @var [type]
     */
    protected $relatedRows = null;

    public function getElementsDescriptionCol()
    {
        if (empty($this->elementsDescriptionCol)) {

            $modelName = $this->getRelatedModelName();

            $model = new $modelName;

            $meta = $model->getMeta();
            $this->setElementsDescriptionCol($meta['humanizedIdentifier']);

            if(empty($this->elementsDescriptionCol)) throw new \Exception("Não foi possível encontrar setado o valor de elements descriptionCol, foi setado no modelo de relação a meta[humanizedIdentifier] ?", 1);
        }

        return $this->elementsDescriptionCol;
    }

    public function setElementsDescriptionCol($elementsDescriptionCol)
    {
        $this->elementsDescriptionCol = $elementsDescriptionCol;

        return $this;
    }

    public function getElementsDescriptionCall()
    {
        $str ="get".$this->getElementsDescriptionCol();
        $str = str_replace("_", "", $str);

        return $str;
    }

    public function getRelatedModelName()
    {
        return $this->relatedModelName;
    }

    public function setRelatedModelName($relatedModelName)
    {
        $this->relatedModelName = $relatedModelName;

        return $this;
    }

    public function countRelatedCols()
    {
        $relatedModelName = $this->getRelatedModelName();

        $model = new $relatedModelName;

        return $model->count();
    }

    /**
     * pega as linhas relacionadas desconsiderando
     * a existência ou não do id
     *
     * @return array array de objetos relacionados
     */
    public function &getRelatedRows()
    {
        if (is_null($this->relatedRows) ) {

            $relatedModelName = $this->getRelatedModelName();
            $model = new $relatedModelName;

            if ($this->getCurrentRow()->getId()->getBruteVal()) {
                $where[$this->getRelatedColumnName()] = $this->getCurrentRow()->getId()->getBruteVal();
            } else {
              $where = array();
            }

            $rows = $model->onlyAvailable()->toObject()->get($where);
            $this->setRelatedRows($rows);
        } //throw new \Exception("Elementos de relacionamentos não setados", 1);

        return $this->relatedRows;
    }

    public function setRelatedRows(&$relatedRows)
    {
        $this->relatedRows = &$relatedRows;

        return $this;
    }

    public function getRelatedColumnName()
    {
        return $this->relatedColumnName;
    }

    public function setRelatedColumnName($relatedColumnName)
    {
        $this->relatedColumnName = $relatedColumnName;

        return $this;
    }

    public function getRelatedColumnCall()
    {
        $relatedCall = "get".$this->getRelatedColumnName();
        $relatedCall = str_replace("_", "", $relatedCall);

        return $relatedCall;
    }

    public function getCurrentRow()
    {
        if(!($this->currentRow) || !($this->currentRow->getId()->getVal()))
            throw new \Exception("Current Row não foi setada", 1);

        return $this->currentRow;
    }

    public function setCurrentRow($currentRow)
    {
        $this->currentRow = $currentRow;

        return $this;
    }

    public function getRelatedRowUrlTemplate()
    {
        return $this->relatedRowUrlTemplate;
    }

    public function setRelatedRowUrlTemplate($relatedRowUrlTemplate)
    {
        $this->relatedRowUrlTemplate = $relatedRowUrlTemplate;

        return $this;
    }

    public function getAddRelatedUrl()
    {
        $url = $this->getRelatedRowUrlTemplate();

        $url = str_replace('editar/{id}/id', 'incluir', $url);

        return $url;
    }

    public function getExibitionTemplate()
    {
        return $this->exibitionTemplate;
    }

    public function setExibitionTemplate($exibitionTemplate)
    {
        $this->exibitionTemplate = $exibitionTemplate;

        return $this;
    }

    public function getRelatedExibitionString($relationElement)
    {

        $call = null;
        if ($this->getExibitionTemplate()) {
            $relationName = $this->exibitionTemplate;
            //###################################################################################
            //################################# tratamento de templates de exibição ###########################################
            //###################################################################################
              $startCollect = false;
              for ($i=0; $i < strlen($this->exibitionTemplate); $i++) {

                if ($startCollect) {
                  $call.= $this->exibitionTemplate{$i};
                }

                if ($this->exibitionTemplate{$i} == '[') {
                  $startCollect = true;

                } elseif ($this->exibitionTemplate{$i} == ']') {
                  $call = substr($call, 0,-1);
                  $startCollect = false;
                  $relationName = str_replace('['.$call.']', $relationElement->$call() , $relationName);
                }

              }

              foreach ($relationElement->vars as $key => $column) {
                $relationName = str_replace('{'.$key.'}', $column->getVal(), $relationName);
              }

            //###################################################################################
            //################################# END tratamento de templates de exibição ########################################
            //###################################################################################

            } else {

             $elementsDescriptionCall = $this->getElementsDescriptionCall();

              $relationName = ($relationElement->$elementsDescriptionCall()->getVal()) ? $relationElement->$elementsDescriptionCall()->getVal() : 'Relação '.$relationElement->getId()->getVal();
            }

        return $relationName;
    }
}
