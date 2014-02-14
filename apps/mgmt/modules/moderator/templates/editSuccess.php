<?php slot('title', sprintf('GENEPI - '.__('Moderators')))?>

<h1><?php echo __('Edit Moderator')?></h1>

<head>

	<script type="text/javascript">
	function initPage(){

		$("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
		
		$("#link_change_pass").click(function(){
			$(this).parent("td").html($("#change_content").html());

			$("#password_change").val("1");

			$("#content tbody tr:last td:last #link_cancel_change").click(function(){
				$("#cancel_change").html($("#cancel_change_content").html());
				$("#password_change").val("0");
				initPage();
			});
			
		});
	}
	
	$(document).ready(function(){
		initPage();
	});
	</script>
	
</head>

<div id="dialog" title="<?php echo __("Moderator deletion")?>" style="display:none">
	
	<p><?php echo __("Caution, this action will delete the moderator.") ?></p>
	<br />
	
	<input type="button" id="back-button" value=<?php echo __('Back')?>></input>
	
	<span class="deletion-button" style="float:right; margin-top:18px;">
		<?php echo link_to(__('Confirm'), 'moderator/delete?id='.$form->getObject()->getLogin()->getId(), array('method' => 'delete')) ?>
	</span>

</div>

<?php include_partial('global/messages')?>

<?php include_partial('form', array('form' => $form, 'is_myself' => $is_myself)) ?>
