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
namespace AckCore\HtmlElements\Traits;
trait MceEditor
{
    protected static $resourcesIncluded = false;

    public function resources()
    {
        $this->getHeadScript()->offsetSetFile(7,"/plugins/tinymce/js/tinymce/tinymce.min.js");
        
        if(!self::$resourcesIncluded) :
        ?>
            <script>
            tinymce.init({
                selector: ".textEditor",
                     plugins: [
                     "advlist autolink lists link image charmap print preview anchor",
                     "searchreplace visualblocks code fullscreen",
                     "insertdatetime media table contextmenu paste jbimages"
                     ],
                     toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
                     relative_urls: false
                     }); 


            </script>
        <?php
            self::$resourcesIncluded = true;
        endif;
    }
}