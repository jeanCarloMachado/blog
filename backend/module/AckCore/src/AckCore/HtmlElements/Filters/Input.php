<?php
namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\ElementAbstract;
class Input extends ElementAbstract
{
    public function defaultLayout()
    {
    ?>

       <div class="filterElement form-group col-xs-6 col-sm-4 col-md-2">
                <label class="sr-only" for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
                <input type="text" autocomplete="off" class="form-control input-sm" name="<?php echo $this->getName() ?>" placeholder="<?php echo $this->getTitle() ?>" />
        </div>
    <?php
    }

    public function metisLayout()
    {
        ?>

        <?php
    }
}
