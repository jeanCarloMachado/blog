<?php
namespace AckProducts\Model;
use AckDb\Model\TableHierarchy;
class ProductsComponents extends TableHierarchy
{
	protected $_name = "produtos_componentes";
	protected $_row = "\AckProducts\Model\ProductsComponent";

	// const moduleName = "Nome do módulo";
	// const moduleId = 666;
}
