<script type="text/javascript">
	$(document).ready(function() {
		$("#back-button").click ( function() { $("#dialogImputationDelete").dialog("close");  } );
	});
</script>

<?php if($numberOfImputationsToDelete > 0):?>
	<p>
		<?php echo __('You are about to delete')." <b>".$numberOfImputationsToDelete."</b> ".__('imputation(s)').".";?>
	</p>
	
	<p>
		<?php echo __('The selected use(s) will not appear in the statistics and in the history anymore : they will be completely removed from the database').".";?>
	</p>
	
	<p>
		<?php echo __('This action does')."<b>"." ".__('not cancel')."</b>"." ".__('an imputation, it only removes it')." : ".__('the user will not be paid off and his account will not be modified').".";?>
	</p>
	
	<p style="font-weight: bold";>
		<?php echo __('This action is irreversible').".";?>
	</p>
	
	<span class="deletion-button" style="float:right; margin-top:18px;">
		<?php echo link_to(__('Confirm'), 'use/deleteImputation?id='.$imputationsToDelete, array('method' => 'delete')) ?>
	</span>

<?php else:?>
	<p><?php echo __('No imputations selected')?></p>
<?php endif;?>

<input type="button" id="back-button" value=<?php echo __('Back')?>></input>