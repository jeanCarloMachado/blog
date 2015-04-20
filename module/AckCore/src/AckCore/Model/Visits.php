<?php
namespace AckCore\Model;

use AckDb\ZF1\TableAbstract;

class Visits extends TableAbstract
{
    protected $_name = "ack_visitas";

    protected $_row = "\AckCore\Model\Visit";

    public function getTotal()
    {
        $result = $this->count();

        return $result;
    }

    public function getTotalForDate(\Datetime $date)
    {
        $query = "SELECT count(id) FROM ".$this->getTableName()."
            WHERE MONTH(data)=".$date->format("m")." AND YEAR(data)=".$date->format("Y")." AND DAY(data)=".$date->format("d");
        $result = $this->run($query);
        $result = reset($result);

        return $result["count(id)"];
    }
    public function getTotalCurrMonth()
    {
        $query = "SELECT count(id) FROM ".$this->getTableName()." WHERE MONTH(data)=".date("m")." AND YEAR(data)=".date("Y");
        $result = $this->run($query);
        $result = reset($result);

        return $result["count(id)"];
    }

    /**
     * média mensal de visitas.
     *
     * @return Ambigous <[type], number>
     */
    public function getMonthAverage()
    {
        $query = "SELECT count(id) FROM ".$this->getTableName()." GROUP BY MONTH(data)=".date("m");
        $result = $this->run($query);

        $i = 0;
        $sum = 0;

        if (!empty($result[0])) {
            foreach ($result as $element) {
                $sum += $element["count(id)"];
                $i++;
            }
        }

        return ($i != 0) ? $sum/$i : 0;
    }
}
