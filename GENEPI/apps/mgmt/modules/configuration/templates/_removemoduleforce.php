

<script type="text/javascript">
	$(document).ready(function() {
		$( "#dialog_delete" ).dialog( { 
			width: 620,
			close: false,
			resizable: false,
			modal: true , 
		} );
	});
</script>

<div id="dialog_delete" title="<?php echo __('Restart is necessary')?>">
	
	<form method="post" action="<?php echo url_for('@homepage')?>">
		<p><?php echo __('The plugin')?> <strong><?php echo($to_remove_module_name)?></strong> <?php echo __('has been correctly removed.')?></p>
		<p><?php echo __('You have to re-init the application to take the change into account:')?></p>
		<input type="submit" value="<?php echo __('Re-init the application')?>"></input>
	</form>
	
</div>