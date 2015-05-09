<?php
/**
* modelo padrão para tabelas NN
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
namespace AckDb\Model;
use AckDb\ZF1\TableAbstract as Table;
abstract class TableNNAbstract extends Table
{
    /**
     * mapeamento das colunas de relacionamento para
     * o seu respectivo modelo
     * @var array
     */
    protected static $map = array(
        "\AckCore\Model\Examples" => "coluna_relacao"

    );

    /**
     * retona o nome da coluna relacionaa com o modelo passado
     * @param  string $str [description]
     * @return [type] [description]
     */
    public static function getRelatedColumnName($modelName)
    {
        $calledClass = get_called_class();
        if(empty($calledClass::$map[$modelName]))
            throw new \Exception("Não foi possível encontrar relação entre alguma coluna e o modelo passado: $modelName", 1);

        return $calledClass::$map[$modelName];
    }
}
