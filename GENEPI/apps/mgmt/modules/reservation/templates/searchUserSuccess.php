<table id="allReservationsTab" class="largeTable">
    <tbody>
        <?php foreach ($users as $k => $user): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                <td style='vertical-align:middle;'>
                	<?php echo $user['name']." ".$user['surname']; ?>
                	<div class="rightAlignement" ><a href="" onclick="AddUser(<?php echo $user['id']?>); return false;"><?php echo __('Add')?></a></div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>

	function AddUser(user_id)
	{

		req = "id="+<?php echo $reservation->getId(); ?>+"&user_id="+user_id;

		$("#event_detail").dialog('close');

		$("#event_detail").load(
	            '<?php echo url_for('reservation/AjaxAddUser') ?>',
	            req,
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
		
	}

</script>