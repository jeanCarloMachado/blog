<?php
/**
 * bloco de relacionamento nn de uma sessão do ack
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

class NNRelationBlock extends RelationBlockAbstract
{
    /**
     * nome do bloco do módulo, este é enviado como chave no salvar
     * @var [type]
     */
    protected $name;

    /**
     * modelo relacionado com o modelo onde está sendo chamado (com o namespace)
     * @var [type]
     */
    protected $relatedModel;

    /**
     * modelo de relação N=>N
     * @var [type]
     */
    protected $relationalModel;

    /**
     * elementos para reserem relacionados
     * @var [type]
     */
    protected $elements;

    /**
     * este parâmetro é a row do controler
     * (a instancia do modelo relacionado com o controlador em questao)
     * @var [type]
     */
    protected $tableInstance;

    /**
     * campos requeridos para que o elemento renderize efetivamente
     * @var array
     */
    protected $require = array("name","relationalModel","tableInstance");

    /**
     * o nome do conrrolador da url que o link dos elementos direcionará
     * @var [type]
     */
    protected $urlController;

    /**
     * guarda a função para montar o conteúdo de uma entrada  caso esta seja passada
     * @var [type]
     */
    protected $contentEntryFunction = null;

    public function init()
    {
        $this->setPermission("+rw");
    }

    public function defaultLayout()
    {
        $elements =& $this->elements;
        $tableInstance =& $this->tableInstance;

        if(!empty($elements)) :
            $model = $this->getRowModel();
            $relationalModel = $this->getRelationalModel();
            $relatedModel  =  $this->getRelatedModel();

            $descriptionCall = $this->getElementsDescriptionCall();

        ?>
<div class="modulo <?php echo $this->getName(); ?>">
<?php \AckCore\HtmlElements\Explain::getInstance()->setName($this->getName()."Description")->render();?>

        <?php
             $checks= array();
             $baseUrl = "/ack/".$this->getUrlController()."/editar/";
             foreach ($elements as $relationElement) {

                if (!empty($this->contentEntryFunction)) {
                    $func = $this->contentEntryFunction;
                    $content = $func($relationElement);
                } else {
                    $content = $relationElement->$descriptionCall()->getBruteVal();
                }
                $checks[] = \AckCore\HtmlElements\Check::getInstance(true)
                                                    ->setChecked($relationElement->isChildOf($tableInstance,$this->getRelationalModel(), $relationalModel::getRelatedColumnName($model), $relationalModel::getRelatedColumnName($relatedModel)))
                                                    ->setTitle($content)
                                                    ->setValue($relationElement->getId()->getBruteVal())
                                                    ->setPermission($this->permission)
                                                    ->setUrl($baseUrl.$relationElement->getId()->getVal())
                                                    ->setName($this->getName());
             }
              $blockActions = CheckBlock::getInstance()
              ->setChecks($checks)
              ->setTitle($this->getTitle())
              ->setName($this->getName())
              ->setPermission("+rw")
              ->render();
        ?>

</div>
<span class="clearBoth"></span>

    <?php
        endif;
    }

    public function metisLayout()
    {
        ?>

        <?php
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    public function getRelatedModel()
    {
        if(empty($this->relatedModel)) return $this->getRowModel();

        return $this->relatedModel;
    }

    public function setRelatedModel($relatedModel)
    {
        $this->relatedModel = $relatedModel;

        return $this;
    }

    public function getRelationalModel()
    {
        return $this->relationalModel;
    }

    public function setRelationalModel($relationalModel)
    {
        $this->relationalModel = $relationalModel;

        return $this;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function setElements($elements)
    {
        $this->elements = $elements;

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

    public function getUrlController()
    {
        return $this->urlController;
    }

    public function setUrlController($urlController)
    {
        $this->urlController = $urlController;

        return $this;
    }
   public function getContentEntryFunction()
   {
       return $this->contentEntryFunction;
   }

   public function setContentEntryFunction($contentEntryFunction)
   {
       $this->contentEntryFunction = $contentEntryFunction;

       return $this;
   }

    /**
     * retorna  a classe à qual pertence a linha
     * @return [type] [description]
     */
   public function getRowModel()
   {
       $result = get_class($this->getTableInstance());
       $result = "\\".$result;
       $rowInstance = new $result;

       return $rowInstance->getTableModelName();

   }

}
