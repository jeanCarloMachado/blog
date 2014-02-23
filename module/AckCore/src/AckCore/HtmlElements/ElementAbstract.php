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
use AckCore\ServiceLocator\Traits\ServiceLocatorAware;
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

    protected $name = "";
    protected $permission = '+rw';
    protected $value = null;
    //atributo depreciado
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
        // else {
        //         //$permission = \AckUsers\Model\Permissions::getPermissionFromColumnObject($variable,\AckCore\Facade::getCurrentUser());

        //         $permissionLvl = 0;

        //         if (is_object($permission)) {
        //                 $permissionLvl = $permission->getNivel()->getBruteVal();
        //         } else {
        //                 $evt = new \AckCore\Event;
        //                 $evt->setType(\AckCore\Event::TYPE_NOT_PERMITED_ACCESS);
        //                 \AckCore\EventManager::getInstance()->notify($evt);
        //         }

        //         $instance->setPermission($permissionLvl);
        // }

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

                if(empty($this->$required)) throw new \Exception("O elemento $elementURI não dispõe do campo obrigatório { $required } preenchido");
        }

        foreach ($this->wants as $wanted) {
                if(empty($this->$wanted)) trigger_error("O elemento $elementURI não dispõe do campo que gostaria { $wanted }",E_USER_NOTICE);
        }

        if($this->permission < self::LESSER_SHOWABLE_PERMISSION) return null;

        if($this->url) : ?>
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
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    public function getValueDefault()
    {
        return $this->valueDefault;
    }

    public function setValueDefault($valueDefault)
    {
        $this->valueDefault = $valueDefault;

        return $this;
    }

    public function getHelperId()
    {
        return $this->helperId;
    }

    public function setHelperId($helperId)
    {

        $this->helperId = $helperId;

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

    public function getBuilding()
    {
        return $this->building;
    }

    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    public function getUrl()
    {
            return $this->url;
    }

    public function setUrl($url)
    {
            $this->url = $url;

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

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

      public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getParentClasses()
    {
        return $this->parentClasses;
    }

    public function setParentClasses($parentClasses)
    {
        $this->parentClasses = $parentClasses;

        return $this;
    }

    public function composeId()
    {
        if($this->id);
        echo 'id="'.$this->id.'"';

        return;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
