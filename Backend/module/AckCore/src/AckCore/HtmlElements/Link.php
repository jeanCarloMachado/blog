<?php
/**
 * link global
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

/**
 * link global
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Link extends ElementAbstract
{
    protected $_url;
    protected $require = array();
    protected $id;
    protected $targetBlank;
    protected $name;
    /**
     * nesta tag pode-se colocar html adicionar para ser renderizado
     * @var string
     */
    protected $aditionalHtml = "";

    public function defaultLayout()
    {
        ?>
        <a class="<?php echo $this->appendClass('btn')->composeClasses() ?>" <?php echo $this->composeId() ?> <?php echo $this->composeName() ?> <?php $this->composeTargetBlank()?> title="<?php echo $this->getTitle() ?>" href="<?php echo $this->getUrl() ?>"
            <?php echo $this->aditionalHtml; ?>><?php echo $this->getValue(); ?></a>
        <?php
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setUrl($_url)
    {
        $this->name = $_url;
        $this->_url = $_url;

        return $this;
    }

    public function getValue()
    {
        $result = parent::getValue();

        if(empty($result))
            $result =  "Ir";

        return $result;
    }

    public function composeId()
    {
        if($this->getId()) echo 'id="',$this->getId(),'"';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($Id)
    {
        $this->id = $Id;

        return $this;
    }

    public function enableTargetBlank()
    {
        $this->targetBlank = true;

        return $this;
    }

    public function composeTargetBlank()
    {
        if($this->targetBlank) echo 'target="_blank"';
    }

    public function getAditionalHtml()
    {
        return $this->aditionalHtml;
    }

    public function setAditionalHtml($aditionalHtml)
    {
        $this->aditionalHtml = $aditionalHtml;

        return $this;
    }
}
