<?php
namespace AckCore\HtmlElements;
class LanguageSelector extends ElementAbstract
{
    public function __construct()
    {
        $this->name = "languageSelector";
        $this->permission = 2;
        $this->title = "Idioma";
    }

    public function defaultLayout()
    {
        $container = \AckCore\Facade::getInstance();
        $currRow = $container->getCurrentRow();
        //testa se a linha tem alguma coluna com outro idioma caso não,não mostra o menu
        $hasLang = false;
        foreach ($currRow->getCols() as $col) {
                $suffix = null;
                $suffix = \AckCore\Utils\String::hasLangSuffix($col->getColName());
                if ($suffix && $suffix != "pt") {
                    if (\AckCore\Model\Languages::hasLanguageEnabled($suffix) ) {
                        $hasLang = true;
                        break;
                    }
                }
        }

        if($hasLang) :
        ?>
                <fieldset class="menuIdiomas">
                <div class="legend">
                    <em><?php echo $this->getTitle() ?></em>
                    <?php $this->renderDefaultAjuda() ?>
                </div>

                <div class="menuIdiomas-innner">
                <span><span></span><span></span></span>
                <div>
                            <?php foreach(\AckCore\View\Helper\Languages::getIncludingUnavailableObjects() as $lang) : ?>
                                   <button name="<?= ($lang->getAbreviatura()->getVal()) ?>" title="<?= $lang->getNome()->getVal() ?> - [<?= strtoupper($lang->getAbreviatura()->getVal()) ?>]" class="<?= $currRow->hasLangContent($lang->getAbreviatura()->getVal()) ? "completo" : ""?> <?= ($lang->getAbreviatura()->getVal() == "pt") ? "	onView" : "" ?>"><em><?= $lang->getNome()->getVal() ?> - [<?= strtoupper($lang->getAbreviatura()->getVal()) ?>]</em></button>
                            <?php endforeach; ?>
                            </div>
                       <span><span></span><span></span></span>
                     </div>
               </fieldset><!-- END menuIdiomas -->
        <?php
        endif;
    }

}
