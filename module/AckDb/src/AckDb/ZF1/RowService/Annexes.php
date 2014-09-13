<?php
namespace AckDb\ZF1\RowService
use AckDb\ZF1\RowService\RowService;
class Annexes extends RowService
{
    public function getMyAnnexes()
    {
        if(!$this->getRow()->getId()->getBruteVal()) return array();

        return $this->getRow()->seekMyAnnexes(null,"\AckMultimidia\Model\\");
    }
}
