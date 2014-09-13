<?php
/**
 * elemento html do tipo input
 *
 * PHP version 5
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\HtmlElements;

use AckCore\Utils\Money as MoneyUtilities;

class Float extends ElementAbstract
{
     protected static $resourcesIncluded = false;

    public static function resources()
    {
        if(!self::$resourcesIncluded) :
        ?>
          <script type="text/javascript" src="/plugins/devil/jquery.maskMoney.js"></script>
        <?php
            self::$resourcesIncluded = true;
        endif;
    }

    public function defaultLayout()
    {
        $this->resources();

        ?>
        <div class="<?php echo $this->parentClasses; ?>">
                <label for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
                <input id="float-<?php echo $this->getName() ?>" <?php echo $this->composeId(); ?> type="<?php echo $this->type; ?>" autocomplete="off"  class="<?php echo $this->appendClass('form-control float')->appendClass('input-sm')->composeClasses(); ?>" value="<?php echo MoneyUtilities::appendThousantToBrFormat($this->getValue()); ?>"  data-thousands="." data-decimal=","  />

                <input type="hidden" id='float-hidden-<?php echo $this->getName() ?>' <?php echo $this->composeName() ?> value="<?php echo MoneyUtilities::internationalFormat($this->getValue()); ?>" />
        </div>

        <script>
            window.onload = function () {

                $('.float').maskMoney();

                $('#float-<?php echo $this->getName() ?>').change(function () {
                    value = $(this).val();
                    value = value.replace('.','');
                    value = value.replace(',','.');
                    $('#float-hidden-<?php echo $this->getName() ?>').val(value);
                });

            }
        </script>

        <?php
    }

}
