<h1><?php echo __('New User')?></h1>

<head>

	<script type="text/javascript">
	$(document).ready(function(){
		
			//Add an event on the blur of the field 'name'
			$("input[name='form[name]']").blur(function(){

				if($(this).val() != '' && $("input[name='form[surname]']").val() != ''){			
					var name = $(this).val();
					var surname = $("input[name='form[surname]']").val();
					var login = name.toLowerCase().substr(0,1) + surname.toLowerCase();
					$("input[name='form[login][login]']").val(login);
				}
				
			});

			//Add an event on the blur of the field 'surname'
			$("input[name='form[surname]']").blur(function(){
				
				if($(this).val() != '' && $("input[name='form[name]']").val() != ''){
					var surname = $(this).val();
					var name = $("input[name='form[name]']").val();
					var login = name.toLowerCase().substr(0,1) + surname.toLowerCase();
					$("input[name='form[login][login]']").val(login);
				}
			});
		});
	</script>
	
</head>


<?php include_partial('form', array('form' => $form)) ?>
