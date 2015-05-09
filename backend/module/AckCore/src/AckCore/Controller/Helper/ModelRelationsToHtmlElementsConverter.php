<?php
/**
 * esta classe temo objetivo de à partir de uma linha
 * de tabela em objeto gerar os elementos html adequados
 * para representar os relacionamentos deste elemento
 * com outras entidades.
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckCore\Controller\Helper;
class ModelRelationsToHtmlElementsConverter
{
    protected $model;
    protected $htmlManager;
    protected $controller;

    public function __construct($htmlManager)
    {
        $this->htmlManager = $htmlManager;
    }

    /**
     * converte o esquema do modelo
     * nos elementos html apropriados
     * @return [type] [description]
     */
    public function convert()
    {
        $model = $this->getModel();
        $controller = $this->getController();

        $relations = $model->getRelations();

        if (empty($relations)) {
            return false;
        }

        //copia o view model do usuário
        $currentConfig = $controller->getViewModel()->config;
        $htmlManager = &$this->getHtmlManager();

        if (!empty($relations['n:1'])) {
            foreach ($relations['n:1'] as $relation) {
                $elementTitle = ($relation['elementTitle']) ? $relation['elementTitle'] : "Título do elemento";

                $currentConfig['toRenderCOL2'][] = $htmlManager->getInstanceOf('NORelationBlock')
                                                                            ->setRelatedModelName($relation['model'])
                                                                            ->setRelatedColumnName($relation['reference'])
                                                                            ->setCurrentRow($currentConfig["row"])
                                                                            ->setRelatedRowUrlTemplate($relation['relatedRowUrlTemplate'])
                                                                            ->setTitle($elementTitle)
                                                                            ->setName($relation['model'])
                                                                            ->setPermission("+rw");
            }
        }

        if (!empty($relations['1:1'])) {
            foreach ($relations['1:1'] as $relation) {
                $elementTitle = ($relation['elementTitle']) ? $relation['elementTitle'] : "Título do elemento";

                $htmlElement = $htmlManager->getInstanceOf('OORelationBlock')
                    ->setRelatedModelName($relation['model'])
                    ->setRelatedColumnName($relation['reference'])
                    ->setCurrentRow($currentConfig["row"])
                    ->setRelatedRowUrlTemplate($relation['relatedRowUrlTemplate'])
                    ->setTitle($elementTitle)
                    ->setName($relation['model'])
                    ->setPermission("+rw");

                if (isset($relation['exibitionTemplate'])) {
                    $htmlElement->setExibitionTemplate($relation['exibitionTemplate']);
                }

                $currentConfig['toRenderCOL2'][] = $htmlElement;

            }
        }

        if (!empty($relations['1:n'])) {

            foreach ($relations['1:n'] as $relation) {

                $elementTitle = (isset($relation['elementTitle'])) ? $relation['elementTitle'] : "Título do elemento";
                $urlTemplate = (isset($relation['relatedRowUrlTemplate'])) ? $relation['relatedRowUrlTemplate'] : '';

                $htmlElement = $htmlManager->getInstanceOf('ONRelationBlock')
                ->setRelatedModelName($relation['model'])
                ->setRelatedColumnName($relation['reference'])
                ->setCurrentRow($currentConfig["row"])
                ->setRelatedRowUrlTemplate($urlTemplate)
                ->setTitle($elementTitle)
                ->setName($relation['model'])
                ->setPermission("+rw");

                if (isset($relation['exibitionTemplate'])) {
                    $htmlElement->setExibitionTemplate($relation['exibitionTemplate']);
                }

                $currentConfig["toRenderCOL2"][] = $htmlElement;
            }
        }

        $controller->getViewModel()->config = $currentConfig;
    }

    public function &getModel()
    {
        if(empty($this->model)) throw new \Exception("Modelo não setado", 1);

        return $this->model;
    }

    public function setModel(\AckDb\ZF1\TableAbstract &$model)
    {
        $this->model = $model;

        return $this;
    }

    public function setRow(\AckDb\ZF1\RowAbstract &$row)
    {
        $instance = $row->getTableInstance();
        $this->setModel($instance);

        return $this;
    }

    public function &getHtmlManager()
    {
        return $this->htmlManager;
    }

    public function setHtmlManager(&$htmlManager)
    {
        $this->htmlManager = &$htmlManager;

        return $this;
    }

    public function &getController()
    {
        if(empty($this->controller)) throw new \Exception("O controller não foi setado", 1);

        return $this->controller;
    }

    public function setController(&$controller)
    {
        $this->controller = &$controller;

        return $this;
    }

}
