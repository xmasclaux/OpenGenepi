<?php slot('title', sprintf('GENEPI - '.__('Moderators')))?>

<h1><?php echo __('New Moderator')?></h1>

<head>

	<script type="text/javascript">
		$(document).ready(function(){

			//Toggle the help message :
			$("#content tbody tr td:has(input[type=checkbox]) input[type=checkbox]").click(function(){
				var html = $(this).parent("td").next("td").children("div").children("em:last").html();
				
				if(html == "<?php echo __('Viewer')?>"){
					$(this).parent("td").next("td").children("div").children("em:last").html("<?php echo __('Administrator')?>");
				}else if(html == "<?php echo __('Administrator')?>"){
					$(this).parent("td").next("td").children("div").children("em:last").html("<?php echo __('Viewer')?>");
				}
			});

			//Add an event on the blur of the field 'name'
			$("input[name='moderator[name]']").blur(function(){

				if($(this).val() != '' && $("input[name='moderator[surname]']").val() != ''){			
					var name = $(this).val();
					var surname = $("input[name='moderator[surname]']").val();
					var login = name.toLowerCase().substr(0,1) + surname.toLowerCase();
					$("input[name='moderator[login][login]']").val(login);
				}
				
			});

			//Add an event on the blur of the field 'surname'
			$("input[name='moderator[surname]']").blur(function(){
				
				if($(this).val() != '' && $("input[name='moderator[name]']").val() != ''){
					var surname = $(this).val();
					var name = $("input[name='moderator[name]']").val();
					var login = name.toLowerCase().substr(0,1) + surname.toLowerCase();
					$("input[name='moderator[login][login]']").val(login);
				}
			});
		});
	</script>
	
</head>

<?php include_partial('global/messages')?>

<?php include_partial('form', array('form' => $form, 'isModerator' => $isModerator )) ?>
