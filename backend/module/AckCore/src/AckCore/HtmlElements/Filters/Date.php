<?php

namespace AckCore\HtmlElements\Filters;
use AckCore\HtmlElements\Date as ParentDate;
class Date extends ParentDate
{
    public function defaultLayout()
    {
        self::resources();
        ?>
        <script type="text/javascript">

            $(function () {
                $( "#datepicker-<?php echo $this->getName() ?>" ).datepicker(       {
                                                    altFormat: "yy-mm-dd",
                                                    altField: "#actualDate-<?php echo $this->getName() ?>",
                                                    dateFormat: "dd/mm/yy",
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    showOtherMonths: true,
                                                    selectOtherMonths: true,
                                                    regional: 'pt-BR',
                                                });
                });
        </script>

        <div class="filterElement form-group col-xs-6 col-sm-4 col-md-2">
            <label class="sr-only" for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
            <input type="hidden" id="actualDate-<?php echo $this->getName() ?>" <?php echo $this->composeName() ?> value="<?php echo \AckCore\Utils\Date::toMysql($this->getValue(),"/") ?>" />
            <input type="text" id="datepicker-<?php echo $this->getName() ?>"  <?php echo ($this->permission < 2) ? 'DISABLED="DISABLED"' : "" ?> class="form-control input-sm datePicker<?php echo $this->getName();  ?>" value="<?php echo $this->getValue() ?>" placeholder="<?php echo $this->getTitle() ?>" />
        </div>

        <?php
    }

}
