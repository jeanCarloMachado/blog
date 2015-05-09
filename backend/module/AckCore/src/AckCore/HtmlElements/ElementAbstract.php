<?php
/**
 * essa classe é a base para todo os HTMLELEMENTS
 * proporciona serviços e utilidades para que os elementos
 * consigam trabalhar o mais automaticamente possivel
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
namespace AckCore\HtmlElements;

use AckCore\HtmlEncapsulated;
use \AckCore\Facade;
use AckCore\Stdlib\ServiceLocator\ServiceLocatorAware;
use AckCore\Stdlib\BaseGetterAndSetter;
/**
 * classe base para elementos html
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
abstract class ElementAbstract extends HtmlEncapsulated
{
    use ServiceLocatorAware;
    use BaseGetterAndSetter;

    protected $permission = '+rw';
    protected $value = null;
    protected $valueDefault = null;
    protected $title = "";
    protected $helperId;
    protected $ackContent = null;
    protected $classes = array();
    protected $url = null;
    protected $enableStripTags = 0;
    protected $stripTagsExceptions = "<a><i><u>";
    protected static $cache;
    protected $defaultValue = -1;
    protected $tags = array();

    protected $type = 'input';
    protected $parentClasses = '';
    protected $id;

    /**
     * valor default para
     * quando o conteúdo do ack não pode
     * ser encontrado
     */
    const DEFAULT_CANNOT_FIND_VALUE = -1;
    /**
     * caso este campo esteja preenchido o sistema ao invés de procurar pelo título dos elementos
     * outrossim ele mostrará o identificador do elemento o qual dese ver
     * preenchido em conteúdos para modificar seu respectivo conteúdo
     * @var boolean
     */
    protected $identifier = "";
    //nome dos atributos que serão requeridos para
    //a renderização do objeto
    protected $require = array("name");
    //nome dos atributos que o elemento gostaria de receber
    protected $wants = array();
    protected $building;

    const LESSER_SHOWABLE_PERMISSION = 1;
    const LESSER_EDITABLE_PERMISSION = 2;

    /**
     * função de starup das classes filhas (opcional)
     *
     * @return void não retorna nada
     */
    public function init()
    {
    }

    /**
     * função para ser sobreescrita pelas classes filhas
     *
     * @return void nao retorna nada mas mostra o html
     */
    public function defaultLayout()
    {
        throw new \Exception('Layout default não implementado.', 1);
    }

    /**
     * retorna uma instância
     *
     *  @return HtmlElement retorna uma instância nova
     */
    public static function getInstance()
    {
        $className = get_called_class();
        $instance = new $className();

        $instance->init();

        return $instance;
    }

    public static function Factory(\AckCore\Vars\Variable $variable=null,$title=null,$permission=null,$defaultValue="",$helperId=null)
    {
        if (empty($variable)) {
                throw new \Exception("Não deve-se usar o factory quando não for à partir de um elemento variable, quando deseja-se criar um elemento do zero deve-se utilizar o getInstance()");
        }

        $className = get_called_class();

        $instance = new $className();
        $instance->setName($variable->getColumnName());
        $instance->setValue($variable->getVal());

        if (!empty($title)) {
            $instance->setTitle($title);
        } else {
            $instance->setTitle($variable->getAlias());
        }

        if(!empty($title)) $instance->setTitle($title);
        else $instance->setTitle($variable->getAlias());

        if (isset($permission) && $permission != null) {
                $instance->setPermission($permission);
        } else {
                $instance->setPermission(3);
        }

        if(!empty($defaultValue)) $instance->setValueDefault($defaultValue);
        if(!empty($helperId)) $this->setHelperId($helperId);

        //pesquisa o status do módulo
        //caso este esteja em construção,
        //mostra então o identificador dos elementos e
        //não o seu título real
        $modelName = $variable->table;

        return $instance;
    }
    /**
     * renderiza a ajuda do elemento
     * @return [type] [description]
     */
    public function renderDefaultAjuda()
    {
        return;
        if($content != self::DEFAULT_CANNOT_FIND_VALUE  && $content->getTituloAjuda()->getBruteVal())  :
        ?>

                    <button class="ajuda" title="O que é isso?"><span>O que é isso?</span></button>
                    <div class="janelaAjuda right">
                        <span></span>
                        <div>
                            <div class="header">
                                <span><span>O que é isso?</span></span>
                                <button title="Fechar" class="icone fechar">(X)</button>
                            </div>
                            <div class="texto">
                                <h5><?php echo $content->getTituloAjuda()->getBruteVal(); ?></h5>
                                <p><?php echo $content->getConteudoAjuda()->getBruteVal(); ?></p>
                            </div>
                            <!-- END texto -->
                        </div>
                        <span></span>
                    </div>
        <?php
        endif;
    }
    /**
     * renderiza um htmlElement em seu respectivo html
     * @return [type] [description]
     */

    final public function render()
    {
        $elementURI = " de classe {".get_called_class()."} título {".$this->getTitle()."}";

        foreach ($this->require as $required) {

            $getterCall = 'get'.$required;
            $result = $this->$getterCall();

            if(empty($result)) {
                throw new \Exception("O elemento $elementURI não dispõe do campo obrigatório { $required } preenchido");
            }
        }

        if ($this->url) : ?>
        <a href="<?php echo $this->url ?>">
        <?php
        endif;
        $layout =  $this->getLayout();
        $this->$layout();
        if($this->url) : ?>
        </a>
        <?php
        endif;
    }

    protected function composeName()
    {
        $result = "";

        if($this->permission >= self::LESSER_EDITABLE_PERMISSION) $result = 'name="'.$this->name.'"';
        else $result = 'name=""   DISABLED="DISABLED" ';
        return $result;
    }
    
    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        $permission = is_string($permission) ? \AckCore\Permission::toNumber($permission) : $permission;
        $this->permission = $permission;

        return $this;
    }

    public function getValue()
    {
        if($this->enableStripTags && $this->value) return strip_tags($this->value,$this->stripTagsExceptions);

        return $this->value;
    }

    public function setValue($value)
    {

        $this->value = $value;

        return $this;
    }

    public function getTitle()
    {

        if($this->enableStripTags) return strip_tags($this->title,$this->stripTagsExceptions);

        return $this->title;
    }

    public function setTitle($title)
    {

        $this->title = $title;

        return $this;
    }

    public function getIdentifier($set = true)
    {

        if (empty($this->identifier)) {
                $identifier = $this->getName();

                if($set) $this->identifier = $identifier;

                return $identifier;
        }

        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function appendClass($value,$key = null)
    {
        if($key) $this->classes[$key] = $value;
        else $this->classes[] = $value;
        return $this;
    }

    protected function composeClasses()
    {

        $result = "";

        if(!empty($this->classes))
            foreach ($this->classes as $class) {
                    $result.=  $class." ";
            }

        return $result;
    }

    public function setAckContent($ackContent)
    {

        $this->ackContent = $ackContent;

        return $this;
    }

    public function enableStripTags()
    {
            $this->enableStripTags = 1;

            return $this;
    }

    public function disableStripTags()
    {
            $this->enableStripTags = 0;

            return $this;
    }

    public function getStripTagsExceptions()
    {
            return $this->stripTagsExceptions;
    }

    public function setStripTagsExceptions($stripTagsExceptions)
    {
            $this->stripTagsExceptions = $stripTagsExceptions;

            return $this;
    }

    public function renderLangDescription()
    {
            $name = explode("_",$this->getName());
            if(sizeof($name)  > 1) :

                    if(in_array(end($name), \AckCore\Facade::getLanguageSuffixes())) :
            ?>
                        <strong>[<?php echo \AckCore\Language\Language::getCorrespondentLanguageNameByAcronym(end($name)) ?> - <?php echo strtoupper(end($name)) ?>]</strong>
            <?php

            endif;

            endif;
    }

    public function composeTags()
    {
        if(!empty($this->tags))

        foreach ($this->tags as $key => $value) {
            echo "$key='",$value,"' ";
        }
    }

    public function appendTag($key,$value)
    {
        $this->tags[$key] = $value;

        return $this;
    }

    public function composeSelection($value=null)
    {
        if ($value == $this->getDefaultValue()) {
            echo "SELECTED='SELECTED'";
        }
    }

    public function composeId()
    {
        if($this->id);
        echo 'id="'.$this->id.'"';

        return;
    }

    public function getHeadScript()
    {
        return $this->getServiceLocator()->get('viewhelpermanager')->get('HeadScript');
    }

}
