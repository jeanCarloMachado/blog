<?php
/**
 * entidade representando a tabela: Notificacoes
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
namespace AckContact\Model;

use AckDb\ZF1\TableAbstract as Table;
/**
 * entidade representando a tabela: Notificacoes
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Notificacoes extends Table
{
    protected static $type = array(
        'ACCOUNT_EXPIRATION' => array ('id'=>1),
    );

    /**
     * nome da tabela no banco
     * @var string
     */
    protected $_name = 'ackcontact_notificacao';
    /**
     * nome da entidade relacionada representando uma linha
     * @var string
     */
    protected $_row = '\AckContact\Model\Notificacao';

    public function getFromUser($user)
    {
        return $this->toObject()->onlyAvailable()->get(array('usuario_id'=>$user->getId()->getBruteVal()));
    }

    public function getTypeData($name)
    {
        return self::$type[$name];
    }
}
