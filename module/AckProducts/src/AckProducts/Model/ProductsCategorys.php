<?php
/**
 * categorias de produtos
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
namespace AckProducts\Model;
use AckDb\Model\TableHierarchy;
class ProductsCategorys extends TableHierarchy
{
    protected $_name = "ack_produtos_categorias";
    protected $_row = "\AckProducts\Model\ProductsCategory";
    // const moduleName = "Nome do módulo";
    // const moduleId = 666;

    public static function getTotal()
    {
        $modelCategory = new Categorys();
        $result = $modelCategory->count();

        return $result;
    }
}
