<?php
namespace AckCore\Model;

use AckDb\ZF1\TableAbstract;
/**
 * versão de comentários 1.3
 * todas as classes extendendo TableAbstract representam uma tabela
 * no banco de dados, mais que isso, na maioria dos casos são utilizadas também como uma entidade lógica
 * mostrada no front, a excessão são as tabelas de relacionamentos n_n
 * @author jean
 */
class Visits extends TableAbstract
{
    /**
     * nome da tabela no banco de dados
     * @var unknown
     */
    protected $_name = "ack_visitas";

    /**
     * nome da classe simbolizando uma linha (deve estender System_Row_Abstract)
     * @var unknown
     */
    protected $_row = "\AckCore\Model\Visit";

    public function getTotal()
    {
        $result = $this->count();

        return $result;
    }

    public function getTotalCurrMonth()
    {
        $query = "SELECT count(id) FROM ".$this->getTableName()." WHERE MONTH(data)=".date("m")." AND YEAR(data)=".date("Y");
        $result = $this->run($query);
        $result = reset($result);

        return $result["count(id)"];
    }

    /**
     * média mensal de visitas
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
