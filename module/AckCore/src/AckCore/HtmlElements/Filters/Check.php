<?php
<<<<<<< HEAD
namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\ElementAbstract;
=======
namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\ElementAbstract;
>>>>>>> SiteJean-master
class Check extends ElementAbstract
{
    protected $options = array();
    protected $selected = null;

    public function defaultLayout()
    {
    ?>
<<<<<<< HEAD
    <div class="filter-results-item visivel">
                            <p class="filter-results-title"><strong><?php echo $this->getTitle() ?></strong></p>

                            <span class="box-list-spacer"></span>
=======
    <div class="filterElement">
>>>>>>> SiteJean-master

                            <fieldset class="field checkboxGruop">
                                 <?php foreach($this->options as $key => $value) : ?>

                                 <label class="placeholder">
                                        <input type="checkbox" autocomplete="off" radio="visivel" class="placeholder-check" <?php echo $this->composeName() ?> value="<?php echo $key ?>" />
                                        <p class="field-text">Visível</p>
                                    </label>
            <?php endforeach; ?>
                            </fieldset>
                        </div>
    <?php
    }

    public function metisLayout()
    {
        ?>

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
}
