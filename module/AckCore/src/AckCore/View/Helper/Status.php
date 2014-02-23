<?php

    class Reuse_Ack_View_Helper_Show_Status
    {
    	public static function run(&$row,$permissionLevel)
    	{
?>
			   <fieldset class="radioGrup checkStatus">
               <legend><em>Status</em><button id="p_41" class="ajuda icone">(?)</button></legend>

                  <label><input type="radio" value="1" <?php if ($permissionLevel=="2") { ?>name=<?= $row->getStatus()->getColumnName() ?><?php } else { ?>disabled="disabled"<?php } ?> <?php if ($row->getStatus()->getBruteVal()) { ?> checked="checked"<?php } ?>><span>Sim</span></label>
                <label><input type="radio" value="0" <?php if ($permissionLevel=="2") { ?>name=<?= $row->getStatus()->getColumnName() ?><?php } else { ?>disabled="disabled"<?php } ?> <?php if (!$row->getStatus()->getBruteVal()) { ?> checked="checked"<?php } ?>><span>Não</span></label>
               </fieldset><!-- END radioGrup -->

<?php
    	}
    }
?>

