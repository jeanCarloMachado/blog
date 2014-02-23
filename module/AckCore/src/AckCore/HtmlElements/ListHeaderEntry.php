<?php
namespace AckCore\HtmlElements;
class ListHeaderEntry extends ElementAbstract
{
    protected $widht = null;
    protected $orderSelector = false;

    public static function Factory(\AckCore\Vars\Variable $variable = null,$title=null,$permission=null,$defaultValue="",$helperId=null)
    {
        $className = get_called_class();

        $instance = new $className();

        $instance->setName($variable->getColumnName());
        $instance->setValue($variable->getVal());

        if(!empty($title)) $instance->setTitle($title);
        else $instance->setTitle($variable->getAlias());

        if(!empty($permission)) $instance->setPermission($permission);
        else $instance->setPermission(2);

        if(!empty($defaultValue)) $instance->setValueDefault($defaultValue);

        if(!empty($helperId)) $this->setHelperId($helperId);

        //pesquisa o status do módulo
        //caso este esteja em construção,
        //mostra então o identificador dos elementos e
        //não o seu título real
        $modelName = $variable->table;

        return $instance;
    }

    public function defaultLayout()
    {
    ?>

        <th name="<?php echo str_replace('_','', $this->getName()); ?>" style="width:<?php echo $this->getWidth(); ?>"><?php echo $this->getTitle() ?></th>
    <?php
    }

    public function getWidth()
    {
        return $this->width;
    }
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
    public function enableOrderSelector()
    {
        $this->orderSelector = true;
    }
    public function renderOrderSelector()
    {
        if($this->orderSelector)
            echo "ord";
    }
}
