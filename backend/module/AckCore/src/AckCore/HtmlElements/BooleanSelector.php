<?php
namespace AckCore\HtmlElements;
class BooleanSelector extends ElementAbstract
{
	public function defaultLayout()
	{
		?>
           <fieldset class="radioGrup check<?php echo $this->getTitle() ?>">
    	               <legend><em><?php echo $this->getTitle() ?></em></legend>

    	                <label><input <?php echo $this->composeName() ?> type="radio" value="1" <?php echo ($this->getValue()) ? 'checked="checked"' : ''  ?> >
    	                	<span>Sim</span>
    	                </label>

    	            	<label><input <?php echo $this->composeName() ?> type="radio" value="0" <?php echo (!$this->getValue()) ? 'checked="checked"' : ''  ?> >
    	            		<span>Não</span>
    	            	</label>
           </fieldset><!-- END radioGrup -->
		<?php
	}
}
