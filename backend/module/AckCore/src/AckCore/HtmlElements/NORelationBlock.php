<?php
/**
 * relacionamento 1:N
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
 * objeto de relacionamento 1:N
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class NORelationBlock extends RelationBlockAbstract
{
    protected $require = array();

    /**
     * layout default a ser renderizado
     *
     * @return void mostra diretamente o html na função rendr
     */
    public function defaultLayout()
    {
    ?>
        <div class="panel panel-default <?php echo $this->getName(); ?> ONRelationBlock">
        <div class="panel-body">
        <?php
             $checks= array();
             if($this->getRelatedRows())

             foreach ($this->getRelatedRows() as $relationElement) {

                $elementUrl = str_replace('{id}',$relationElement->getId()->getVal(),$this->getRelatedRowUrlTemplate());
                $elementUrl = str_replace('/id', '/nolayout', $elementUrl);

                $checks[] = Check::getInstance(true)
                            ->setPermission('+rw')
                            ->setChecked(true)
                            ->setTitle($this->getRelatedExibitionString($relationElement))
                            ->setValue($relationElement->getId()->getBruteVal())
                            ->setPermission($this->permission)
                            ->setUrl($elementUrl)
                            ->setName($this->getName());
             }

              $blockActions = CheckBlock::getInstance()
              ->setChecks($checks)
              ->setTitle($this->getTitle())
              ->setName($this->getName())
              ->setPermission("+rw")
              ->render();

        $addUrl = $this->getAddRelatedUrl().'/nolayout';
        $addUrl.=  '-'.$this->getCurrentRow()->getTableModelName().'='.$this->getCurrentRow()->getId()->getBruteVal();

        Link::getInstance()->setPermission('+rw')->appendClass('modalTrigger btn-default')->setTitle('Adicionar')->setValue('Adicionar')->setUrl($addUrl)->render();
        ?>

        </div>
        </div>
    <?php
    }

    /**
     * pega as linhas relacionadas somente se tiver algum id selecionado
     *
     * @return array array de objetos relacionados
     */
    public function &getRelatedRows()
    {
        if (is_null($this->relatedRows) && $this->getCurrentRow()->getId()->getBruteVal()) {
            $modelName = $this->getRelatedModelName();
            $model = new $modelName;
            $where[$this->getRelatedColumnName()] = $this->getCurrentRow()->getId()->getBruteVal();

            $row = $model->onlyAvailable()->toObject()->get($where);
            $this->setRelatedRows($row);
        }

        return $this->relatedRows;
    }
}
