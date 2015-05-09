<?php
namespace AckCore\HtmlElements;
class BooleanSelect extends ElementAbstract
{
	public function defaultLayout()
	{
	?>
		<fieldset>
			<div class="legend">
				<em><?php echo $this->getTitle() ?></em>
				<?php $this->renderLangDescription() ?>
				<?php $this->renderDefaultAjuda() ?>
			</div>
			<div class="select">
				<select <?php echo $this->composeName() ?>>
					<option <?php echo ($this->getValue()) ?  'selected="SELECTED"' : "" ?> value="1">Sim</option>
					<option <?php echo (!$this->getValue()) ?  'selected="SELECTED"' : "" ?> value="0">Não</option>
				</select>
			</div>
		</fieldset>
	<?php
	}

}
