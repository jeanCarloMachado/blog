<?php
/**
 * gerenciador de dados (utilizado no controlador)
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
namespace AckCore\Data;
use \AckCore\Validate\Validator;
class Manager
{
    protected $validator;
    protected $data;
    protected $manageExceptions = true;

    public function __construct(&$data = null)
    {
        $this->setData($data);
    }

    public static function getInstance(&$data)
    {
        return new Manager($data);
    }

//###################################################################################
//################################# funções semãnticas da classe ###########################################
//###################################################################################
    public function rename(array $renameRelation)
    {
        \AckCore\Utils\Arr::renameEntrys($renameRelation,$this->data);

         return $this;
    }

    public function notEmpty(array $cols)
    {
        try {
            $this->getValidator()->assertNotEmpty($cols);
        } catch (\Exception $e) {
            $this->sigKill($e->getMessage());
        }

         return $this;
    }

    public function extract()
    {
        $this->data = \AckCore\Utils\Ajax::extractData($this->data);

        return $this;
    }

    public function sigKill($message = null)
    {
        \AckCore\Utils\Ajax::notifyEnd(0,$message);

         return $this;
    }

    public static function santitize($str)
    {
        return \AckCore\Utils\String::sanitize($str);
    }
//###################################################################################
//################################# END funções semãnticas da classe ########################################
//###################################################################################

//###################################################################################
//################################# getters and setters ###########################################
//###################################################################################
    public function getData()
    {

        if (isset($this->data['data'])) {
            return $this->data['data'];
        }

        return $this->data;
    }

    public function setData(&$data)
    {
        $this->data =&$data;

        return $this;
    }

    protected function getValidator()
    {
        if (empty($this->validator)) {
            $this->validator =  new Validator;

            $data = $this->getData();
            $this->validator->setData($data);
        }

        return $this->validator;
    }

    protected function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }
//###################################################################################
//################################# END getters and setters ########################################
//###################################################################################

}
