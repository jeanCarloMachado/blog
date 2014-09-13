<?php
/**
 * elemento html para datas
 *
 * AckDefault - Cub
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\HtmlElements;
use \AckCore\Utils\Date as DateUtilities;
/**
 * elemento html para datas
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Date extends ElementAbstract
{
    protected static $resourcesIncluded = false;

    /**
     * retorna assets que devem ser inclusos somente uma
     * vez
     *
     * @return void null
     */
    public static function resources()
    {
        if(!self::$resourcesIncluded) :
        ?>
<link rel="stylesheet" href="/ack-core/plugins/ui/1.10.3/themes/jquery-ui.css" />
<script src="/ack-core/plugins/ui/1.10.3/jquery-ui.js"></script>
        <?php
            self::$resourcesIncluded = true;
        endif;
    }

    /**
     * layout padrão a ser renderizado
     *
     * @return void null
     */
    public function defaultLayout()
    {
        $this->resources();
        ?>
        <script type="text/javascript">
            $(function () {
                $( "#datepicker-<?php echo $this->getName() ?>" ).datepicker(		{
                                                    altFormat: "yy-mm-dd 00:00:00",
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
                <label for="<?php echo $this->getName() ?>">
                    <?php echo $this->getTitle() ?>
                    <?php $this->renderLangDescription() ?>
                    <?php $this->renderDefaultAjuda() ?>
                </label>
                <input type="hidden" id="actualDate-<?php echo $this->getName() ?>" <?php echo $this->composeName() ?> value="<?php echo DateUtilities::toMysql($this->getValue(), "/") ?>"/>

                <input type="text" id="datepicker-<?php echo $this->getName() ?>" <?php echo ($this->permission < 2) ? 'DISABLED="DISABLED"' : "" ?> value="<?php echo $this->getValue() ?>" class="form-control input-sm" />

        <?php
    }
}
