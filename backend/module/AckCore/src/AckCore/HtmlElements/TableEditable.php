<?php
/**
 * tabela de valores editavies
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
class TableEditable extends ElementAbstract
{
  protected $tableInstance;
  protected $elements;
  protected $urlControllerName = "tags";
  protected $modelRelated;
  /**
   * coluna de elementos que irão se apresentar como colunas
   * @var array
   */
  protected $elementCols = array("chave","valor");
  protected $require = array("elements","tableInstance","modelRelated");

  public function init()
  {
      if(empty($this->permission))
        $this->permission = "rw";
  }

  public function defaultLayout()
  {
    $elements =& $this->elements;
    $elementCols =& $this->elementCols;
    $name = $this->modelRelated;
    $urlControllerName = &$this->urlControllerName;
      ?>
        <span class="clearBoth"></span>

        <div class="modulo <?php echo $name; ?>">
          <?php \AckCore\HtmlElements\Explain::getInstance()->setName($name."Description")->render();?>

          <div class="slide editorTags">
            <!--
            -->
            <!-- ___NOVO___NOVO -->
            <div class="contAba form parent_tableEntrys">
              <?php
                foreach($elements as $element) :
                  if(!is_object($element))
                    continue;
              ?>
                  <fieldset class="parentTag rowContainer" id="<?php echo $element->getId()->getBruteVal() ?>" data-url="/ack/<?php echo $urlControllerName; ?>/editar/<?php echo $element->getId()->getBruteVal() ?>">
                    <?php foreach($elementCols as $col) :
                        $callCol = "get".str_replace("_", "", $col);
                    ?>
                       <input type="text" value="<?php echo $element->$callCol()->getVal() ?>" name="<?php echo $col; ?>" />
                    <?php endforeach; ?>

                      <button title="Atualizar linha" class="botao edit_tableEntry"><span><em>Atualizar linha</em></span><var class="borda"></var></button>
                      <button title="Remover linha" class="botao remove_tableEntry"><span><em>Remover linha</em></span><var class="borda"></var></button>
                  </fieldset>
              <?php
               endforeach;
               ?>
              <!-- Nao remover o ultimo -->
              <fieldset class="parent_add_tableEntry">
                <?php \AckCore\HtmlElements\Input::getInstance()->setname("chave")->setPermission($this->permission)->render(); ?>
                <?php \AckCore\HtmlElements\Input::getInstance()->setname("valor")->setPermission($this->permission)->render(); ?>
                <input type="hidden" name="relacao_id" value="<?php echo $this->getTableInstance()->getId()->getBruteVal(); ?>"/>

                <?php    \AckCore\HtmlElements\Button::getInstance()
                                                ->setName("adicionarTags")
                                                ->appendClass("add_tableEntry")
                                                ->setTitle("Adicionar linha")
                                                ->setPermission("+rw")
                                                ->render(); ?>
              </fieldset>
            </div>
            <!-- ___NOVO___NOVO -->
          </div>
        </div><!-- END modulo -->
      <?php
  }
  //###################################################################################
  //################################# getters and setters###########################################
  //###################################################################################
  public function getElements()
  {
    return $this->elements;
  }

  public function setElements($elements)
  {
    $this->elements = $elements;

    return $this;
  }
  public function getElementCols()
  {
    return $this->elementCols;
  }

  public function setElementCols($elementCols)
  {
    $this->elementCols = $elementCols;

    return $this;
  }

  public function getUrlControllerName()
  {
    return $this->urlControllerName;
  }

  public function setUrlControllerName($urlControllerName)
  {
    $this->urlControllerName = $urlControllerName;

    return $this;
  }

  public function getTableInstance()
  {
    return $this->tableInstance;
  }

  public function setTableInstance($tableInstance)
  {
    $this->tableInstance = $tableInstance;

    return $this;
  }

  public function getModelRelated()
  {
    return $this->modelRelated;
  }

  public function setModelRelated($modelRelated)
  {
    $this->modelRelated = $modelRelated;

    return $this;
  }
    //###################################################################################
    //################################# END getters and setters########################################
    //###################################################################################
}
