<?php

namespace AckCore\HtmlElements;

class Year extends ElementAbstract
{
    protected $options = array();
    protected $currentYear = null;

    public function defaultLayout()
    {

        $this->options = array();

        $year = date('Y') + 2;
       for ($i = $year; $i > 1950; $i--) {
            $this->options[$i] = $i;
       }

?>
    <fieldset>
            <div class="legend">
                <h4><?php echo $this->getTitle() ?></h4>
            </div>
            <div class="select">
                <select class="form-control" <?php echo $this->composeName() ?>>
                    <?php foreach($this->options as $key => $value) : ?>
                    <option <?php echo ($this->getCurrentYear() == $key) ?  'selected="SELECTED"' : "" ?> value="<?php echo $value ?>"><?php echo $key ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </fieldset>
<?php
}

    /*
     * Getter for currentYear
     */
    public function getCurrentYear()
    {
        if(empty($this->currentYear)) return $this->getValue();

        return $this->currentYear;
    }

    /*
     * Setter for currentYear
     */
    public function setCurrentYear($currentYear)
    {
        $this->currentYear = $currentYear;

        return $this;
    }

}
