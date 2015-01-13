<?php

/**
 * description
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
namespace AckMvc\Controller;

use AckCore\Utils\Arr as ArrayObject;
use AckCore\Facade;
use Zend\Mvc\Controller\AbstractActionController;
use AckCore\Utils\Ajax;
use Zend\View\Model\ViewModel;
use  \AckCore\DataAbstraction\Service\InterpreterSearch;
use AckCore\Event\Event as AckEvent;
use AckCore\Event\EventManager;
use Zend\Mvc\InjectApplicationEventInterface;
use Zend\EventManager\EventInterface as Event;
use AckCore\Stdlib\Observer\Observable as ObservableTrait;
use AckMvc\Controller\Traits\BasicControllerUtilities;
use AckMvc\Model\RelatedModel;
use AckCore\Facade\ApplicationConfiguration;
use \AckCore\Data\Manager as DataManager;
/**
 * abstração base para controllers e rows
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
abstract class AbstractTableRowController extends AbstractActionController implements InjectApplicationEventInterface
{
    use BasicControllerUtilities;
    use ObservableTrait;
    use RelatedModel;
    use ApplicationConfiguration;

    /**
     * a chave default chama-se 'default'
     * @var array
     */
    public $ajax = array();
    protected $viewModel = null;
    protected $itensPerPage = 20;
    protected $plugins;
    protected $config = array();

    protected $filesActions = array(
        'lista.phtml' => array('lista'),
        'visualizarEditarIncluir.phtml' => array('visualizar','editar','incluir')
    );

    /**
     * objeto container das informaçẽos
     * relativas a renderização
     * @var [type]
     */
    protected $scopedData = null;

    /**
     * plugin manager necessita desta função
     */
    //========================= actions =========================

    public function listaAction()
    {
        $this->evtBeforeRunLocal();

        $model = $this->getModelInstance();

        $config = $this->viewModel->config;
        $config['row'] = $model->getRowInstance();
        $config['list'] = array();
        $this->viewModel->config = $config;

        $this->evtBeforeReturnLocal();

        return $this->viewModel;
    }

    public function editarAction()
    {
        $this->evtBeforeRunLocal();

        $model = $this->getModelInstance();

        $config = $this->viewModel->config;

        $config['row'] = $model->onlyNotDeleted()->toObject()->getOne(array('id'=>(int) $this->params('id')));

        $this->getServiceLocator()->get('AckControllerPluginManager')->notify(__FUNCTION__, $config );

        $this->viewModel->config = $config;

        $this->evtAfterGetScopedDataLocal();

        $this->evtBeforeReturnLocal();

        return $this->viewModel;
    }

    /**
     * functionalidade default de salvar
     * @return [type] [description]
     */
    public function saveAjax()
    {
        $data = DataManager::getInstance($this->ajax)
                ->getData();

        $defaultRow = isset($data['default']) ? $data['default'] : $data;

        $result = null;
        $this->evtBeforeRunLocal();
        $config = $this->viewModel->config;

        //prepara o retorno
        $json = array('status'=>1,'mensagem'=>'Dados salvos com sucesso.');

        /**
         * prepara as variáveis de entrada
         */
        //pega o nome do modelo dependendo se é categoria ou não
        $model = $this->getModelInstance();
        $id = (isset($defaultRow['id'])) ? $defaultRow['id'] : null;

        try {
            //salva os dados propriamente
            if ($id) {
                $where = array('id'=>$id);
                if (!isset($config['disableExceptionEncapsulation'])) {
                      try {
                            $result = $model->update($defaultRow, $where);
                        } catch (\Exception $e) {
                            $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(false, $e->getMessage());
                        }
                } else {
                      $result = $model->update($defaultRow, $where);
                }
            } else {
                if (!isset($config['disableExceptionEncapsulation'])) {
                    try {
                        $result = $model->create($defaultRow);
                        if (is_object($result)) {
                            $json['url'] = $this->buildUrl('editar').'/'.$result->getId()->getVal();
                        } else {
                            $json['url'] = $this->buildUrl('editar').'/'.$result;
                        }
                    } catch (\Exception $e) {
                        $this->getServiceLocator()->get('AjaxUtils')->notifyStatus(false, $e->getMessage());

                    }
                } else {
                    $result = $model->create($defaultRow['data']);
                }
            }
        } catch (\Exception $e) {
            $json['status'] = 0;
            $json['mensagem'] = $e->getMessage();
        }

        //se a query retornou um objeto salva somente o id em result
        if (is_object($result)) {
            $result = $result->getId()->getBruteVal();
        }

        $this->evtAfterMainSave($result);

        //salva os plugins
        $contextData['data'] = $data;
        $contextData['class_name'] = $this->getModelName();
        $this->getServiceLocator()->get('AckControllerPluginManager')->notify(__FUNCTION__, $contextData);

        $json['id'] = ($result) ?  $result : $id;
        if ($this->ajax['parameters'] == 'noLayout' && $json['url']) {
            $json['url'].='/nolayout';
            $json['parameters'] = 'noLayout';
        }

        $this->evtBeforeReturnLocal();
        Ajax::notifyEnd($json);

        return $this->response;
    }

    /**
     * carrega uma quantidade
     * de itens filtrando-os se necessário
     * @return [type] [description]
     */
    public function loadItensAjax()
    {
        $this->evtBeforeRunLocal();
        //pega o nome do modelo dependendo se é categoria ou não
        $model = $this->getModelInstance();
        $config = (!empty($this->viewModel->config)) ? $this->viewModel->config : array();

        $itensPerPage = isset($this->ajax['itensPerPage'])) ? $this->ajax['itensPerPage'] $this->itensPerPage;

        $params = array('limit'=>array('offset'=>$this->ajax['itensCount'], 'count'=> $itensPerPage));

        if (!empty($config['order'])) {
            $params['order'] = $config['order'];
        } if (empty($params['order'])) {
            if ($model->hasColumn('ordem')) {
                $params['order'] = 'ordem DESC';
            } elseif ($model->hasColumn('nome')) {
                $params['order'] = 'nome ASC';
            } else {
                $params['order'] = 'id DESC';
            }
        }

        $resultObjects = $this->evtLoadItensOnQuery($config['where'], $params, $config);

        $url = $this->buildUrl('editar');

        /**
         * remove os elementos html das strings
         */
        $result['grupo'] = array();
        if (!empty($resultObjects)) {
            foreach ($resultObjects as $rowId => $row) {
                $vars = $row->getVars();

                foreach ($vars as $elementId => $element) {

                    if (isset($config['returnFalseInCols']) && in_array($elementId, $config['returnFalseInCols'])) {
                        $result['grupo'][$rowId][$elementId] = 'false';
                        continue;
                    }

                    if ($elementId == 'id') {
                        $result['grupo'][$rowId][$elementId] = $element->getBruteVal();
                    } else {
                        $result['grupo'][$rowId][$elementId] = strip_tags($element->showNChars()->getVal());
                    }

                    $this->evtLoadItensOnColumnIterator($elementId,$element,$rowId,$vars, $result, $config);
                }
                $result['grupo'][$rowId]['url_linha'] = $url.'/'.$row->getId()->getVal().'/id';
            }
        }

        $result['showButton'] = (count($result['grupo']) < $this->itensPerPage) ? false : true;
        $result['status'] = 1;
        $result['disableSuccessNotifiction'] = true;
        $result['mensagem'] = 'Itens carregados com sucesso';

        $this->evtBeforeReturnLocal();
        Ajax::notifyEnd($result);
    }

    public function visualizarAction()
    {
        $this->evtBeforeRunLocal();
        $this->evtBeforeReturnLocal();

        return $this->viewModel;
    }

    public function incluirAction()
    {
        $this->evtBeforeRunLocal();

        $config = $this->viewModel->config;

        $model = $this->getModelInstance();

        $row = $model->getRowInstance();

        if (isset($config['fillRelations'])) {
            foreach ($config['fillRelations'] as $relation) {

                $modelName = substr($relation['model'], 1);
                $relationConfig = $this->getModelInstance()->getRelationConfigFromModelName($modelName);

                if (!empty($relationConfig)) {
                    $setCall = 'set'.str_replace('_', '', $relationConfig['reference']);
                    $row->$setCall($relation['id']);
               }
            }
        }

        $config['row'] = $row;

        $this->viewModel->config = $config;

        $this->evtAfterGetScopedDataLocal();
        $this->evtAfterGetScopedData();
        $this->evtBeforeReturnLocal();

        return $this->viewModel;
    }

    /**
     * [excluirAction description]
     * @return [type] [description]
     */
    protected function deleteAjax()
    {
        $this->evtBeforeRunLocal();
        //pega o nome do modelo dependendo se é categoria ou não
        $model = $this->getModelInstance();

        $json = array('status'=>1,'mensagem'=>'Operação realizada com sucesso!');
        foreach ($this->ajax['ids'] as $element) {
            $result = $model->delete(array('id'=>$element));
        }

        $this->evtBeforeReturnLocal();
        $json['disableSuccessNotifiction'] = true;
        \AckCore\Utils\Ajax::notifyEnd($json);
    }
    //======================= END actions =======================

    //========================= eventos privados =========================
    /**
     * executado localmente para efeturar os
     * serviços da classe
     *
     * @return void null
     */
    final private function evtBeforeRunLocal()
    {
       //========================= notifica o evento =========================
       {
            $event = new AckEvent();
            $event->setType(EventManager::TYPE_ACTION_DISPATCH);
            $event->setControllerName( $this->params ( '__CONTROLLER__'));
            $event->setNamespace($this->params ( '__NAMESPACE__'));
            $event->setActionName($this->params('action'));
            //$event->setAcl($this->getServiceLocator()->get('acl'));
            $this->notify($event);
        }
        //======================= END notifica o evento =======================
         //testa a autenticação
        if (!$this->getServiceLocator()->get('auth')->hasIdentity()) {
            $this->redirect()->toRoute('login');
        }

        if (!isset($this->config['global']) &&  !isset($this->config[$this->params('action')])) {

            $this->config = $this->getServiceLocator()->get('AutomaticallyGeneratedControllerConfig')
                ->setModelInstance($this->getModelInstance())
                ->getConfig();
        }

        //pega as configuraçẽos do escopo
        if (empty($this->config[$this->params('action')])) {
            $cfg = $this->config['global'];
        } else {
            $cfg = ArrayObject::mergeReplacingOnlyFinalKeys($this->config['global'],$this->config[$this->params('action')]);
        }

        //========================= trata as especificadades de nolayout =========================
        if ($this->layoutDisabledRequest()) {
            $this->disableLayout($cfg);
        }
        //======================= END trata as especificadades de nolayout =======================

        //seta as urls
        if (empty($cfg['urlGateway'])) {
            $cfg['urlGateway'] =  $this->buildUrl('routerAjax');
        }
        if (empty($cfg['urlScoped'])) {
            $cfg['urlScoped'] = $this->buildUrl();
        }
        if (empty($cfg['urlAdd'])) {
            $cfg['urlAdd']  = $this->buildUrl('incluir');
        }
        if (empty($cfg['urlElement'])) {
            $cfg['urlElement']  = $this->buildUrl('editar');
        }

        //seta o manager dos elmentos html
        $this->viewModel->htmlManager = $this->getServiceLocator()->get('HtmlElementsManager');
        $templateFile = $this->getTemplateFileFromAction($this->params('action'));
        $template = $this->getTemplatePath($templateFile);
        $this->viewModel->setTemplate($template);

        $this->getServiceLocator()->get('AckControllerPluginManager')->notify(__FUNCTION__, $cfg);
        $this->viewModel->config = $cfg;

        $this->evtBeforeRun();
    }

    /**
     * testa se o usuário solicitou que o
     * layout seja desabilitado
     * @return boolean habilitado ou não
     */
    protected function layoutDisabledRequest()
    {
        return preg_match('/nolayout/', $this->params('params'));
    }

    protected function disableLayout(&$cfg)
    {
        $params = explode('-',$this->params('params'));

        $cfg['afterRemoveUrl'] = 'javascript:void(0);';

        //se o número de parâmetros for maior que o nolayout
        //então trata o autoseletor do relacionamento
        //========================= prepara os valores passados por parâmentros para setà-los automaticamente =========================
        if (count($params) > 1 && $this->params('action') == 'incluir') {
            $relatedModelId = end($params);
            $relatedModelId = explode('=',$relatedModelId);

            if ($relatedModelId > 1) {

                $relatedModel = reset($relatedModelId);
                $relatedId = end($relatedModelId);

                $cfg['fillRelations'] = array(array('model'=>$relatedModel, 'id'=>$relatedId));
            }
        }
        //======================= END prepara os valores passados por parâmentros para setà-los automaticamente =======================

        $this->viewModel->setTerminal(true);
        $cfg['nolayout']=true;
        $cfg['iframeVersion'] = true;
        $cfg['disableBack'] = true;

        return true;
    }

    /**
     * chamada local executada antes de retornars
     *
     * @return void null
     */
    final private function evtBeforeReturnLocal()
    {
        $this->evtBeforeReturn();
    }

    /**
     * função executada após pegar o conteúdo de escopo
     *
     * @return void retorna os conteúdos de escopo
     */
    protected function evtAfterGetScopedDataLocal()
    {
        $row = $this->viewModel->config['row'];

        $this->getServiceLocator()
            ->get('ModelRelationsToHtmlElementsConverter')
            ->setRow($row)
            ->setController($this)
            ->convert();

        $this->evtAfterGetScopedData();
    }

    /**
     * executado na iteração de uma coluna de uma linha no carregar mais
     *
     * @param string   $key       nome da coluna no banco de dados
     * @param Variable $element   objeto do tipo variável contendo o valor retornado
     * @param int      $iterator  iterador
     * @param array    $bdColumns colunas do banco
     * @param array    $result    resultado final
     * @param array    $config    configuração
     *
     * @return [type] [description]
     */
    public function evtLoadItensOnColumnIterator(
        &$key,
        &$element,
        &$iterator,
        array &$bdColumns,
        array &$result,
        array &$config
    ) {

        if ($key == 'id') {
            $result['grupo'][$iterator]['fakeid'] = $element->getVal();
        }

        //testa se é uma relação 1:n, caso sim, tenta mapeầ-la
        if (preg_match('/.{1,}id$/', $key) ) {

            $value = 'Não informado';

            if (null ==! $this->getModelInstance()->getRelations()['1:n'] && $element->getBruteVal()) {

                $value = 'Relação inalcançável';

                $relationConfig = $this->getModelInstance()->getRelationConfigFromColumnName($this->getModelInstance()->getRowPrototype()->vars[$key]->getColumnName());

                if (isset($relationConfig['model'])) {

                    $modelName = $relationConfig['model'];
                    $modelInstance = new $modelName();
                    $value = $modelInstance->toObject()->getOne(array('id'=>$element->getBruteVal()));

                    if (!empty($value)) {
                        $getFunction = $modelInstance->getMeta();
                        $getFunction = $getFunction['humanizedIdentifier'];
                        $getFunction = 'get'.$getFunction;

                        $getFunction = str_replace('_', '', $getFunction);

                        $value = $value->$getFunction()->getVal();
                    }

                }

            }

            $result['grupo'][$iterator][$key] = $value;

        }
    }

    /**
     * chamado por carregar mais no momento da execução da consulta
     *
     * @param array $where  cláusulas where
     * @param array $params parametros adicionais
     * @param array $config configuração do controlador
     *
     * @return array configurações customizadas no controlador
     */
    public function evtLoadItensOnQuery(&$where = null, array &$params = null, array &$config)
    {
        $model =  $this->getModelInstance();
        $this->getServiceLocator()->get('InterpreterSearch')->setRelatedModel($model)->alterQueryClausules($this->ajax, $where, $params);

        return $model->toObject()->onlyNotDeleted()->get($where, $params);
    }
    //======================= END eventos privados =======================
    //========================= eventos públicos =========================
    /**
     * executada antes de retornar a página
     */
    protected function evtBeforeReturn() {}

    /**
     * executada antes de rodar a página
     */
    protected function evtBeforeRun() {}

    /**
     * pega os dados das categorias pra mandar para a renderização
     *
     * @return void
     */
    protected function evtAfterGetScopedData() {}

    /**
     * executado depois de salvar os dados principais
     * @param resultado do salvamento principal $result
     */
    protected function evtAfterMainSave($saveResult) {}

    /**
     * ao despachar o controller
     * @param  ZendMvcMvcEvent $e evento zend
     * @return return          null
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $controllerName = $this->params ( '__CONTROLLER__', 'index');
        $actionName     = $this->params ( 'action', 'index');
        $e->getViewModel()->setVariables(
            array('controllerName'=> $controllerName,
                'actionName' => $actionName)
        );

        return parent::onDispatch($e);
    }
    //======================= END eventos públicos =======================
    //========================= utils do escopo =========================
    protected function getTemplateFileFromAction($actionName)
    {

        foreach ($this->filesActions as $templateFile => $actions) {
            if (in_array($actionName,$actions)) {
                return $templateFile;
            }
        }

        return null;
    }

    protected function getTemplatePath($templateFile)
    {
        $moduleName = $this->getMainModuleName();

        $moduleFolderName = $moduleName;

        $realFile = $moduleFolderName.'/'.$this->getUrlClassName().'/'.$this->params('action').'.phtml';

        //testa se existe a view propriamente
        if (file_exists(Facade::getPublicPath().'/../module/'.$moduleName.'/view/'.$realFile)) {
            return $realFile;

        //testa se existe um arquivo genérico para o módulo
        } elseif (file_exists(Facade::getPublicPath().'/../module/'.$moduleName.'/view/'.$moduleFolderName.'/default/'.$templateFile)) {
            return $moduleFolderName.'/default/'.$templateFile;

        //caso os anteriores falharem, utiliza o padrão que está em ack-core
        } else {
            return 'ack-core/default/'.$templateFile;
        }

    }
    //======================= END utils do escopo =======================

}
