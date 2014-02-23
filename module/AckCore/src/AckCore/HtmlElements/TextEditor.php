<?php
namespace AckCore\HtmlElements;
class TextEditor extends ElementAbstract
{
	public function defaultLayout()
	{
		?>
			<fieldset class="editorTexto textarea683x110">
            	<div class="legend">
                            <em><?php echo $this->getTitle() ?></em>
                            <?php $this->renderLangDescription() ?>
                            <?php $this->renderDefaultAjuda() ?>
               </div>

               <textarea  <?php echo $this->composeName() ?> rows="5" cols="50"><?php echo $this->getValue() ?></textarea>
            </fieldset>
		<?php
	}
}
