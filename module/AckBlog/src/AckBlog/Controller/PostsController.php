<?php
/**
 * gerenciamento PostsController
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
namespace AckBlog\Controller;
use AckMvc\Controller\AbstractTableRowController as Controller;
use Zend\View\Model\ViewModel;
/**
 * gerenciamento PostsController
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class PostsController extends Controller
{
    protected $config = array(
        'global' => array(
            'blacklist' => array(
                'id', 'ordem', 'status', 'visivel', 'tipo', 'conteudo'
            ),
            'plugins' => array(
                'metatags'
            ),

        ),
        'lista' => array(
            'whitelist' => array(
                'titulo', 'publicado', 'data'
            ),
        ),
    );

    protected $models = array('default'=>'\AckBlog\Model\Posts');

      /**
     * funçao para ser sobreescrita pelo usuário
     */
    protected function evtAfterGetScopedData()
    {
        if ($this->params("action") == "editar" || $this->params("action") == "incluir" ) {

            $config = $this->viewModel->config;

            $select = \AckCore\HtmlElements\Select::Factory($this->viewModel->config["row"]->vars["tipo"])->setPermission(2);
            $select->setOption(1,'HTML', ($config['row']->getTipo()->getBruteVal() == 1));
            $select->setOption(2,'Markdown', ($config['row']->getTipo()->getBruteVal() == 2));

            $config["toRenderCOL1"][1] = $select;

            $content = \AckCore\HtmlElements\TextEditor::Factory($this->viewModel->config["row"]->vars["conteudo"]);

            if ($config['row']->getTipo()->getBruteVal() == 2) {
                $content->setMarkdown(true);
            }

            $content->setPermission(2);

            $config["toRenderCOL1"][2] = $content;

            $this->viewModel->config = $config;
        }
    }

    public function visualizarAction()
    {
        $id = $this->params('id');
        $data = array();

        $entity = $this->getModelInstance()
            ->toObject()
            ->onlyAvailable()
            ->getOne(array('id'=>$id));

        $data['row'] = $entity;

        if ($entity->getTipo()->getBruteVal() == \AckBlog\Model\Posts::TYPE_MARKDOWN) {
            $data['isMarkdown'] = true;
        } else {
            $data['isMarkdown'] = false;
        }

        $this->viewModel->setVariables($data);

        return $this->viewModel;
    }

    public function jsonAction()
    {
        $id = $this->params('id');
        $data = array();

        $entity = $this->getModelInstance()
            ->toObject()
            ->onlyAvailable()
            ->getOne(array('id'=>(int) $id));

        $data['row'] = $entity;

        if ($entity->getTipo()->getBruteVal() == \AckBlog\Model\Posts::TYPE_MARKDOWN) {
            $data['isMarkdown'] = true;
        } else {
            $data['isMarkdown'] = false;
        }

        echo json_encode($data, true);

        return $this->getResponse();
    }
}
