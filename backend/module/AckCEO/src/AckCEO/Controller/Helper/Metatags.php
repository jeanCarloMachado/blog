<?php

namespace AckCEO\Controller\Helper;

use AckCore\Stdlib\ServiceLocator\ServiceLocatorAware;

/**
 * Plugin de metatags para os controllers.
 */
class Metatags
{
    use ServiceLocatorAware;

    public function listen($eventName, &$contextData)
    {
        if ($eventName == 'editarAction') {
            $controllerConfig = &$contextData;
            echo "<pre>"; var_dump('teste'); die;
            if (isset($contextData['plugins']) && in_array('metatags', $contextData['plugins'])) {
                $config = array('blacklist' => array('classname','relatedid'));
                $where = array(
                    'related_id' => $controllerConfig['row']->getId()->getBruteVal(),
                    'class_name' => $controllerConfig['row']->getTableModelName(),
                );

                $metatag = $this->getServiceLocator()->get('Metatags')->toObject()->getOne($where);

                //neste caso context data == à configuração do controlador
                $contextData['belowMainSection']['metatags'] = $this->getServiceLocator()
                    ->get('InterpreterForm')
                    ->setCustomConfig($config)
                    ->buildElementsFromRow($metatag);
            }
        }

        if ($eventName == 'saveAjax' && isset($contextData['data']['metatags'])) {
            $data = $contextData['data'];
            $where = array('class_name' => $contextData['class_name'], 'related_id' => $data['default']['id']);

            $data['metatags'] = array_merge($data['metatags'], $where);
             /* @var Metatagsh object */
             $this->getServiceLocator()->get('Metatags')->updateOrCreate($data['metatags'], $where);
        }
    }
}
