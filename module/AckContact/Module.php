<?php
namespace AckContact;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use AckCore\Facade;
class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        $config =  array(
            'Zend\Loader\ClassMapAutoloader' => array(

                ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
// if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                    ),
                ),
            );

        return $config;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * função chamada em todo o call do sistema (deve apenas)
     * registrar listener's de eventos e conf. leves
     * @param  MvcEvent $e [description]
     * @return [type]   [description]
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('dispatch',array($this,'loadConfiguration'),100);
    }
    /**
     * configura o sistema propriamente
     * @param  MvcEvent $e [description]
     * @return [type]   [description]
     */
    public function loadConfiguration(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //sincroniza o facade com as informações da url
        $eventManager->attach('route', function (MvcEvent $mvcEvent) {
            \AckCore\Facade::getInstance()->setParamsRoute($mvcEvent->getRouteMatch()->getParams());
        });
    }

    /**
     * retorna as configurações de serviço
     *
     * @return array array de confs
     */
    public function getServiceConfig()
    {
        return array(
            'factories'  => array(
                'ContatosSimples' => function ($sm) {
                    $model = new \AckContact\Model\ContatosSimples;
                    $model->setServiceLocator($sm);

                    return $model; 
                },

                'Contacts' => function ($sm) {
                    $model = new \AckContact\Model\ContatosSimples;
                    $model->setServiceLocator($sm);

                    return $model; 
                },
            ));
    }
}
