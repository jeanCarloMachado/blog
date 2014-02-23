<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
class Explanation extends AbstractHelper
{
    public function __invoke($textId, $columnName = "texto")
    {
    	$model = new  \AckContent\Model\Texts;
		$result = $model->toObject()->getOne(array("id"=>$textId));

		if(empty($result))
			throw new \Exception("Não foi possível localizar o id do texto passado: $textId");

		$methodName = "get".$columnName;

		return $result->$methodName()->getVal();
    }
}