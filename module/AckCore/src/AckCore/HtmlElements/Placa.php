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

use AckCore\HtmlElements\Traits\MaskedElements;

class Placa extends ElementAbstract
{
    use MaskedElements;

    public function defaultLayout()
    {
        self::resources();
        ?>

        <div class="<?php echo $this->parentClasses; ?>">
                <label for="<?php echo $this->getName() ?>"><?php echo $this->getTitle() ?>:</label>
                <input id="placa-<?php echo $this->getName() ?>" type="<?php echo $this->type; ?>" autocomplete="off" <?php echo $this->composeName() ?> class="<?php echo $this->appendClass('form-control')->appendClass('input-sm')->composeClasses(); ?>" value="<?php echo $this->getValue() ?>"   />
        </div>

         <script>
            $(window).load(function () {
                $('#placa-<?php echo $this->getName() ?>').mask("aaa/9999");

            });

        </script>

        <?php
    }

}
