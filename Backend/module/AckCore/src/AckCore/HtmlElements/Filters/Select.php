<?php
<<<<<<< HEAD
namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\ElementAbstract;
=======
namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\ElementAbstract;
>>>>>>> SiteJean-master
class Select extends ElementAbstract
{
    public function defaultLayout()
    {
    ?>
<<<<<<< HEAD
        <div class="filter-results-item statusImagem">
                            <p class="filter-results-title"><strong><?php echo $this->getTitle() ?></strong></p>

                            <span class="box-list-spacer"></span>

=======
        <div class="filterElement">
>>>>>>> SiteJean-master
                            <fieldset class="field">
                                <p class="field-text"><?php echo $this->getTitle() ?>:</p>
                                <label class="placeholder">
                                    <select <?php echo $this->composeName() ?> class="placeholder-select">
                                        <option value="">Todos</option>
                                        <?php foreach($this->options as $key => $value) : ?>
                    <option <?php echo ($this->selected == $key) ?  'selected="SELECTED"' : "" ?> value="<?php echo $value ?>"><?php echo $key ?></option>
            <?php endforeach; ?>
                                    </select>
                                </label>
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
