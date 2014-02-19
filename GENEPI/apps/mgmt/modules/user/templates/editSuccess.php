<h1><?php echo __('Edit User')?></h1>

<head>

	<script type="text/javascript">
	function initPage(){

		$("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
		
		$("#link_change_pass").click(function(){
			$(this).parent("td").html($("#change_content").html());

			$("#password_change").val("1");

			$("#link_cancel_change").click(function(){
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

<?php include_partial('form', array('form' => $form, 'userId' => $userId, 'login' => $login)) ?>
