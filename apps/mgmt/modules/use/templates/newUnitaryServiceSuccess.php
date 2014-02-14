<script type = "text/javascript">
	var time_now = "end";
	
	function newTotal(){
		
		if(($("#imputation_unitary_service_number_of_unities").val() != '') && ($("#imputation_unitary_service_unitary_price").val() != '')){

			$("#imputation_unitary_service_imputation_total").val(parseInt($("#imputation_unitary_service_number_of_unities").val()) * parseFloat($("#imputation_unitary_service_unitary_price").val()));
		}
		
	}

	function refreshHours(when_is_now){

		if(when_is_now == "end"){

			var hour = parseInt($("#imputation_unitary_service_end_time_hour").val());
			var min = parseInt($("#imputation_unitary_service_end_time_minute").val());
						
			var duration = $("#duration").val();
			duration = duration.split(":");

			var duration_min = parseInt(duration[0]);
			var duration_hour = parseInt(duration[1]);

			begin_hour = hour - duration_hour * parseInt($("#imputation_unitary_service_number_of_unities").val());
			begin_min = min - duration_min * parseInt($("#imputation_unitary_service_number_of_unities").val());
			
			while(begin_hour < 0){
				begin_hour = begin_hour + 24;
			}

			while(begin_min < 0){
				begin_min = begin_min + 60;
				begin_hour -= 1;
			}
			
			$("#imputation_unitary_service_beginning_time_hour").val(begin_hour);
			$("#imputation_unitary_service_beginning_time_minute").val(begin_min);

		}else if(when_is_now == "begin"){

			var hour = parseInt($("#imputation_unitary_service_beginning_time_hour").val());
			var min = parseInt($("#imputation_unitary_service_beginning_time_minute").val());
						
			var duration = $("#duration").val();
			duration = duration.split(":");

			var duration_min = parseInt(duration[0]);
			var duration_hour = parseInt(duration[1]);

			end_hour = hour + duration_hour * parseInt($("#imputation_unitary_service_number_of_unities").val());
			end_min = min + duration_min * parseInt($("#imputation_unitary_service_number_of_unities").val());
			
			while(end_hour > 24){
				end_hour = end_hour - 24;
			}

			while(end_min > 60){
				end_min = end_min - 60;
				end_hour += 1;
			}
			
			$("#imputation_unitary_service_end_time_hour").val(end_hour);
			$("#imputation_unitary_service_end_time_minute").val(end_min);

		}
		
	}


	$(document).ready(function(){

		$("#imputation_unitary_service_number_of_unities").focus();

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

		$("#imputation_unitary_service_imputation_account_id").ready(function(){

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
		
		$("#imputation_unitary_service_imputation_account_id").change(function(){
			
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

			$("#imputation_unitary_service_imputation_account_id_<?php echo $user_id ?>").ready(function(){
	
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
			
			$("#imputation_unitary_service_imputation_account_id_<?php echo $user_id ?>").change(function(){
				
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


			$("#imputation_unitary_service_imputation_method_of_payment_id_<?php echo $user_id ?>").change(function(){
				
				if($(this).val() == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
					$("#imputation_unitary_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_text_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_<?php echo $user_id ?>").css("visibility","visible");
					
				}else{
					$("#imputation_unitary_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_text_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_<?php echo $user_id ?>").css("visibility","hidden");
				}
				
			});

			$("#imputation_unitary_service_imputation_method_of_payment_id_<?php echo $user_id ?>").ready(function(){
				
				if("<?php echo ParametersConfiguration::getDefault('default_method_of_payment') ?>" == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
					$("#imputation_unitary_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_text_<?php echo $user_id ?>").css("visibility","visible");
					$("#status_<?php echo $user_id ?>").css("visibility","visible");
					
				}else{
					$("#imputation_unitary_service_imputation_account_id_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_text_<?php echo $user_id ?>").css("visibility","hidden");
					$("#status_<?php echo $user_id ?>").css("visibility","hidden");
				}
				
			});

		<?php endforeach;?>

		$("#imputation_unitary_service_imputation_method_of_payment_id").change(function(){
			
			if($(this).val() == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
				$("#imputation_unitary_service_imputation_account_id").css("visibility","visible");
				$("#status_text").css("visibility","visible");
				$("#status").css("visibility","visible");
				
			}else{
				$("#imputation_unitary_service_imputation_account_id").css("visibility","hidden");
				$("#status_text").css("visibility","hidden");
				$("#status").css("visibility","hidden");
			}
			
		});

		$("#imputation_unitary_service_imputation_method_of_payment_id").ready(function(){
			
			if("<?php echo ParametersConfiguration::getDefault('default_method_of_payment') ?>" == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
				$("#imputation_unitary_service_imputation_account_id").css("visibility","visible");
				$("#status_text").css("visibility","visible");
				$("#status").css("visibility","visible");
				
			}else{
				$("#imputation_unitary_service_imputation_account_id").css("visibility","hidden");
				$("#status_text").css("visibility","hidden");
				$("#status").css("visibility","hidden");
			}
			
		});

		$("#imputation_unitary_service_imputation_total").focus(function(){
			newTotal();
		});

		$("#imputation_unitary_service_number_of_unities").blur(function(){
			newTotal();
		});
		
		$("#imputation_unitary_service_unitary_price").blur(function(){
			newTotal();
		});


		$("#begin_time_now").click(function(){

			var today = new Date();
			var hour = today.getHours();
			var min = today.getMinutes();

			$("#imputation_unitary_service_beginning_time_hour").val(hour);
			$("#imputation_unitary_service_beginning_time_minute").val(min);
						
			var duration = $("#duration").val();
			duration = duration.split(":");

			var duration_min = parseInt(duration[0]);
			var duration_hour = parseInt(duration[1]);

			hour = hour + duration_hour * $("#imputation_unitary_service_number_of_unities").val();
			min = min + duration_min * $("#imputation_unitary_service_number_of_unities").val();

			if(hour >= 24){
				hour = hour - 24;
			}

			if(min >= 60){
				min = min - 60;
				hour += 1;
			}
			
			$("#imputation_unitary_service_end_time_hour").val(hour);
			$("#imputation_unitary_service_end_time_minute").val(min);

			time_now = "begin";
		});

		$("#end_time_now").click(function(){

			var today = new Date();
			var hour = today.getHours();
			var min = today.getMinutes();

			$("#imputation_unitary_service_end_time_hour").val(hour);
			$("#imputation_unitary_service_end_time_minute").val(min);
						
			var duration = $("#duration").val();
			duration = duration.split(":");

			var duration_min = parseInt(duration[0]);
			var duration_hour = parseInt(duration[1]);

			hour = hour - duration_hour * $("#imputation_unitary_service_number_of_unities").val()
			min = min - duration_min * $("#imputation_unitary_service_number_of_unities").val()
			
			while(hour < 0){
				hour = hour + 24;
			}

			while(min < 0){
				min = min + 60;
				hour -= 1;
			}
			
			$("#imputation_unitary_service_beginning_time_hour").val(hour);
			$("#imputation_unitary_service_beginning_time_minute").val(min);

			time_now = "end";
		});

		$("#imputation_unitary_service_number_of_unities").change(function(){
			refreshHours(time_now);			
		});

		$("#imputation_unitary_service_end_time_hour").change(function(){
			refreshHours("end");		
		});

		$("#imputation_unitary_service_end_time_minute").change(function(){
			refreshHours("end");			
		});

		$("#imputation_unitary_service_beginning_time_hour").change(function(){
			refreshHours("begin");			
		});

		$("#imputation_unitary_service_beginning_time_minute").change(function(){
			refreshHours("begin");			
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


<?php include_partial('unitaryServiceForm', array(
								'form'                   => $form, 
								'users_id'               => $users_id,
								'users_names'            => $users_names,
								'act_public_category_id' => $act_public_category_id,
								'duration'               => $duration,
								'error_account'			 => $error_account)); ?>


