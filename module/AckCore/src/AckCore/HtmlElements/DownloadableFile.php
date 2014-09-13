<?php
namespace AckCore\HtmlElements;
class DownloadableFile extends ElementAbstract
{
	public function defaultLayout()
	{
		if($this->getValue()) :
		?>
			<fieldset>
				<div class="legend">
					<em><?php echo $this->getTitle() ?></em>
					<?php $this->renderLangDescription() ?>
					<?php $this->renderDefaultAjuda() ?>
				</div>
                <a href="/galeria/<?php echo $this->getValue(); ?>" class="botao" title="Baixar"><span><em>Baixar</em></span><var class="borda"></var></a>
			</fieldset>
		<?php
		endif;
	}

}
