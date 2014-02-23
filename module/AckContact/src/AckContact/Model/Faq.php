<?php
namespace AckContact\Model;
use AckDb\ZF1\RowAbstract;
class Faq extends RowAbstract
{
    protected $_table = "\AckContact\Model\Faqs";

    public function incrementAccess()
    {
        $current = $this->getAcessos()->getVal();
        $new = (int) $current+1;

        return $this->setAcessos($new)->save();
    }

    public function incrementPositive()
    {
        $current = $this->getPositivos()->getVal();
        $new = (int) $current+1;

        return $this->setPositivos($new)->save();
    }

    public function incrementNegative()
    {
        $current = $this->getNegativos()->getVal();
        $new = (int) $current+1;

        return $this->setNegativos($new)->save();
    }

    public function avaliate($value)
    {
        $result = null;
        if ($value) {
            $result = $this->incrementPositive();
        } else {
            $result = $this->incrementNegative();
        }

        return $result;
    }
}
