<?php
namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\ElementAbstract;
class BooleanCheck extends ElementAbstract
{
    protected $options = array();
    protected $selected = null;

    public function defaultLayout()
    {
    ?>

        <div class="filterElement">
            <fieldset class="field checkboxGruop">
                 <label class="placeholder">
                        <input type="checkbox" autocomplete="off" radio="visivel" class="placeholder-check" <?php $this->composeSelection(1) ?> name="<?php echo $this->getName() ?>_true" value="1" />
                        <p class="field-text">Sim</p>
                        <label class="placeholder">
                        <input type="checkbox" autocomplete="off" radio="visivel" class="placeholder-check" <?php $this->composeSelection(0) ?> name="<?php echo $this->getName() ?>_false" value="0" />
                        <p class="field-text">Não</p>
                    </label>
            </fieldset>
        </div>
    <?php
    }

    public function getOption($key)
    {
        return $this->options[$key];
    }

    public function setOption($value,$key,$selected=false)
    {
        if(!empty($key))
            $this->options[$key] = $value;
        else
            throw new \Exception("Não foi setado o campo key");

        if($selected)
            $this->selected = $key;

        return $this;
    }

     public function composeSelection($value=null)
    {
        if ($value == $this->getDefaultValue()) {
            echo "checked='checked'";
        }
    }
}
