<?php
/**
 * elemento html do tipo capcha (re-captcha para ser específico)
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
class Captcha extends ElementAbstract
{
    
    public function loadCaptchaLibrary()
    {
        require_once(__DIR__.'/Captcha/recaptchalib.php');
    }


    public function defaultLayout()
    {
        $this->loadCaptchaLibrary(); 
        
        echo recaptcha_get_html($this->getPublickey()); 
    }
    
    public function getPublicKey()
    {
        return '6Le2qu8SAAAAAPklX1uTj80J9K4AKVwAkoRF39Ji';
    }

}
