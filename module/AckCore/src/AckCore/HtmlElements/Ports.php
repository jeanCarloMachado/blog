<?php
namespace AckCore\HtmlElements;
class Ports extends ElementAbstract
{
    protected $options = array(
        'Duas' => '2',
        'Quatro' => '4',
    );
    protected $selected = null;

    public function defaultLayout()
    {
    ?>
        <fieldset>
                <div class="legend">

                    <h4><?php echo $this->getTitle() ?></h4>
                    <?php $this->renderLangDescription() ?>
                    <?php $this->renderDefaultAjuda() ?>
                </div>
                <div class="select">

                    <select class="form-control" <?php echo $this->composeName() ?>>
                        <?php foreach($this->options as $key => $value) : ?>
                        <option <?php echo ($this->selected == $key) ?  'selected="SELECTED"' : "" ?> value="<?php echo $value ?>"><?php echo $key ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>
    <?php
    }

    public function getOption($key)
    {
        return $this->options[$key];
    }

    public function setOption($value, $key, $selected=false)
    {
        if(!empty($key))
            $this->options[$key] = $value;
        else
            throw new \Exception("Não foi setado o campo key");

        if($selected)
            $this->selected = $key;

        return $this;
    }

    public function getSelected()
    {
        return $this->selected;
    }

    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * converte um valor para sua respectiva chave
     * @param  [type] $value [description]
     * @return [type] [description]
     */
    public function convertValueTokey($userValue)
    {
        foreach ($this->options as $key => $value) {
            if ($value == $userValue) {
                return $key;
            }
        }

        return false;
    }
    /**
     * seta vo valor default à partir do valor que é
     * demonstrado no front
     * @param [type] $value [description]
     */
    public function setSelectedValue($value)
    {
        $this->selected = $this->convertValueTokey($value);

        return $this;
    }
}
