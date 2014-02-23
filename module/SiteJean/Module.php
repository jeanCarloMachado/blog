<?php
namespace SiteJean;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use AckDb\ZF1\ZendTableAbstract;
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
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //sincroniza o facade com as informações da url
        $eventManager->attach('route', function (MvcEvent $mvcEvent) {
            \AckCore\Facade::getInstance()->setParamsRoute($mvcEvent->getRouteMatch()->getParams());
        });

      //adiciona o layout default
        $app = $e->getApplication();
        $em  = $app->getEventManager(); // Specific event manager from App
        $sem = $em->getSharedManager(); // The shared event manager

        $sem->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function ($e) {
                $controller = $e->getTarget(); // The controller which is dispatched
                $controller->layout("SiteJean/layout");
        });

        $this->setupDatabase($e);

        $application = $e->getParam('application');
        $config = $application->getServiceManager()->get('ApplicationConfig');
    }

    /**
     * configura o banco de dados do cliente
     *
     * @param MvcEvent $e evento do zend
     *
     * @return void null
     */
    public function setupDatabase(MvcEvent $e)
    {

        $application = $e->getParam('application');
        $configDb = $application->getServiceManager()->get('Config');

        $configDb = $configDb['db'];


         //configura o banco de dados do zend framework 1
        $dbMysql = \AckDb\ZF1\Db::factory($configDb["driver"],
                                            array(
                                                'host' => $configDb["host"],
                                                //'port' => $configDb['port'],
                                                'username' => $configDb["username"],
                                                'password' => $configDb["password"],
                                                'dbname' => $configDb["dbname"],
                                                'charset' => 'utf8'
                                            )
                                        );

        $registry = \AckDb\ZF1\Registry::getInstance();
        $registry->set('db',$dbMysql);
        ZendTableAbstract::setDefaultAdapter($dbMysql);
    }

     /**
     * dá setup dos serviços providos
     * pelo módulo
     *
     * @return array array de serviços
     */
    public function getServiceConfig()
    {
        return array(
            'factories'  => array(

                 'sessionMgr' => function ($sm) {
                    $service = new \SiteJean\Controller\Helper\SessionMgr();

                    return $service;
                },

                'Empresas' => function ($sm) {

                    $service = new \SiteJean\Model\Empresas;
                    $service->setServiceLocator($sm);

                    return $service;
                },

                'Planos' => function ($sm) {

                    $service = new \SiteJean\Model\Planos;
                    $service->setServiceLocator($sm);

                    return $service;
                },
                'Usuarios' => function ($sm) {

                    $service = new \SiteJean\Model\Usuarios;
                    $service->setServiceLocator($sm);

                    return $service;
                },

                'Filiais' => function ($sm) {

                    $service = new \SiteJean\Model\Filiais;
                    $service->setServiceLocator($sm);

                    return $service;
                },
            ),
        );
    }
}
