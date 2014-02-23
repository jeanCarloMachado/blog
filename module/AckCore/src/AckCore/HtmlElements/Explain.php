<?php
namespace AckCore\HtmlElements;
class Explain extends ElementAbstract
{
        const DEFAULT_LAYOUT = 1;
        const LAYOUT_MAIN_MENU = 2;
        //explanações da página de ajuda
        const LAYOUT_HELP = 3;

        //###################################################################################
        //################################# valores default das varíáveis###########################################
        //###################################################################################
        const DEFAULT_TITLE = "";
        const DEFAULT_NAME = "Nome";
        const DEFAULT_VALUE = "";
        //###################################################################################
        //################################# END valores default das varíáveis########################################
        //###################################################################################
        protected $layoutType = 1;
        protected $titleStatus = 1;
        //###################################################################################
        //################################# variávies default para o usuário setar###########################################
        //###################################################################################
        protected $userDefaultTitle = "";
        protected $userDefaultValue = "";
        //###################################################################################
        //################################# END variávies default para o usuário setar########################################
        //###################################################################################
        protected $stripContentTags = false;

        public function __construct($layoutType = 1)
        {
                $this->layoutType = $layoutType;

                $this->permission = 2;

                $this->name = self::DEFAULT_NAME;
                $this->title = self::DEFAULT_TITLE;
                $this->value = self::DEFAULT_VALUE;
                parent::__construct();
        }

        public function defaultLayout()
        {
            if($this->layoutType == self::DEFAULT_LAYOUT) :
?>

            <div class="head">
                <?php if($this->titleStatus) : ?>
                <button class="btnAB"><em><?php echo $this->getTitle() ?></em></button>
                <?php endif; ?>

                <?php if ($this->getValue()) { ?>
                <div class="text-box">
                    <p><?php echo $this->getValue() ?></p>
                </div>
                <?php } ?>
            </div><!-- END head -->

        <?php elseif($this->layoutType == self::LAYOUT_HELP) : ?>

            <div class="box">
                <?php if($this->titleStatus) : ?>
                <div class="box-head">
                    <h3 class="head-btn"><span><?php echo $this->getTitle() ?></span></h3>

                    <div class="head-desc"></div>
                </div><!-- END head -->
                <?php endif; ?>

                <div class="box-body">
                    <div class="text-box collapse">
                         <p><?php echo $this->getValue() ?></p>
                    </div>
                </div>
                <!-- end box-body -->
            </div>
            <!-- end box -->
<?php
                else :
?>
        <div id="descricaoPagina">
            <?php if($this->titleStatus) : ?>
            <h2><?php echo $this->getTitle() ?></h2>
            <?php endif; ?>

            <?php if ($this->getValue()) { ?>
            <div class="text-box">
                <p><?php echo $this->getValue() ?></p>
            </div>
            <?php }?>
        </div>

<?php
endif;
        }

        public function getLayoutType()
        {
                return $this->layoutType;
        }

        public function setLayoutType($layoutType)
        {
                $this->layoutType = $layoutType;

                return $this;
        }

        public function disableTitle()
        {
                $this->titleStatus = 0;

                return $this;
        }

    //###################################################################################
    //################################# função de acesso direto as variáveis (sem utilizar layout ) ###########################################
    //###################################################################################
        public function getTitle()
        {
            $result = null;
            $this->title = parent::getTitle();

            if(!empty($this->userDefaultTitle) && $this->title == self::DEFAULT_TITLE) $result = $this->userDefaultTitle;

            $result = $this->title;
            if($this->getStripContentTags()) $result = strip_tags($result);

            return $result;
        }
        public function getValue()
        {
            $result = null;
            $this->value = parent::getValue();

            if(!empty($this->userDefaultValue) && $this->value == self::DEFAULT_VALUE) $result = $this->userDefaultValue;

            $result = $this->value;
            if($this->getStripContentTags()) $result = strip_tags($result);

            return $result;
        }
    //###################################################################################
    //################################# END função de acesso direto as variáveis (sem utilizar layout ) ########################################
    //###################################################################################
      public function getUserDefaultTitle()
      {
          return $this->userDefaultTitle;
      }

      public function setUserDefaultTitle($userDefaultTitle)
      {
          $this->userDefaultTitle = $userDefaultTitle;

          return $this;
      }

      public function getUserDefaultValue()
      {
          return $this->userDefaultValue;
      }

      public function setUserDefaultValue($userDefaultValue)
      {
          $this->userDefaultValue = $userDefaultValue;

          return $this;
      }

    public function enableStripTags()
    {
        $this->stripContentTags = true;

        return $this;
    }

    public function disableStripTags()
    {
        $this->stripContentTags = false;

        return $this;
    }

    public function getStripContentTags()
    {
        return $this->stripContentTags;
    }

    public function setStripContentTags($stripContentTags)
    {
        $this->stripContentTags = $stripContentTags;

        return $this;
    }
}

        // public function getTitle()
        // {
        //         $ackContent = $this->getAckContent();

        //         if (is_object($ackContent)) {

        //                 $this->title = $this->getAckContent()->getTitulo()->getBruteVal();

        //                 // assert(0,"verificar se aqui é o melhor lugar para esta funcionalidade");
        //                 // //trata conteúdos com o início Adicionar/Editar
        //                 // if (substr($this->title, 0,16) == "Adicionar/Editar") {
        //                 //         $action = \AckCore\Facade::getUrlAction();
        //                 //         if ($action == "editar") {
        //                 //                 $this->title = str_replace("Adicionar", "", $this->title);
        //                 //         } elseif ($action == "incluir") {
        //                 //                 $this->title = str_replace("Editar", "", $this->title);
        //                 //         }

        //                 //         $this->title = str_replace("/", "", $this->title);
        //                 // } elseif (substr($this->title, 0,17) == "Visualizar/Editar") {
        //                 //         $action = \AckCore\Facade::getUrlAction();
        //                 //         if ($action == "editar") {
        //                 //                 $this->title = str_replace("Visualizar", "", $this->title);
        //                 //         } elseif ($action == "incluir") {
        //                 //                 $this->title = str_replace("Editar", "", $this->title);
        //                 //         }

        //                 //         $this->title = str_replace("/", "", $this->title);
        //                 // }
        //         }

        //         if($this->building)
        //                 return $this->getIdentifier()." - ". $this->title;

        //         if($this->enableStripTags)
        //                 return strip_tags($this->title,$this->stripTagsExceptions);

        //         return $this->title;
        // }

        // public function getValue()
        // {
        //         $this->value = parent::getValue();
        //         //remove caracteres lixo
        //         $this->value = str_replace("<p>&nbsp;</p>","",$this->value);
        //         $this->value = str_replace("<p><strong>&nbsp;</strong></p>","",$this->value);
        //         $this->value = str_replace("&gt;","",$this->value);
        //         return $this->value;
        // }
