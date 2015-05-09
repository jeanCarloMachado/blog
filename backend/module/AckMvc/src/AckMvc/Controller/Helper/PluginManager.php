<?php

namespace AckMvc\Controller\Helper;

use AckCore\Stdlib\ServiceLocator\ServiceLocatorAware;

/**
 * administrador dos plugins dos controllers
 * metatags, imagens, anexos, etc.
 */
class PluginManager
{
    use ServiceLocatorAware;
    protected $plugins = array();

    public function __construct($plugins = array())
    {
        if (!empty($plugins)) {
            foreach ($plugins as $eventName => $plugin) {
                $this->attach($eventName, $plugin);
            }
        }
    }

    public function notify($eventName, &$contextData)
    {
        if (array_key_exists($eventName, $this->getPlugins())
            && is_array($this->getPlugins()[$eventName])) {
            foreach ($this->getPlugins()[$eventName] as $plugin) {
                $plugin->listen($eventName, $contextData);
            }
        }
    }

    public function attach($eventName, $plugin)
    {
        $this->plugins[$eventName][] = $plugin;
    }

    /**
     * Gets the value of Plugins.
     *
     * @return Plugins
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Sets the value of Plugins.
     *
     * @param Plugins $Plugins description
     *
     * @return PluginsManager
     */
    public function setPlugins(Plugins $Plugins)
    {
        $this->plugins = $Plugins;

        return $this;
    }
}
