<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
class LogsInfo extends AbstractHelper
{
	/**
	 * retorna o objeto da ultima atualização
	 */
	public static function lastChangeObject()
	{
		$modelLogs = new \AckCore\Model\Logs();
		$resultLogs = $modelLogs->toObject()->get(null,array("limit"=>array("count"=>1),"order"=>"id DESC"));

		$resultLogs = reset($resultLogs);
		return $resultLogs;
	}
}