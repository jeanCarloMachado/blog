<?php
/**
 * funcionalidades de relacionamento com modelos
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
namespace AckMvc\Model;
trait RelatedModel
{
    protected $models = array();

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;

        return $this;
    }

    public function getModel($modelKey = 'default')
    {
        return $this->models[$modelKey];
    }

    public function getModelInstance($modelKey = 'default')
    {
        $modelName = $this->getModel($modelKey);
        if(empty($modelName)) throw new \Exception('Não foi possível encontrar o modelo '.$modelKey.' relacionado ao controlador em questão');

        $modelInstance = new $modelName;

        return $modelInstance;
    }


    public function getModelName($modelKey = 'default')
    {
        $modelName = $this->getModel($modelKey);
        if(empty($modelName)) throw new \Exception('Não foi possível encontrar o modelo '.$modelKey.' relacionado ao controlador em questão');


        return $modelName;
    }

    public function &getViewModel()
    {
        return $this->viewModel;
    }

    public function setViewModel($viewModel)
    {
        $this->viewModel = $viewModel;

        return $this;
    }
}
