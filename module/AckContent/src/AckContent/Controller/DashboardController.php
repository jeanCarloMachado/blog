<?php
namespace AckContent\Controller;
class DashboardController extends \AckMvc\Controller\TableRowAutomatorAbstract
{
    /**
     * [$models description]
     * @var array
     */
    protected $models = array("default"=>"\AckCore\Model\Systems");
    const DEFAULT_SYSTEM_ID = 1;
    protected $title = "Página Inicial";
    /**
     * @author j34nc4rl0@gmail.com
     * configurações do controlador do ack
     * é dividido por sessões que repesentam as actions do sistema, sendo que todas as informações
     * nessas sessões serão enviados para a action em questão e poderão ser acessadas diretamente,
     * a sessão "global" é a excessão, esta enviará o seu conteúdo para todas as actions
     *
     *
     * as opções disponíveis para as sessões são:
     * @var  boolen disableLoadMore desabilita o carregar mais para páginas index
     * @var  boolean disableAutoParentFull ???
     * @var  boolean disableSuperiorListMenu desabilita o menu superior com os botões de adicionar e remover elementos
     *
     * Nota: esta documentação pode não refletir a relidade da última versão da biblioteca,
     * sendo possível haver novas opções de configuração ainda não documentadas
     */
    protected $config = array(
        "global"=>array(
                "disableLoadMore"=>true,
                "disableAutoParentFull" => true,
                "disableSuperiorListMenu" => true,
                "disableBackButtons"=>true,
                "disableTitlePluralizer" => true,
            )
    );
}
