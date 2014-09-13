<?php
/**
 * modelo de produtos
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
class Products extends TableHierarchy
{
    protected $_name = "ack_produtos";
    protected $_row = "\AckProducts\Model\Product";
    const moduleName = "produtos";
    const moduleId = 8;

    protected $colsNicks = array(
        "titulo_pt" => "Título",
        "titulo" => "Título",
        "aplicacao" => "Aplicação",
        "fabricante_original" => "Fabricante Original",
        "descricao_pt" => "Descrição",
        "visivel" => "Visível",
        "ano_ini"=>"Ano inicial",
        "ano_fim"=>"Ano final",
        "fakeid"=>"Código",
        "codigo_interno"=>"Código Interno da empresa",
    );

    /**
     * retorna os destaques
     * @param  [type] $params [description]
     * @return [type] [description]
     */
    public function getHighlights($params = null)
    {
        $result = $this->toObject()->onlyAvailable()->get(array("destaque"=>1),$params);

        return $result;
    }

    /**
     * retorna o total de produtos
     * @return [type] [description]
     */
    public static function getTotal()
    {
        $model = new Products();
        $result = $model->count();

        return $result;
    }

    /**
     * retorna os produtos da categoria passada e os produtos
     * de suas categorias filhas
     * @return [type] [description]
     */
    public function getFromCategoryAndItsChildren($category)
    {
        //pega todas as categorias que serão utilizadas e as guarda em um array
        $modelCategorys = new \AckProducts\Model\Categorys;
        $categories = $modelCategorys->getCategoryAndChild($category);

        $modelProductsCategorys = new \AckProducts\Model\ProductsCategorys;
        $relations = array();
        foreach ($categories as $category) {
            $relations = array_merge($relations,$modelProductsCategorys->toObject()->onlyAvailable()->get(array("categorias_id"=>$category->getId()->getBruteVal())));
        }

        $productsIds =  \AckCore\Utils\Arr::getColsFromObjects(array('produtosid'),$relations,null,false,array(),true);
        $productsIds = array_unique($productsIds);
        $modelProducts = new \AckProducts\Model\Products;
        $products = $modelProducts->toObject()->getFromArrayOfId($productsIds);

        return $products;
    }
}
