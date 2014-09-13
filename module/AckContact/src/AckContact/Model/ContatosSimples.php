<?php
/**
 * entidade representando a tabela: ContatosSimples
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
use AckCore\Utils\Date as DateUtilities;
/**
 * entidade representando a tabela: ContatosSimples
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class ContatosSimples extends Table
{
    /**
     * nome da tabela no banco
     * @var string
     */
	protected $_name = 'ackcontact_contato_simples';
    /**
     * nome da entidade relacionada representando uma linha
     * @var string
     */
	protected $_row = '\AckContact\Model\ContatoSimples';

    protected $meta = array(
        "humanizedIdentifier" => "email",
    );
    protected $colsNicks = array(
        "conteudo" => "Conteúdo"
    );

    public function create(array $set, array $params=null)
    {
        $set['data'] = DateUtilities::now();
        
        //testa se o último contato não acabou de mandar uma mensagem
        $lastContact = $this->get(array(),array('limit'=>array('count'=>1), 'order' => 'id DESC'));
        $lastContact = reset($lastContact);    

        if ($lastContact['email']  == $set['email'] ) {
            
            $lastMessage = strtotime($lastContact['data']);

            if (($lastMessage + 10 * 60)  > strtotime(DateUtilities::now())) {
                throw new \Exception('Você acabou de enviar um contato espere 10 minutos para enviar outro.');
            }
        }
        

        

        return parent::create($set, $params);
    }

}
