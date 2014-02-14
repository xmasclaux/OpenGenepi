<script type = "text/javascript">


	$(document).ready(function(){

		$("#imputation_countable_service_initial_value").focus();

		var first_values = new Array();
		
		<?php foreach($first_user_account_values as $id_account => $value):?>
			first_values[<?php echo $id_account ?>] = <?php echo $value ?>;
		<?php endforeach;?>

		var first_unities = new Array();
		
		<?php foreach($first_user_account_unities as $id_account => $unity):?>
			first_unities[<?php echo $id_account ?>] = "<?php echo $unity ?>";
		<?php endforeach;?>
		

		var values = new Array();

		<?php foreach($users_account_values as $id_user => $user_account_values):?>

			values[<?php echo $id_user ?>] = new Array();
			
			<?php foreach($user_account_values as $id_account => $value):?>
			
				values[<?php echo $id_user ?>][<?php echo $id_account ?>] = <?php echo $value?>;
				
			<?php endforeach;?>
			
		<?php endforeach;?>

		var unities = new Array();

		<?php foreach($users_account_unities as $id_user => $user_account_unities):?>

			unities[<?php echo $id_user ?>] = new Array();
			
			<?php foreach($user_account_unities as $id_account => $unity):?>
			
				unities[<?php echo $id_user ?>][<?php echo $id_account ?>] = "<?php echo $unity?>";
				
			<?php endforeach;?>
			
		<?php endforeach;?>

		$("#imputation_countable_service_imputation_account_id").ready(function(){

			if($(this).val() != 0){
				$("#status").html(first_values[$(this).val()] + " " + first_unities[$(this).val()]);

				if(values[$(this).val()] < 0){
					$("#status").css("color", "red");
				}else{
					$("#status").css("color", "green");
				}
				
			}else{
				$("#status").html("");
			}
			
		});
		
		$("#imputation_countable_service_imputation_account_id").change(function(){
			
			if($(this).val() != 0){
				$("#status").html(first_values[$(this).val()] + " " + first_unities[$(this).val()]);

				if(values[$(this).val()] < 0){
					$("#status").css("color", "red");
				}else{
					$("#status").css("color", "green");
				}
				
			}else{
				$("#status").html("");
			}
			
		});


		<?php foreach($users_id as $user_id):?>

			$("#imputation_countable_service_imputation_account_id_<?php echo $user_id ?>").ready(function(){
	
				if($(this).val() != 0){
					$("#status_<?php echo $user_id ?>").html(values[<?php echo $user_id ?>][$(this).val()] + " " + unities[<?php echo $user_id ?>][$(this).val()]);
	
					if(values[$(this).val()] < 0){
						$("#status_<?php echo $user_id ?>").css("color", "red");
					}else{
						$("#status_<?php echo $user_id ?>").css("color", "green");
					}
					
				}else{
					$("#status_<?php echo $user_id ?>").html("");
				}
				
			});
			
			$("#imputation_countable_service_imputation_account_id_<?php echo $user_id ?>").change(function(){
				
				if($(this).val() != 0){
					$("#status_<?php echo $user_id ?>").html(values[<?php echo $user_id ?>][$(this).val()] + " " + unities[<?php echo $user_id ?>][$(this).val()]);
	
					if(values[$(this).val()] < 0){
						$("#status_<?php echo $user_id ?>").css("color", "red");
					}else{
						$("#status_<?php echo $user_id ?>").css("color", "green");
					}
					
				}else{
					$("#status_<?php echo $user_id ?>").html("");
				}
				
			});


			$("#imputation_countable_service_imputation_method_of_payment_id_<?php echo $user_id ?>").change(function(){
				
				if($(this).val() == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
					$("#imputation_countable_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_text_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_<?php echo $user_id ?>").css("visibility","visible");
					
				}else{
					$("#imputation_countable_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_text_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_<?php echo $user_id ?>").css("visibility","hidden");
				}
				
			});

			$("#imputation_countable_service_imputation_method_of_payment_id_<?php echo $user_id ?>").ready(function(){
				
				if("<?php echo ParametersConfiguration::getDefault('default_method_of_payment') ?>" == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
					$("#imputation_countable_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_text_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_<?php echo $user_id ?>").css("visibility","visible");
					
				}else{
					$("#imputation_countable_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_text_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_<?php echo $user_id ?>").css("visibility","hidden");
				}
				
			});

		<?php endforeach;?>

		$("#imputation_countable_service_imputation_method_of_payment_id").change(function(){
			
			if($(this).val() == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
				$("#imputation_countable_service_imputation_account_id").css("visibility","visible");
				$("#status_text").css("visibility","visible");
				$("#status").css("visibility","visible");
				
			}else{
				$("#imputation_countable_service_imputation_account_id").css("visibility","hidden");
				$("#status_text").css("visibility","hidden");
				$("#status").css("visibility","hidden");
			}
			
		});

		$("#imputation_countable_service_imputation_method_of_payment_id").ready(function(){
			
			if("<?php echo ParametersConfiguration::getDefault('default_method_of_payment') ?>" == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
				$("#imputation_countable_service_imputation_account_id").css("visibility","visible");
				$("#status_text").css("visibility","visible");
				$("#status").css("visibility","visible");
				
			}else{
				$("#imputation_countable_service_imputation_account_id").css("visibility","hidden");
				$("#status_text").css("visibility","hidden");
				$("#status").css("visibility","hidden");
			}
			
		});

	});

</script>

<?php if($display_secondary):?>

	<?php include_partial('global/messages')?>

	<?php slot('secondaryMenu') ?>
		<h2><?php echo __('Functionalities')?></h2>
		<h3 class = "selected"><?php echo __('Impute an act')?></h3>
		<h3><a href="<?php echo url_for('use/history') ?>"><?php echo __('View history')?></a></h3>
	<?php end_slot(); ?>

<?php endif;?>

<?php include_partial('countableServiceForm', array(
							'form'                   => $form, 
							'users_id'               => $users_id,
							'users_names'            => $users_names,
							'act_public_category_id' => $act_public_category_id, 
							'currency_symbol'        => $currency_symbol,
							'error_account'			 => $error_account)) ?>


