


<script type="text/javascript">
	$(document).ready(function() {
		$( "#dialog_new" ).dialog( { 
			width: 620,
			close: null,
			resizable: false,
			modal: true , 
		} );
	});
</script>

<div id="dialog_new" title="<?php echo __('Restart is necessary')?>">
	
	<form method="post" action="<?php echo url_for('@homepage')?>">
		<?php if(!$error_already_installed):?>
		
			<p><?php echo __('The plugin')?> <strong><?php echo($new_module_name)?></strong> <?php echo __('has been correctly added')?>.</p>
			<p><?php echo __('You have to re-init the application to take the change into account:')?></p>
			
		<?php else:?>
		
			<p><?php echo __('The plugin')?> <strong><?php echo($new_module_name)?></strong> <?php echo __('is already installed')?>.</p>
		
		<?php endif;?>
		
		<input type="submit" value="<?php echo __('Re-init the application')?>"></input>
	</form>
	
</div>