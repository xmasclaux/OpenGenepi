<script type = "text/javascript">

	function changeTotal(){

		if(($("#imputation_account_transaction_number_of_unities").val() != '') && ($("#imputation_account_transaction_unitary_price").val() != '')){

			$("#imputation_account_transaction_imputation_total").val(parseFloat($("#imputation_account_transaction_sum").val()) * parseFloat($("#imputation_account_transaction_unitary_price").val()));
		}
		
	}

	$(document).ready(function(){

		$("#imputation_account_transaction_designation").focus();

		var values = new Array();
		
		<?php foreach($user_account_values as $id => $value):?>
			values[<?php echo $id ?>] = <?php echo $value?>;
		<?php endforeach;?>

		var unities = new Array();
		
		<?php foreach($user_account_unities as $id => $unity):?>
		unities[<?php echo $id ?>] = "<?php echo $unity?>";
		<?php endforeach;?>

		$("#imputation_account_transaction_imputation_account_id").ready(function(){

			if($(this).val() != 0){
				$("#status").html(values[$(this).val()] + " " + unities[$(this).val()]);
				$("#free_account_unity").html(unities[$(this).val()]);
				

				if(values[$(this).val()] < 0){
					$("#status").css("color", "red");
				}else{
					$("#status").css("color", "green");
				}
				
			}else{
				$("#status").html("");
				$("#free_account_unity").html("");
			}
			
		});
		
		$("#imputation_account_transaction_imputation_account_id").change(function(){
			
			if($(this).val() != 0){
				$("#status").html(values[$(this).val()] + " " + unities[$(this).val()]);
				$("#free_account_unity").html(unities[$(this).val()]);

				if(values[$(this).val()] < 0){
					$("#status").css("color", "red");
				}else{
					$("#status").css("color", "green");
				}
				
			}else{
				$("#status").html("");
				$("#free_account_unity").html("");
			}
			
		});

		$("#imputation_account_transaction_imputation_method_of_payment_id").change(function(){
			
			if($(this).val() == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
				$("#imputation_account_transaction_account_to_pay_id").css("visibility","visible");
			}else{
				$("#imputation_account_transaction_account_to_pay_id").css("visibility","hidden");
			}
			
		});

		$("#imputation_account_transaction_imputation_method_of_payment_id").ready(function(){

			if("<?php echo ParametersConfiguration::getDefault('default_method_of_payment') ?>" == "<?php echo ImputationDefaultValues::getAccountMethodId() ?>"){
				$("#imputation_account_transaction_account_to_pay_id").css("visibility","visible");
			}else{
				$("#imputation_account_transaction_account_to_pay_id").css("visibility","hidden");
			}
			
		});

		$("#imputation_account_transaction_imputation_total").focus(function(){
			changeTotal();
		});

		$("#imputation_account_transaction_sum").change(function(){
			changeTotal();
		});

		$("#imputation_account_transaction_unitary_price").change(function(){
			changeTotal();
		});


		$("#free_choose").click(function(){
		
			$("#nonfree_input_info").hide();
			$("#nonfree_input").hide();
			$("#nonfree_input_to_pay").hide();
			$("#free_input").show();
			$("#imputation_account_transaction_quantity").focus();
			$(this).css("font-weight","bold");
			$("#nonfree_choose").css("font-weight","normal");
			
		});

		$("#nonfree_choose").click(function(){
			
			$("#nonfree_input_info").show();
			$("#nonfree_input").show();
			$("#nonfree_input_to_pay").show();
			$("#free_input").hide();
			$("#imputation_account_transaction_sum").focus();
			$(this).css("font-weight","bold");
			$("#free_choose").css("font-weight","normal");
			
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

<?php include_partial('accountTransactionForm', array('form' => $form, 'user_account_values' => $user_account_values, 'user_account_unities' => $user_account_unities, 'error_account' => $error_account, 'display_secondary' => $display_secondary)) ?>


