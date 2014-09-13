<?php
/**
 * elemento html do tipo input
 *
 * PHP version 5
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
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\HtmlElements;
class Autocomplete extends ElementAbstract
{
    protected $type = 'input';
    protected $parentClasses = '';
    protected $id;
    protected $baseUrl;
    protected $searchColumn;
    protected $relatedModelName;
    public function defaultLayout()
    {
        ?>
        <div class="<?php echo $this->parentClasses; ?>">
                <label for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>

                <input list="list_<?php echo $this->getName() ?>" id="<?php echo $this->getName() ?>" type="text" autocomplete="off" class="<?php echo $this->appendClass('form-control')->appendClass('input-sm')->composeClasses(); ?>" value="<?php echo $this->getValue() ?>"   />

                <input id="selected_id_<?php echo $this->getName() ?>" type="hidden" name="<?php echo $this->getName(); ?>" value="<?php echo $this->getValue(); ?>" ?>

                    <datalist id="list_<?php echo $this->getName() ?>">
                        <option data-id="0001" value="Example 1">
                        <option data-id="0002" value="Example 2">
                        <option data-id="0003" value="Example 3">
                        <option data-id="0004" value="Example 4">
                    </datalist>
        </div>
        <script>
            $('document').ready(function () {

            infoSection = new Object;
            infoSection.identifier = '<?php echo $this->getName() ?>';
            infoSection.autoCompleteSearchColumn = '<?php echo $this->getSearchColumn() ?>';
            infoSection.autoCompleteUrl = '<?php echo $this->getBaseUrl() ?>';
            infoSection.element = $("#"+infoSection.identifier);
            infoSection.realValueContainer = 'selected_id_<?php echo $this->getName(); ?>';

            function autoCompleteSec(info)
            {
                $(info.element).on('keypress',function () {

                    if($(this).val().length <= 3) return;

                    ajaxObj = serviceLocator.getInstance('AckAjax');
                    ajaxObj.data = new Object();
                    ajaxObj.data.action = 'autoComplete';
                    ajaxObj.data.field = info.autoCompleteSearchColumn;
                    ajaxObj.data.modelName = escape('<?php echo str_replace("\\","-",$this->getRelatedModelName()) ?>');
                    ajaxObj.data.value = $(this).val();
                    ajaxObj.url = info.autoCompleteUrl;
                    ajaxObj.success = function (ajaxData) {

                        if (!ajaxData.status) {
                            return;
                        }

                        if (ajaxData.result) {
                            listElement = $("#list_" + info.identifier);

                            if($(listElement).children()) $(listElement).empty();

                            $.each(ajaxData.result,function (index,value) {

                                val = eval('value.'+info.autoCompleteSearchColumn);
                                id = Number(value.id);

                                $(listElement).append('<option data-id="'+id+'" value="'+val+'">');
                                $("#"+info.realValueContainer).val(id);
                            });

                        }
                    };

                    ajaxObj.send();
                });

            }
            autoCompleteSec(infoSection);
        });
        </script>
        <?php
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($baseUrl)
    {
        if (empty($baseUrl)) {
            $this->baseUrl = '/servicesprovider/routerAjax';
        } elseif (preg_match('/^.*{id}\/id$/', $baseUrl)) {
            $this->baseUrl = str_replace("/editar/{id}/id", '/routerAjax', $baseUrl);
        } else {
            $this->baseUrl = $baseUrl;

        }

        return $this;
    }

    public function getSearchColumn()
    {
        return $this->searchColumn;
    }

    public function setSearchColumn($searchColumn)
    {
        $this->searchColumn = $searchColumn;

        return $this;
    }

    /**
     * getter de RelatedModelName
     *
     * @return RelatedModelName
     */
    public function getRelatedModelName()
    {
        return $this->relatedModelName;
    }

    /**
     * setter de RelatedModelName
     *
     * @param int $relatedModelName
     *
     * @return $this retorna o próprio objeto
     */
    public function setRelatedModelName($relatedModelName)
    {
        $this->relatedModelName = $relatedModelName;

        return $this;
    }
}
