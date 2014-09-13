<?php
namespace AckMvc;
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

        //adiciona o layout default
        $app = $e->getApplication();
        $em  = $app->getEventManager(); // Specific event manager from App
        $sem = $em->getSharedManager(); // The shared event manager

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
                'AutomaticallyGeneratedControllerConfig' => function ($sm) {
                    $service = new \AckMvc\Controller\Helper\AutomaticallyGeneratedControllerConfig;
                    $service->setServiceLocator($sm);

                    return $service;
                },
                'AckControllerPluginManager' => function ($sm) {
                    $service = new \AckMvc\Controller\Helper\PluginManager;
                    $service->attach('editarAction', $sm->get('AckMetatagsControllerPlugin'));
                    $service->attach('saveAjax', $sm->get('AckMetatagsControllerPlugin'));

                    $service->setServiceLocator($sm);

                   return $service; 
                }
            ),
        );
    }
}
