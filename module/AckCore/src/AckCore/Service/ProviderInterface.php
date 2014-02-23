<?php
namespace AckCore\Serivce;
interface ProviderInterface
{
    public function provide($something,array $params = null);
    public function getServices();
}
