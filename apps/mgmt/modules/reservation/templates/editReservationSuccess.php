<?php

?>


    <div class='panel'>

        <form action="<?php echo url_for('reservation/validate'); ?>" method="post" id="formulaire">
            <input type='hidden' name='id' value='<?php if ($reservation) echo $reservation->getId(); ?>' />
            <input type='hidden' name='ajax' value=1>
            <input type='hidden' name='startdate' value='<?php echo $startdate;?>'>
            <input type='hidden' name='stopdate' value='<?php echo $stopdate;?>'>

            <table class="formTable">
            <tbody>
                <tr>
                    <th><?php echo __('Title') ?></th>
                    <td><input type='text' name='designation' value='<?php if ($reservation) echo $reservation->getDesignation(); ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Description') ?></th>
                    <td><textarea name='description' rows='4' cols='30'><?php if ($reservation) echo $reservation->getDescription(); ?></textarea></td>
                </tr>

                <tr>
                    <th><?php echo __('Public') ?></th>
                    <td><input type='checkbox' name='public' value='1' <?php if ($reservation && $reservation->getPublic()) echo "checked='checked'"; ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Public title') ?></th>
                    <td><input type='text' name='public_designation' value='<?php if ($reservation) echo $reservation->getPublicDesignation(); ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Public description') ?></th>
                    <td><textarea name='public_description' rows='4' cols='30'><?php if ($reservation) echo $reservation->getPublicDescription(); ?></textarea></td>
                </tr>
            </tbody>
            </table>

            <div class="rightAlignement">
                <input type="button" id="sub" value="<?php echo __('Save') ?>" />
            </div>
            <input type="button" value=<?php echo __('Close')?> onclick="$('#event_detail').dialog('close');">
            <?php if ($reservation): ?>
            <input type="button" value="<?php echo __('Back')?>" id="Back-Button">
                <span class="deletion-button" onclick="reservation_deletion();">
                    <input type="button" value="<?php echo __('Delete')."..."?>"></input>
                </span>
            <?php endif; ?>

        </form>

    </div>

	<script>

	function reservation_deletion()
	{
		if ( confirm('<?php echo __("Caution, this reservation will be deleted.") ?>') )
		{
			query= "id=<?php if ( $reservation) echo $reservation->getId(); ?>&ajax=1";
			
			$("#event_detail").dialog('close');
			
			$("#event_detail").load(
		            '<?php echo url_for('reservation/delete') ?>',
		            query,
		            function(data) {

		            	$('#calendar').fullCalendar('refetchEvents');
		            	
		                if (!data)
		                    return false;

		                $("#event_detail").dialog({
		                    width: 700,
		                    close: true,
		                    resizable: false,
		                    modal: true,
		                    draggable: false
		                });
		            }
		        );		
		}
	}
	
	$('#sub').click(function(){
		
		form_query = $('#formulaire').serialize();

		$("#event_detail").dialog('close');
		
		$("#event_detail").load(
	            '<?php echo url_for('reservation/validate') ?>',
	            form_query,
	            function(data) {

	            	$('#calendar').fullCalendar('refetchEvents');
	            	
	                if (!data)
	                    return false;

	                $("#event_detail").dialog({
	                    width: 700,
	                    close: true,
	                    resizable: false,
	                    modal: true,
	                    draggable: false
	                });
	            }
	        );		
	});

	<?php if ($reservation): ?>
	$('#Back-Button').click(function(){

		$("#event_detail").dialog('close');
		
		$("#event_detail").load(
	            '<?php echo url_for('reservation/AjaxDetailedReservation') ?>',
	            { id: '<?php echo $reservation->getId(); ?>' },
	            function(data) {

	                if (!data)
	                    return false;

	                $("#event_detail").dialog({
	                    width: 700,
	                    close: true,
	                    resizable: false,
	                    modal: true,
	                    draggable: false
	                });
	            }
	        );		
		
	});
	<?php endif; ?>

	</script>

