<?php
namespace AckCore\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SystemInfo extends AbstractHelper
{
    public function __invoke()
    {
        return new SystemInfo();
    }

    public function getObject()
    {
        $modelSystem = new \AckCore\Model\Systems();
        $resultSystem = $modelSystem->toObject()->get(array("id" => 1));

        $resultSystem = reset($resultSystem);

        return $resultSystem;
    }

    public function getDataPublicacao()
    {
        $modelSystem = new \AckCore\Model\Systems();
        $resultSystem = $modelSystem->toObject()->get(array("id" => 1));

        $resultSystem = reset($resultSystem);
        $result = $resultSystem->getPublicacao()->getVal();

        return $result;
    }

    public function isSiteOpen()
    {
        $modelSystem = new \AckCore\Model\Systems();
        $resultSystem = $modelSystem->toObject()->get(array("id" => 1));

        $resultSystem = reset($resultSystem);
        $result = $resultSystem->getPublicado()->getVal();

        return $result;
    }

    public function totalVisits()
    {
        $modelVisits = new \AckCore\Model\Visits();
        $resultSystem = $modelVisits->getTotal();

        return $resultSystem;
    }

    public function totalVisitsThisMonth()
    {
        $modelVisits = new \AckCore\Model\Visits();
        $resultSystem = $modelVisits->getTotalCurrMonth();

        return $resultSystem;
    }

    public function totalVisitsAverage()
    {
        $modelVisits = new \AckCore\Model\Visits();
        $resultSystem = $modelVisits->getMonthAverage();

        return $resultSystem;
    }

    public function isSiteBeingBuilding()
    {
        $modelSystem = new \AckCore\Model\System();
        $resultSystem = $modelSystem->toObject()->get(array("id" => 1));

        $resultSystem = reset($resultSystem);
        $result = $resultSystem->getConstrucao()->getVal();

        return $result;
    }

    public function isSiteClosed()
    {
        $modelSystem = new \AckCore\Model\Systems();
        $resultSystem = $modelSystem->toObject()->get(array("id" => 1));

        $resultSystem = reset($resultSystem);
        if (empty($resultSystem)) {
            return false;
        }

        $result = $resultSystem->getPublicado()->getVal();

        return !$result;
    }

    public function email()
    {
        $modelSystem = new \AckCore\Model\Systems();
        $resultSystem = $modelSystem->toObject()->get(array("id" => 1));

        $resultSystem = reset($resultSystem);
        $result = $resultSystem->getEmail()->getVal();

        return $result;
    }

    public function totalLangsEnabled()
    {
        $model = new \AckCore\Model\Languages();

        return $model->count(array("visivel" => "1"));
    }

    public function itensPagina()
    {
        $modelSystem = new \AckCore\Model\Systems();
        $resultSystem = $modelSystem->toObject()->getOne(array("id" => 1));
        if (empty($resultSystem)) {
            return false;
        }
        $result = $resultSystem->getItensPagina()->getVal();

        return $result;
    }
}
