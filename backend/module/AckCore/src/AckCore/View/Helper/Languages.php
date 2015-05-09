<?php
namespace AckCore\View\Helper;
class Languages
{
	public static function getAllObjects()
	{
		$model = new \AckCore\Model\Languages;
		$result = $model->toObject()->onlyAvailable()->get();

		return $result;
	}

    public static function getIncludingUnavailableObjects()
    {
        $model = new \AckCore\Model\Languages;
        $result = $model->toObject()->get();

        return $result;
    }
}

?>
