<?php
/**
 * interface das variávies do sitema
 *
 * descrição detalhada
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

namespace AckCore\Vars;
interface TypeInterface
{
    /**
     * converte uma variável do seu tipo bruto para as chamadas getVal()
     * @param  [type] $data [description]
     * @return [type] [description]
     */
    public function convert($data);
    /**
     * testa a validade do valor de uma variável
     * @param  [type]  $data [description]
     * @return boolean [description]
     */
    public function isValid($data);
    /**
     * retorna o apelido da variável
     * @return [type] [description]
     */
    public function getAlias();
    /**
     * seta o apelido da variável
     * @param [type] $alias [description]
     */
    public function setAlias($alias);
}
