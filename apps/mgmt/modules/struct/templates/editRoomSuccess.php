<h1><?php echo __('Edit Room')?></h1>

<?php include_partial('roomForm', array('form' => $form)) ?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
	});
</script>

<div id="dialog" title="<?php echo __("Room deletion")?>" style="display:none">
	
	<?php if(sizeof($associatedComputers)):?>
		<p><?php echo __("Caution, the following computers won't be associated to any room :") ?></p>

		<ul>
			<?php foreach ($associatedComputers as $associatedComputer): ?>
				<li><p><?php echo $associatedComputer->getName() ?></p></li>
			<?php endforeach;?>
		</ul>
		
	<?php else: ?>
		<p><?php echo __("Caution, this action will delete completely the room.") ?></p>
		<br />
	<?php endif ?>
	
	<input type="button" id="back-button" value=<?php echo __('Back')?>></input>
	
	<span class="deletion-button" style="float:right; margin-top: 18px;">
		<?php echo link_to(__('Confirm'), 'struct/deleteRoom?id='.$form->getObject()->getId(), array('method' => 'delete')) ?>
	</span>

</div>