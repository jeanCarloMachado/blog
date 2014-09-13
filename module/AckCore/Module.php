<?php
/**
 * configuração do módulo base do ack
 *
 * AckDefault - Cub
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */

namespace AckCore;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use AckCore\Facade,
    AckCore\Utils\Session;
use Zend\Log\Logger,
    Zend\Log\Writer\FirePhp as FirePhpWriter;
/**
 * configuração do módulo base do ack
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
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
        Session::start();

        date_default_timezone_set('America/Sao_Paulo');

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('dispatch',array($this,'loadConfiguration'),100);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager = $e->getApplication()->getEventManager();
        //sincroniza o facade com as informações da url
        $eventManager->attach('route', function (MvcEvent $mvcEvent) {
            Facade::getInstance()->setParamsRoute($mvcEvent->getRouteMatch()->getParams());
        });
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

        //========================= asserts  =========================

        //desabilita as asserções
        assert_options(ASSERT_ACTIVE, 0);
        assert_options(ASSERT_WARNING, 0);
        assert_options(ASSERT_QUIET_EVAL, 0);

        //======================= END asserts  =======================

        //adiciona o layout default
        $app = $e->getApplication();
        $em  = $app->getEventManager(); // Specific event manager from App
        $sem = $em->getSharedManager(); // The shared event manager

        $sem->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function ($e) {
            $controller = $e->getTarget(); // The controller which is dispatched
            $controller->layout('ack/layout');
        });

        //sincroniza o facade com as informações da url
        $eventManager->attach('route', function (MvcEvent $mvcEvent) {
            Facade::getInstance()->setParamsRoute($mvcEvent->getRouteMatch()->getParams());
        });

        //========================= desabilita a página de erro ========================
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function ($e) {
            $result = $e->getResult();
            $result->setTerminal(TRUE);
        });
        //======================= END desabilita a página de erro ======================
        //
        Facade::setServiceManager($e->getApplication()->getServiceManager());
    }

    /**
     * retorna  as configurações de helpers
     * @return [type] [description]
     */
    public function getViewHelperConfig()
    {
        return array (
            'factories' => array(
                'explain' => function ($sm) {
                    $helper = new \AckCore\View\Helper\Explanation ;

                    return $helper;
                },
                'pluralize' => function ($sm) {
                    $helper = new \AckCore\View\Helper\Pluralizer ;

                    return $helper;
                },
                'visible' => function ($sm) {
                    $helper = new \AckCore\View\Helper\Visible ;

                    return $helper;
                },
                'highlight' => function ($sm) {
                    $helper = new \AckCore\View\Helper\Highlight ;

                    return $helper;
                },
                'info' => function ($sm) {
                    $helper = new \AckCore\View\Helper\SystemInfo ;

                    return $helper;
                },
                'mainMenu' => function ($sm) {
                    $auth = new \AckUsers\Auth\User;
                    $auth->setServiceLocator($sm);
                    $helper = new \AckCore\View\Helper\MainMenuAutomounter;

                    if ($auth->isAuth()) {
                        $helper->setCurrentUser($auth->getUserObject());
                    }

                    return $helper;
                },
                'sideColumn' => function ($sm) {
                    $helper = new \AckCore\View\Helper\SideColumn;

                    return $helper;
                },

                'buildFilters' => function ($sm) {
                    $helper = new \AckCore\DataAbstraction\Service\InterpreterFilter;

                    return $helper;
                },

                'HtmlElementsManager' => function ($sm) {
                    $service = new \AckCore\HtmlElements\HtmlElementsManager;

                    return $service;
                },

            )
        );
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
                'debug' => function ($sm) {
                    $log = null;

                    if (Facade::debugStatus()) {
                        $log = new Logger;
                        $writer = new FirePhpWriter();
                        $log->addWriter($writer);
                    } else
                        $log = new \AckCore\Utils\Void;

                    return $log;
                },
                'genericModel' => function ($sm) {
                    $model = new \AckCore\Model\Generics;

                    return $model;
                },

                'HtmlElementsManager' => function ($sm) {
                    $service = new \AckCore\HtmlElements\HtmlElementsManager;

                    return $service;
                },

                'ModelRelationsToHtmlElementsConverter' => function ($sm) {
                    $service = new \AckCore\Controller\Helper\ModelRelationsToHtmlElementsConverter($sm->get('HtmlElementsManager'));

                    return $service;
                },

                'InterpreterForm' => function ($sm) {
                    $service = new \AckCore\DataAbstraction\Service\InterpreterForm;
                    $service->setServiceLocator($sm);

                    return $service;
                },

                'InterpreterSearch' => function ($sm) {
                    $service = new \AckCore\DataAbstraction\Service\InterpreterSearch;
                    $service->setServiceLocator($sm);

                    return $service;
                },

                'GenericTableModel' => function ($sm) {
                    $service = new \AckCore\Model\Generics;
                    $service->setServiceLocator($sm);

                    return $service;
                },

                'ZF2Module' => function ($sm) {
                    $service = new \AckCore\Model\ZF2Module;
                    $service->setServiceLocator($sm);

                    return $service;
                },

                'ZF2Modules' => function ($sm) {
                    $service = new \AckCore\Model\ZF2Modules;
                    $service->setServiceLocator($sm);

                    return $service;
                },
                'AjaxUtils' => function ($sm) {
                    $service = new \AckCore\Utils\Ajax;

                    return $service;
                },
                    
                'DataManager' => function ($sm) {
                
                    $service = new \AckCore\Data\Manager;

                    return $service;
                },
                'Captcha' => function ($sm) {
                
                    $service = new \AckCore\HtmlElements\Captcha;

                    return $service;
                },
            ),
        );
    }
}
