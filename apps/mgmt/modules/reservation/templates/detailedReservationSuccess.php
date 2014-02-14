<h2 style='margin:-10px 0 5px 0;'><?php echo $reservation->getDesignation(); ?></h2>



<h3 style='margin:10px 0;'><?php echo __('Users'); ?></h3>
<?php if (count($users) > 0): ?>
<table id="allReservationsTab" class="largeTable">
    <tbody>
        <?php foreach ($users as $k => $user): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                <td><?php echo $user['name']." ".$user['surname']; ?></td>
            </tr>
        <?php $user_list .= $sep.$user['id']; $sep = ",";?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<input type="button" id="edit-user" value="<?php echo __('Manage users')?>" ></input>

<?php if (count($computer_reservations) > 0): ?>
<h3 style='margin:10px 0;'><?php echo __('Computers'); ?></h3>
<table id="allReservationsTab" class="largeTable">
    <tbody>
        <?php foreach ($computer_reservations as $k => $computer_reservation): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                <td><?php echo $computer_reservation->getComputer()->getName(); ?></td>
                <td><?php echo date_format(new DateTime($computer_reservation->getStartDate()), __('m/d/Y').' H:i'); ?></td>
                <td><?php echo date_format(new DateTime($computer_reservation->getEndDate()), __('m/d/Y').' H:i'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php if (count($room_reservations) > 0): ?>
<h3 style='margin:10px 0;'><?php echo __('Rooms'); ?></h3>
<table id="allReservationsTab" class="largeTable">
    <tbody>
        <?php foreach ($room_reservations as $k => $room_reservation): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                <td><?php echo $room_reservation->getRoom()->getDesignation(); ?></td>
                <td><?php echo date_format(new DateTime($room_reservation->getStartDate()), __('m/d/Y').' H:i'); ?></td>
                <td><?php echo date_format(new DateTime($room_reservation->getEndDate()), __('m/d/Y').' H:i'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<input type="button" id="edit-period" value="<?php echo __('Manage periods')?>" ></input>



<?php if ( $event ):?>
<h3 style='margin:10px 0;'><?php echo __('Public event'); ?> : <?php echo $event[0]->getDesignation(); ?></h3>
<div>
<input type="button" id="edit-event" value="<?php echo __('Manage event')?>" ></input>
</div>
<?php else:?>
<h3 style='margin:10px 0;'><?php echo __('No public event'); ?></h3>
<div>
<input type="button" id="edit-event" value="<?php echo __('Add event')?>" ></input>
</div>
<?php endif;?>


<div style='margin-top:20px;'>

    <input type="button" id="edit-reservation" value="<?php echo __('Edit reservation')?>" ></input>

    <input type="button" id="new-imputation" value="<?php echo __('Impute an act');?>" onclick="document.location='<?php echo url_for('use/index');echo "?users_liste=".$user_list;?>'"></input>

    <input style="float:right; margin-top:18px;" type="button" id="back-button" value=<?php echo __('Close')?> onclick="$('#event_detail').dialog('close');"></input>

</div>

<script>

$('#edit-event').click(function(){

	$("#event_detail").dialog('close');
	
	$("#event_detail").load(
            '<?php echo url_for('reservation/AjaxEditEvent') ?>',
            { id: <?php echo $reservation->getId(); ?>, event_id: '<?php echo $event[0]->getId(); ?>' },
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

$('#edit-reservation').click(function(){

	$("#event_detail").dialog('close');
	
	$("#event_detail").load(
            '<?php echo url_for('reservation/AjaxEditReservation') ?>',
            { id: <?php echo $reservation->getId(); ?> },
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

$('#edit-period').click(function(){

	$("#event_detail").dialog('close');
	
	$("#event_detail").load(
            '<?php echo url_for('reservation/AjaxEditPeriod') ?>',
            { id: <?php echo $reservation->getId(); ?> },
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

$('#edit-user').click(function(){

	$("#event_detail").dialog('close');
	
	$("#event_detail").load(
            '<?php echo url_for('reservation/AjaxEditUser') ?>',
            { id: <?php echo $reservation->getId(); ?> },
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

</script>