<?php
namespace AckCore\Interfaces;
interface Search
{
    /**
     * return $this
     */
    public function prepare();

    public function buildQuery();

    public function runQuery();

    public function setFirstItemIndex(int $index);

    public function getFirstItemIndex();

    public function setTotalItensToGet(int $totalItensToGet);

    public function setTotalItensToGet(int $totalItensToGet);

    public function getResult();

    public function setResult();

    public function getCount();

    public function setCount();

}
