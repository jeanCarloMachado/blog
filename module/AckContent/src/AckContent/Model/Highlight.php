<?php
/**
 * representa um destaque do sistema
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
namespace AckContent\Model;
use AckDb\ZF1\RowAbstract;
class Highlight extends RowAbstract
{
    protected $_table = "\AckContent\Model\Highlights";
    private $imageCache = null;

    public function getFirstPhoto($moduleId=null)
    {
        $moduleId = !empty($moduleId) ? $moduleId : Highlights::moduleId;

        if(!empty($this->imageCache))

            return $this->imageCache;

        $model = new Photos;
        $this->imageCache = $model->toObject()->onlyAvailable()->get(array("modulo"=>$moduleId,"relacao_id"=>$this->getId()->getBruteVal()));

        $this->imageCache  = reset($this->imageCache);

        if(!$this->imageCache)

            return new Photo();

        return $this->imageCache;
    }

    public function getRandomPhoto($moduleId = null)
    {
        $moduleId = !empty($moduleId)? $moduleId : Highlights::moduleId;

        $model = new Photos;
        $this->imageCache = $model->toObject()->onlyAvailable()->get(array("modulo"=>$moduleId,"relacao_id"=>$this->getId()->getBruteVal()));

        if(!$this->imageCache)

            return new Photo();

        $max = count($this->imageCache) - 1;
        $index = rand(0,$max);

        $this->imageCache = $this->imageCache[$index];

        return $this->imageCache;
    }
}
