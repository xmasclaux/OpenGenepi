
<h3 style='margin:10px 0;'><?php echo __('Users'); ?></h3>

<table id="allReservationsTab" class="largeTable">
    <tbody>
    	<?php if ( isset($users) && $users->rowCount() > 0): ?>
        	<?php foreach ($users as $k => $user): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                <td>
                	<?php echo $user['name']." ".$user['surname']; ?>
                	<div class="rightAlignement" ><a href="" onclick="SupprUser(<?php echo $user['id']?>); return false;"><?php echo __('Delete')?></a></div>
                </td>
            </tr>
        	<?php endforeach; ?>
        <?php else : ?>
			<tr class=odd>
				<td>
					<?php echo __('no user yet ...');?>
				</td>
			</tr>
		<?php endif; ?>
    </tbody>
</table>



<input type="text" id='search' name='search'>
<input type="button" id='search-button' value=<?php echo __('Search')?>>


<br>
<div id='search-result'></div>
<br>

<input type="button" value=<?php echo __('Close')?> onclick="$('#event_detail').dialog('close');">
<input type="button" value="<?php echo __('Back')?>" id="Back-Button">


<script>

	function ajaxSearch()
	{
		search = 'search=' + $('#search').val()+'&id='+<?php echo $reservation->getId(); ?>;
		$('#search-result').load(
			'<?php echo url_for('reservation/AjaxSearchUser') ?>',
			search,
			function(data) {
			});		
	}

	$('#search-button').click(function(){ ajaxSearch(); });
	
	$('#search').keyup(function(){
		
		var value = $(this).val();
		if ( $(this).val().length > 1 )
		{
			setTimeout(
				function(){
					if ( $('#search').val() == value ) ajaxSearch();
			},500);
		}
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

	function SupprUser(user_id)
	{

		req = "id="+<?php echo $reservation->getId(); ?>+"&user_id="+user_id;

		$("#event_detail").dialog('close');

		$("#event_detail").load(
	            '<?php echo url_for('reservation/AjaxSupprUser') ?>',
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