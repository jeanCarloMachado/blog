<?php
/**
 * classe provedora de recursos genéricos do
 * ack (o que não for específico do controlador deve ser convertido para esta classe)
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
namespace AckCore\Controller;

use AckMvc\Controller\Base;
use \AckCore\Data\Manager as DataManager;

class ServicesproviderController extends Base
{
    protected function addtableentryAjax()
    {
        $model = \AckCore\Utils\String::makeInstance($this->getAjax()->getModel());
        $result =  $model->create($this->getAjax()->toArray());
        \AckCore\Utils\Ajax::notifyEnd($result);
    }

    protected function edittableentryAjax()
    {
        \AckCore\Utils\Ajax::notifyEnd($result);
    }

    /**
     * carrega as cidades de um estado
     * @return [type] [description]
     */
    protected function loadcitieslistAjax()
    {
        $stateIdentifier  = $this->ajax["estado"];
        $modelStates = new \AckLocale\Model\States;
        $state = $modelStates->toObject()->onlyAvailable()->getOne(array("id"=>$stateIdentifier));
        $cities = $state->getMyCities();
        $result["status"] = 1;
        $result["cidades"] = \AckCore\Utils\Arr::getColsFromObjects(array('id','nome'),$cities);
        \AckCore\Utils\Ajax::notifyEnd($result);
    }

    /**
     * adiciona uma entrada às solicitações de acesso do sistema
     * @return [type] [description]
     */
    protected function createloginAjax()
    {
        $data =  DataManager::getInstance($this->ajax)
                    ->extract()->rename(array("telefone"=>"fone"))
                    ->notEmpty(array("fone","email","nome"))
                    ->getData();

        $model = new \AckUsers\Model\UserSolicitations();

        try {
            $result = $model->create($data);
        } catch (\Exception $e) {
             \AckCore\Utils\Ajax::notifyEnd(array("status"=>0,"mensagem"=>$e->getMessage()));
        }
        \AckCore\Utils\Ajax::notifyEnd($result,null,"Usuário solicitado com sucesso. Em breve retornaremos.");
    }

    /**
     * implementa autocomplete para uma modelo qualquer
     *
     *
     * @return array json
     */
    protected function autocompleteAjax()
    {
        $data =  DataManager::getInstance($this->ajax)
                    ->extract()
                    ->notEmpty(array('field', 'value', 'modelName'))
                    ->getData();

        $modelName = str_replace('-', '\\', $data['modelName']);

        $field = $data['field'];
        $value = $data['value'];

        if (strlen($value) < 3) {
            $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(false, 'O dado é muito pequeno para ser buscado.');

            return $this->request;
        }

        $model = new $modelName;
        $where = array($field.' LIKE '=> $value.'%');
        $objects = $model->toObject()->get($where);

        if (empty($objects)) {
            $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(false, 'Nenhuma entrada encontrada.');

            return $this->request;
        }

        $result = array();
        $result['status'] = 1;
        $result['result'] = \AckCore\Utils\Arr::getColsFromObjects(array('id',$field),$objects);

        $this->getServiceLocator()->get('AjaxUtils')->notifyStatus($result);

        return $this->request;

        $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(0);

        return $this->request;
    }
}
