<h1><?php echo __('Edit Building')?></h1>

<?php include_partial('buildingForm', array('form' => $form)) ?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
	});
</script>

<div id="dialog" title="<?php echo __("Building deletion")?>" style="display:none">
	
	<?php if(sizeof($associatedRooms)):?>
		<p><?php echo __("Caution, the following rooms won't be associated to any building :") ?></p>

		<ul>
			<?php foreach ($associatedRooms as $associatedRoom): ?>
				<li><p><?php echo $associatedRoom->getDesignation() ?></p></li>
			<?php endforeach;?>
		</ul>
		
	<?php else: ?>
		<p><?php echo __("Caution, this action will delete completely the building.") ?></p>
		<br />
	<?php endif ?>
	
	<input type="button" id="back-button" value=<?php echo __('Back')?>></input>
	
	<span class="deletion-button" style="float:right; margin-top:18px;">
		<?php echo link_to(__('Confirm'), 'struct/deleteBuilding?id='.$form->getObject()->getId().'&address='.$form->getObject()->getAddressId(), array('method' => 'delete')) ?>
	</span>

</div>