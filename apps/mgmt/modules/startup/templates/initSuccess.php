<?php echo __('The application cannot be launched because of theses issues:')?>
<ul>
<?php foreach($status as $key => $error_msg):?>
	<?php if($key == 'conf'):?>
		<li><?php echo __('Please correct theses errors relatives to the configuration files :')?>
			<ul>
			<?php foreach($status['conf'] as $conf_err):?>
				<li><?php echo($conf_err)?></li>
			<?php endforeach;?>
			</ul>
		</li>
	<?php else:?>
		<li><?php echo($error_msg)?></li>
	<?php endif;?>
<?php endforeach;?>
</ul>