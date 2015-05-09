<?php

namespace AckBlog;

use AckBlog\Model\Posts;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        $config = array(
            'Zend\Loader\ClassMapAutoloader' => array(

                ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
// if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__.'/src/'.str_replace('\\', '/', __NAMESPACE__),
                    ),
                ),
            );

        return $config;
    }

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Posts' => function ($sm) {
                    $model = new Posts();
                    $model->setServiceLocator($sm);

                    return $model;
                },
            ),
        );
    }
}
