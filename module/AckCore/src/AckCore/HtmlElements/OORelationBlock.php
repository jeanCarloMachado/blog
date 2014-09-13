<?php
/**
 * bloco de relação 1:1
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
use AckCore\Utils\String;

/**
 *
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class OORelationBlock extends RelationBlockAbstract
{

    public function defaultLayout()
    {
        $relatedModelInstance = String::getInstanceFromName($this->getRelatedModelName());

        $relatedCall = $this->getRelatedColumnCall();
         //testa se já está setada a coluna da linha com relação externa
        if($this->getCurrentRow()->$relatedCall()->getBruteVal()) $where = (array("id"=>$this->getCurrentRow()->$relatedCall()->getBruteVal()));

        //pega a linha relacionada (caso ela existir)
        $selectedRow = $relatedModelInstance->toObject()->getOne($where);
        $totalElements = $this->countRelatedCols();

        if($totalElements < 50) $this->renderSelect($selectedRow);
        else $this->renderAutocomplete($selectedRow);

        $this->renderBelow($selectedRow);
    }

    public function renderAutocomplete(&$selectedRow = null)
    {
        $relatedCallDescription = $this->getElementsDescriptionCall();
    ?>
    <div class="panel panel-default">
    <div class="panel-body">
    <?php
        $element = Autocomplete::getInstance()
        ->setName($this->getRelatedColumnName())
        ->setTitle($this->title)
        ->setPermission($this->permission)
        ->setBaseUrl($this->getRelatedRowUrlTemplate())
        ->setSearchColumn($this->getElementsDescriptionCol())
        ->setValue($selectedRow->$relatedCallDescription()->getVal());

        $element->render();

    }

    /**
     * renderiza um select se a quantidae de elementos relacionados permitir
     * @param  [type] $selectedRow [description]
     * @return [type] [description]
     */
    public function renderSelect(&$selectedRow = null)
    {
        $relatedCallDescription = $this->getElementsDescriptionCall();
    ?>
        <div class="panel panel-default <?php echo $this->getRelatedColumnName() ?>">
        <div class="panel-body">
        <?php
        $htmlElement = Select::getInstance()
                        ->setName($this->getRelatedColumnName())
                        ->setTitle($this->title)
                        ->setPermission($this->permission)
                        ->setValue(null)
                        ->setOption(0,'Selecione...');

        if(($this->getRelatedRows()))
        foreach ($this->getRelatedRows() as $relationElement) {
            $selected = ($selectedRow->getId()->getBruteVal() == $relationElement->getId()->getBruteVal()) ? true : false;
            $htmlElement->setOption($relationElement->getId()->getBruteVal(),$this->getRelatedExibitionString($relationElement),$selected);
        }

        $htmlElement->render();
    }

    /**
     * renderiza a parte de baixo em comum com todos os containers
     *
     * @param $selectedRow linha atualmente selecionada
     *
     *  @return void mostra apenas o html
     */
    public function renderBelow(&$selectedRow = null)
    {

        $templateWithoutId = str_replace('/id', '/nolayout', $this->getRelatedRowUrlTemplate());
        $elementUrl = str_replace('{id}', $selectedRow->getId()->getVal(), $templateWithoutId);

        Link::getInstance()->appendClass('modalTrigger')->appendClass('view'.$this->getRelatedColumnName().' btn-default')->setPermission('+rw')->setTitle('Ver')->setValue('Ver')->setUrl($elementUrl)->render();

        $addUrl = str_replace('editar/'.$selectedRow->getId()->getVal(), 'incluir',$elementUrl);

        Link::getInstance()->appendClass('modalTrigger')->appendClass('add'.$this->getRelatedColumnName().' btn-default')->setPermission('+rw')->setTitle('Adicionar')->setValue('Adicionar')->setUrl($addUrl)->setAditionalHtml(' data-related-field-name="'.$this->getRelatedColumnName().'"')->render();
        ?>
            <script>
                $('document').ready(function () {
                    select = $('select[name="<?php echo $this->getRelatedColumnName() ?>"]');
                    if($(select).val() == 0) $('.view<?php echo $this->getRelatedColumnName() ?>').hide();

                    $(select).on('change',function () {
                        if($(this).val() == 0) $('.view<?php echo $this->getRelatedColumnName() ?>').hide();
                        else {
                                $('.view<?php echo $this->getRelatedColumnName() ?>').show();
                                baseUrl =  '<?php echo $templateWithoutId; ?>';
                                $('.view<?php echo $this->getRelatedColumnName() ?>').attr('href',baseUrl.replace('{id}',$(this).val()));
                        }
                    });
                });
            </script>
        </div>
        </div>
        <?php
    }

}
