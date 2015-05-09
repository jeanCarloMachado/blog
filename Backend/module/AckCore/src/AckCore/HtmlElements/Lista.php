<?php
namespace AckCore\HtmlElements;
class Lista extends ElementAbstract
{
    protected $entrys = array();

    public function defaultLayout()
    {
    ?>
        <ol class="<?php echo $this->getName() ?>">
            <?php foreach($this->entrys as $key => $entry) : ?>
                <li> <strong><?php echo $key ?>:</strong> <?php echo $entry ?> </li>
            <?php endforeach; ?>
                </ol>
    <?php
    }

    public function metisLayout()
    {
        ?>

        <?php
    }

    public function addEntry($title,$value)
    {
        $this->entrys[$title] = $value;

        return $this;
    }

    public function loadFromRowObject(\AckDb\ZF1\RowAbstract $row,$blacklist  = array())
    {
        foreach ($row->vars as $key => $column) {
            if (!in_array($key, $blacklist)) {
                $colCall = "get$key";
                $this->addEntry($row->$colCall()->getColNick(),$row->$colCall()->getVal());
            }
        }

        return $this;
    }
}
