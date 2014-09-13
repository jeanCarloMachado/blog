<?php
namespace AckCEO;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

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

    public function getServiceConfig()
    {
        return array(
            'factories' => array (
                'Metatags' => function ($sm) {
                    $model = new \AckCEO\Model\Metatags;
                    $model->setServiceLocator($sm);

                    return $model;
                },

                'AckMetatagsControllerPlugin' => function ($sm) {
                    $model = new \AckCEO\Controller\Helper\Metatags;
                    $model->setServiceLocator($sm);

                    return $model;
                }
            )    
        );
    }

    /**
     * retorna  as configurações de helpers
     * @return [type] [description]
     */
    public function getViewHelperConfig()
    {
        return array (
            'factories' => array(
                'Metatags' => function ($sm) {
                    $service = new \AckCEO\View\Helper\Metatags;

                    return $service;
                },
            )
        );
    }
}
