<?php
/**
 * controller de textos
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
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckContent\Controller;
use \AckMvc\Controller\TableRowAutomatorAbstract;
class TextosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckContent\Model\Contents");
    protected $title = "Ajuda";
    protected $config = array(
                "global"=>array(
                    "disableLoadMore"=>true,
                    "disableAutoParentFull" => true,
                    "disableSuperiorListMenu" => true,
                    "blacklistHelpIdentifiers" => array("mainDescription",),
                    "disableSave" => true,
                    )
                );

    public function indexAction()
    {
        $texts = \AckContent\Model\ContentControllers::getContentsFromControllerStr(\AckCore\Facade::getFullControllerName(),"index");
        parent::indexAction();
        $this->viewModel->setTemplate($this->getDefaultViewFolder()."/index.phtml");
        $variables = $this->viewModel->getVariables();
        $variables["rows"] = ($texts);
        $this->viewModel->setVariables($variables);

        return $this->viewModel;
    }

    public function privacidadeAction()
    {
        parent::indexAction();
        $this->viewModel->setTemplate($this->getDefaultViewFolder()."/privacidade.phtml");
        $variables = $this->viewModel->getVariables();
        $variables["title"] = "Política de pricidade";
        $this->viewModel->setVariables($variables);

        return $this->viewModel;
    }

    public function termosAction()
    {
        parent::indexAction();
        $this->viewModel->setTemplate($this->getDefaultViewFolder()."/termos.phtml");
        $variables = $this->viewModel->getVariables();
        $variables["title"] = "Termos de uso";
        $this->viewModel->setVariables($variables);

        return $this->viewModel;
    }
}
