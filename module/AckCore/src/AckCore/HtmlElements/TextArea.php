<?php
namespace AckCore\HtmlElements;
class TextArea extends ElementAbstract
{
    public function defaultLayout()
    {
    ?>

    <div class="">
                <label  for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
                <textarea cols="50" rows="5" autocomplete="off" class="form-control input-sm" <?php echo $this->composeName() ?> <?php echo $this->composeClasses(); ?> ><?php echo $this->getValue() ?></textarea>
    </div>
    <?php
    }
}
