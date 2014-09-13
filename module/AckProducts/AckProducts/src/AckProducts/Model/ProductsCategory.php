<?php
namespace AckProducts\Model;
use AckDb\Model\RowHierarchy;
class ProductsCategory extends RowHierarchy
{
	protected $_table = "\AckProducts\Model\ProductsCategorys";

	public function getCategory()
	{
		return \AckProducts\Model\Categorys::getFromId($this->getCategoriasId()->getBruteVal());
	}
}

