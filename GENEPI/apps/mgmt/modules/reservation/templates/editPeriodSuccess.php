<?php if ( $error != "" ): ?>
<div class=error_list><li><?php echo __($error); ?></li></div>
<?php endif;?>
    <fieldset>
        <legend><?php echo __("Computers")?></legend>
        <table id="allReservationComutersTab" class="largeTable">
            <thead>
                <tr class="sortableTable">
                    <th><?php echo __('Computer')?></th>
                    <th><?php echo __('From')?></th>
                    <th><?php echo __('To')?></th>
                    <th class='greyCell' style='width:120px;'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($computer_reservations as $k => $computer_reservation): ?>
                    <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                        <td><?php echo $computer_reservation->getComputer()->getName(); ?></td>
                        <td><?php echo date_format(new DateTime($computer_reservation->getStartDate()), __('m/d/Y').' H:i'); ?></td>
                        <td><?php echo date_format(new DateTime($computer_reservation->getEndDate()), __('m/d/Y').' H:i'); ?></td>
                        <td align='center'><a class='deletecomputer' href='' onclick='SupprComputer(<?php echo $computer_reservation->getId(); ?>); return false;'><?php echo __('Delete') ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>

    <fieldset>
        <legend><?php echo __("Rooms")?></legend>
        <table id="allReservationRoomsTab" class="largeTable">
            <thead>
                <tr class="sortableTable">
                    <th><?php echo __('Room')?></th>
                    <th><?php echo __('From')?></th>
                    <th><?php echo __('To')?></th>
                    <th class='greyCell' style='width:120px;'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($room_reservations as $k => $room_reservation): ?>
                    <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                        <td><?php echo $room_reservation->getRoom()->getDesignation(); ?></td>
                        <td><?php echo date_format(new DateTime($room_reservation->getStartDate()), __('m/d/Y').' H:i'); ?></td>
                        <td><?php echo date_format(new DateTime($room_reservation->getEndDate()), __('m/d/Y').' H:i'); ?></td>
                        <td align='center'><a class='deleteroom' href='' onclick='SupprRoom(<?php echo $room_reservation->getId(); ?>); return false;'><?php echo __('Delete') ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>

<input type="button" value=<?php echo __('Close')?> onclick="$('#event_detail').dialog('close');">
<input type="button" value="<?php echo __('Back')?>" id="Back-Button">
<div class="rightAlignement">
	<input type="button" id="add-period" value="<?php echo __('Add') ?>" />
</div>

<script>

	function SupprComputer(id_computer)
	{

		req = "id="+<?php echo $reservation->getId(); ?>+"&id_resa_computer="+id_computer;

		$("#event_detail").dialog('close');

		$("#event_detail").load(
	            '<?php echo url_for('reservation/AjaxSupprResa') ?>',
	            req,
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

	function SupprRoom(id_room)
	{
		req = "id="+<?php echo $reservation->getId(); ?>+"&id_resa_room="+id_room;

		$("#event_detail").dialog('close');

		$("#event_detail").load(
	            '<?php echo url_for('reservation/AjaxSupprResa') ?>',
	            req,
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

	$('#add-period').click(function(){

		$("#event_detail").dialog('close');
	        		
		$("#event_detail").load(
			'<?php echo url_for('reservation/AjaxAddPeriod') ?>',
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
