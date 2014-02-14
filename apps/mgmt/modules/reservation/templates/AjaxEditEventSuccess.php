
<div id="tabs">

    <h1><?php if ($event->getDesignation()) echo __("Edit a event"); else echo __("Add a event"); echo " : ".$reservation->getDesignation(); ?></h1>

    <div class='panel'>

        <form id="formulaire" action="<?php echo url_for('reservation/validateevent'); ?>" method="post">
            <input type='hidden' name='event_id' value='<?php if ($event) echo $event[0]->getId(); ?>' />

            <table class="formTable">
            <tbody>
                <tr>
                    <th><?php echo __('Title') ?></th>
                    <td><input type='text' name='event_designation' value='<?php if ($event) echo $event[0]->getDesignation(); ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Description') ?></th>
                    <td><textarea name='event_description' rows='4' cols='30'><?php if ($event) echo $event[0]->getDescription(); ?></textarea></td>
                </tr>

            </tbody>
            </table>

            <div class="rightAlignement">
                <input type="button" id="Save-Button" value="<?php echo __('Save') ?>" />
            </div>
            <input type="button" id="Back-Button" value="<?php echo __('Back');?>">
            <?php if ($event[0]->getDesignation()): ?>
                <span class="deletion-button">
                    <input type="button" id="Detele-Button" value="<?php echo __('Delete')."..."; ?>">
                </span>
            <?php endif; ?>

        </form>

    </div>

</div>

<script>

$('#Detele-Button').click(function(){

	$("#event_detail").dialog('close');

	$("#event_detail").load(
			'<?php echo url_for('reservation/AjaxDeleteEvent') ?>',
	        { id: <?php echo $reservation->getId(); ?>, event_id: '<?php echo $event[0]->getId(); ?>' },
	        function(data) {

				if (!data) return false;

				$("#event_detail").dialog({
					width: 700,
					close: true,
					resizable: false,
					modal: true,
					draggable: false
				});
			});		
	
});


$('#Save-Button').click(function(){

	$("#event_detail").dialog('close');

	form_query = $('#formulaire').serialize();
	form_query = form_query + "&id=<?php echo $reservation->getId(); ?>";
	
	$("#event_detail").load(
			'<?php echo url_for('reservation/AjaxSaveEvent') ?>',
	        form_query,
	        function(data) {

				if (!data) return false;

				$("#event_detail").dialog({
					width: 700,
					close: true,
					resizable: false,
					modal: true,
					draggable: false
				});
			});		
	
});

$('#Back-Button').click(function(){

	$("#event_detail").dialog('close');
        		
	$("#event_detail").load(
		'<?php echo url_for('reservation/AjaxDetailedReservation') ?>',
        { id: <?php echo $reservation->getId(); ?> },
        function(data) {

			if (!data) return false;

			$("#event_detail").dialog({
				width: 700,
				close: true,
				resizable: false,
				modal: true,
				draggable: false
			});
		});		
});


</script>