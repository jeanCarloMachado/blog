<?php
namespace AckDb\ZF1\RowSerivce;
use AckCore\Service\ProviderInterface;
class Provider implements ProviderInterface
{
    protected $services = array(
        "Annexes"
    );

    public function provide($something,array $params = null)
    {
        foreach ($services as $service) {
            $className = "\\AckCore\\Db\\RowSerivce\\$service";
            $instance = new $className;
            if (method_exists($instance, $something)) {
                return $instance->$something($params);
            }
        }

        throw new \Exception("Não foi possível encontrar provedor para a funcionalidade requisitada!");
    }

    public function getServices()
    {
        return $this->services;
    }
}
