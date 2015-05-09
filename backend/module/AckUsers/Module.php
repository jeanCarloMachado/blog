<?php
/**
 * classedo  módulo
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
namespace AckUsers;

use AckUsers\Auth\AuthenticationService;
use AckUsers\Auth\Adapter;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
/**
 * módulo de usuaŕios
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
     * dá setup dos serviços providos
     * pelo módulo
     * @return [type] [description]
     */
    public function getServiceConfig()
    {
        return array(
            'factories'  => array(

                'Auth' => function ($sm) {
                    $auth = new AuthenticationService;

                    return $auth;
                },

                'AuthAdapter' => function ($sm) {

                    $adapter = new Adapter;
                    $adapter->setServiceLocator($sm);

                    return $adapter;
                },

                'AckAuthenticationModel' => function ($sm) {
                    $auth = new \AckUsers\Model\Users;
                    $auth->setServiceLocator($sm);

                    return $auth;
                },
            ),
        );
    }
}
