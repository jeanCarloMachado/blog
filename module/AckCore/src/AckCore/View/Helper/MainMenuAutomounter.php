<?php
/**
 *
 * (ESTA CLASSE ESTÁ DEPRECIADA, a nova versão se entrontra em AckContent)
 * classe que monta automaticamente o menu principal do ack
 *
 * PHP version 5
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
use AckCore\Permission;
use AckUsers\Model\UsuarioConfiguracoes;
class MainMenuAutomounter extends AbstractHelper
{
    protected $currentUser;
    protected $permissions;
    /**
     * este array gurada os nomes dos
     * controllers que já foram renderizados
     * a fim d eimpedir que eles reapareçam
     * no  menu
     * @var array
     */
    protected $blacklist = array();
    const DISABLE_BLACKLIST = true;
    const NOTICE_REPORT = 0;

    public function __invoke()
    {

        $this->currentUser = \AckCore\Facade::getCurrentUser();
        $this->permissions = new \AckUsers\Model\Permissions;

        $config = array();

        $modelUsuarioConfiguracoes = new UsuarioConfiguracoes;
        $where = array("usuario_id"=>$this->getCurrentUser()->getId()->getBruteVal());
        $configObject = $modelUsuarioConfiguracoes->toObject()->onlyAvailable()->getOne($where);
        $config = unserialize($configObject->getMainMenuCache()->getBruteVal());

        if (empty($config)) {
            $config = \AckCore\Facade::getInstance()->getMainMenuConfig();
            $this->prepareConfiguration($config);
            $modelUsuarioConfiguracoes->updateOrCreate(array("main_menu_cache"=>serialize($config),"usuario_id"=>$this->getCurrentUser()->getId()->getBruteVal()),array("usuario_id"=>$this->getCurrentUser()->getId()->getBruteVal()));
        }

        $this->mountList($config);
    }

    /**
     * monta a lista de locais do ack
     * @param  [type] $config [description]
     * @return [type] [description]
     */
    public function mountList($config)
    {
        $totalItens = count($config);
        $counter = 0;

        foreach($config as $key => $menuEntry) :
            $totalRenderedOnCurrentLevel = 0;

        ?>
            <li><a  <?php echo (isset($menuEntry["itens"]) && !empty($menuEntry["itens"])) ? 'class="subsub"' : '' ?> href="<?php echo $menuEntry['url'] ?>" title="<?php echo $menuEntry['title'] ?>" <?php  echo (isset($menuEntry["blank"])) ? 'target="_blank"' : ''; ?>><?php echo $menuEntry['title'] ?></a>

                <?php
                    $totalRenderedOnCurrentLevel++;
                    if(isset($menuEntry["itens"]) && !empty($menuEntry["itens"])) :
                ?>
                    <ul>
                        <li class="topo"></li>
                <?php
                        $this->mountList($menuEntry["itens"]);
                ?>
                        <li class="fundo"></li>
                    </ul>
                <?php
                    endif;
                ?>
            </li>

            <?php if($counter < ($totalItens - 1)) : ?>
            <li class="separador"></li>
            <?php endif; ?>

        <?php
                $counter++;

            endforeach;
    }

    public function &prepareConfiguration(&$config)
    {
        $logger = \AckCore\Facade::getLogWriter();

        foreach ($config as $key => $menuEntry) {

            $cCoreName = \AckMvc\Controller\Utils::getControllerCoreName($menuEntry['controller']);
            if ($this->isBlacklisted($cCoreName)) {
                $logger->info("O controller $cCoreName foi removido do menu para o usuário por estar blacklistado.");
                unset($config[$key]);
                continue;
            }

            if(!self::DISABLE_BLACKLIST) $this->appendBlacklistElement($cCoreName);

         /**
          * testa a integridade do array
          */

            if (empty($menuEntry["controller"])) {
                if (self::NOTICE_REPORT) trigger_error("o nome do controlador precisa ser informado: ".$menuEntry["controller"],E_USER_NOTICE);

                unset($config[$key]);
                continue;
            }

            if (!class_exists($menuEntry["controller"])) {
                if (self::NOTICE_REPORT) trigger_error("não foi possível encontrar o controlador passado:". $menuEntry["controller"],E_USER_NOTICE);
                unset($config[$key]);
                continue;
            }

            try {
            //instancia o controlador
            $controller =  new $menuEntry["controller"];
            } catch (\Exception $e) {
                unset($config[$key]);
                continue;
            }

            //verifica se existe permissão para este módulo
            $permission = null;
            if (!isset($menuEntry["permission"])) {

                $modelName = $controller->getModelName();
                $moduloId = (isset($menuEntry["moduleId"])) ? $menuEntry["moduleId"] : $modelName::moduleId;

                $wherePermission = array("usuario" => $this->currentUser->getId()->getBruteVal(), "modulo" => $moduloId);

                $permission =  $this->permissions->get($wherePermission);
                $permission = reset($permission);
                $permission = $permission["nivel"];

            } else $permission = $menuEntry["permission"];

                if ($permission < Permission::toNumber("r")) {
                    if (self::NOTICE_REPORT) trigger_error("usuário sem permissão para acessar o controlador: ".$menuEntry["controller"],E_USER_NOTICE);
                    unset($config[$key]);
                    continue;
                }
                //pega as variáveis necessárias
                $config[$key]['url'] = (isset($menuEntry["url"])) ? $menuEntry["url"] : "/ack/".$controller->getUrlClassName();
                if (!$menuEntry["disablePluralizer"]) {
                    $pluralizer = new \AckCore\View\Helper\Pluralizer;
                    if (isset($menuEntry["title"])) {
                        $config[$key]['title'] = $menuEntry["title"];
                    } elseif (substr($controller->getTitle(), -1) == 's') {
                        $config[$key]['title'] = $controller->getTitle();
                    } else {
                        $config[$key]['title'] = $pluralizer($controller->getTitle());
                    }
                } else {
                    $config[$key]['title'] =  (isset($menuEntry["title"])) ? $menuEntry["title"] : $controller->getTitle();
                }

                if(isset($menuEntry["itens"]) && !empty($menuEntry["itens"]))  $this->prepareConfiguration($config[$key]["itens"]);
        }

        return $this;
    }

    public function getBlacklist()
    {
        return $this->blacklist;
    }

    public function setBlacklist($blacklist)
    {
        $this->blacklist = $blacklist;

        return $this;
    }

    public function appendBlacklistElement($name)
    {
        $this->blacklist[] = $name;
    }

    public function isBlacklisted($name)
    {
        if(in_array($name, $this->blacklist)) return true;

        return false;
    }

    //###################################################################################
    //################################# getters & setters###########################################
    //###################################################################################
    public function &getCurrentUser()
    {
        return $this->currentUser;
    }

    public function setCurrentUser(&$currentUser)
    {
        $this->currentUser = &$currentUser;

        return $this;
    }
    //###################################################################################
    //################################# END getters & setters########################################
    //###################################################################################
}
