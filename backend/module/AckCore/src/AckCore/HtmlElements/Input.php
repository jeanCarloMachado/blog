<?php

namespace AckCore\HtmlElements;

class Input extends ElementAbstract
{
    public function defaultLayout()
    {
        ?>
        <div class="<?php echo $this->parentClasses;
        ?>">
                <label for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
                <input <?php echo $this->composeId();
        ?> type="<?php echo $this->type;
        ?>" autocomplete="off" <?php echo $this->composeName() ?> class="<?php echo $this->appendClass('form-control')->appendClass('input-sm')->composeClasses();
        ?>" value="<?php echo $this->getValue() ?>"   />
        </div>
        <?php

    }
}
