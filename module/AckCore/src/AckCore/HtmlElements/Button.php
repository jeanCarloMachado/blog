<?php
namespace AckCore\HtmlElements;
class Button extends ElementAbstract
{

    protected $aditionalParams = "";
    protected $id;

    public function defaultLayout()
    {
    ?>
            <button <?php $this->composeId(); ?> class="<?php echo  $this->composeClasses() ?> <?php echo $this->getName() ?>"  <?php echo $this->composeName() ?> title="<?php echo $this->getTitle() ?>" <?php echo $this->composeTags(); ?>><?php echo $this->getTitle() ?>
            </button>
    <?php
    }

    public function setAjaxBlockName($blockName)
    {
            $this->appendClass("devilBlockDispatcher","devilBlockDispatcher");
            $this->appendClass("devilBlockName:".$blockName,"devilBlockName:".$blockName);

            return $this;
    }

    public function setAjaxAction($actionName)
    {
            $this->appendClass("devilAjaxAction","devilAjaxAction");
            $this->appendClass($actionName,$actionName);

            return $this;
    }

    public function composeId()
    {
        if($this->id);
        echo 'id="'.$this->id.'"';

        return;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
