<?php if(!$xhr):?>
	<?php slot('title', sprintf('GENEPI - '.__('Balance')))?>
	<head>
	<script type="text/javascript">

		function urlForAnotherStatPage(url){
			url += "?from=" + $("#formattedFrom").val() + "&to=" + $("#formattedTo").val();
			document.location.href = url;
		}
	
		$(function() {
			var dateFrom = $('#from').datepicker({
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				showOtherMonths: true, 
				selectOtherMonths: true,
				showAnim: null,
				minDate: null, 
				firstDay: 1,
				altField: '#formattedFrom',
				altFormat: 'yy-mm-dd',
				onSelect: function(selectedDate) {
					var option = this.id == "from" ? "minDate" : "maxDate";
					var instance = $(this).data("datepicker");
					var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
					dateFrom.not(this).datepicker("option", option, date);
				}
			});

			var dateTo = $('#to').datepicker({
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				showOtherMonths: true, 
				selectOtherMonths: true,
				showAnim: null,
				firstDay: 1,
				altField: '#formattedTo',
				altFormat: 'yy-mm-dd',
				beforeShow: function() {
			        var startDate = $("#from").datepicker('getDate');
			        if (startDate != null) {
			            startDate.setDate(startDate.getDate()+1);
			            $(this).datepicker('option', 'minDate', startDate);
			        }},
				onSelect: function(selectedDate) {
					var option = this.id == "from" ? "minDate" : "maxDate";
					var instance = $(this).data("datepicker");
					var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
					dateTo.not(this).datepicker("option", option, date);
					$('#confirmDiv').show();
				}
			});

		});

		$(function($){
			$.datepicker.regional['<?php echo $userCulture?>'] = {
				monthNamesShort: ['<?php echo __('Jan')?>','<?php echo __('Feb')?>','<?php echo __('Mar')?>','<?php echo __('Apr')?>','<?php echo __('May')?>','<?php echo __('Jun')?>','<?php echo __('Jul')?>','<?php echo __('Aug')?>','<?php echo __('Sep')?>','<?php echo __('Oct')?>','<?php echo __('Nov')?>','<?php echo __('Dec')?>'],
				dayNamesMin: ['<?php echo __('Su')?>','<?php echo __('Mo')?>','<?php echo __('Tu')?>','<?php echo __('We')?>','<?php echo __('Th')?>','<?php echo __('Fr')?>','<?php echo __('Sa')?>'],
				dateFormat: '<?php echo __('mm/dd/yy')?>'};
			$.datepicker.setDefaults($.datepicker.regional['<?php echo $userCulture?>']);
		});

		$(document).ready(function() {
			$('#confirm').click(function(){ 
				
				$("#dialog").dialog( { 
					width: 600,
					close: true,
					resizable: false,
					modal: true,
					draggable: false,
				} );

				$("#detailedStat").load('<?php echo url_for('stat/balance') ?>', { from: $("#formattedFrom").val(), to: $("#formattedTo").val() },
					function(data) {
						$("#dialog").dialog("close");
					  	$("#panel").show();
				} );
			});	
		});
	</script> 
</head>

<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/index')?>')"><?php echo __('Detailed statistics')?></a></h3>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/quantitativeStatementIndex')?>')"><?php echo __('Quantitative statement')?></a></h3>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/temporalStatementIndex')?>')"><?php echo __('Temporal statement')?></a></h3>
	<h3 class = "selected"><?php echo __('Balance')?></h3>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/exportIndex') ?>')"><?php echo __('Export')?></a></h3>
	<h3><a href="<?php echo url_for('stat/uploadIndex') ?>"><?php echo __('Upload/Download')?></a></h3>
<?php end_slot(); ?>

<h1><?php echo __('Detailed balance')?></h1>

<div id="dialog" title="<?php echo __("Statistics generation")?>" style="display:none">
	<center>
		<p><?php echo __('Generation in progress')?></p>
		<?php echo image_tag('indicator2.gif', array('title' => __('Loading'))) ?>
	</center>
</div>

<div class="panel">
	<h6><?php echo __('Select a period')." : "?></h6>
	
	<label for="from"><?php echo __('From the')?></label> 
	<input type="text" id="from" name="from" class="datepicker" value="<?php echo isset($from) ? date_format(date_create($from), __('m/d/Y')) : date(__('m/d/Y'))?>"/> 
	<label for="to"><?php echo __('to the')?></label> 
	<input type="text" id="to" name="to" class="datepicker" value="<?php echo isset($to) ? date_format(date_create($to), __('m/d/Y')) : date(__('m/d/Y'),strtotime('+1 day'))?>"/> 
	<input type="hidden" id="formattedFrom" value="<?php echo isset($from) ? date_format(date_create($from), __('Y-m-d')) : date(__('Y-m-d'))?>"/>
	<input type="hidden" id="formattedTo" value="<?php echo isset($to) ? date_format(date_create($to), __('Y-m-d')) : date(__('Y-m-d'),strtotime('+1 day'))?>"/>
	<br />
	<div class="rightAlignement" id="confirmDiv" >
		<input type="button" id="confirm" value=<?php echo __('Confirm')?>>
	</div>
	<br /><br /><br />
</div>

<div class="panel" id="panel">
	<div id="detailedStat">
<?php endif;?>

	<h6><?php echo __('Balance per act')." : "?></h6>
	<table class="threeColumsStat">
		<thead>
			<tr>
				<th><?php echo __('Acts')?></th>
				<th><?php echo __('Value').' ('.$currency_symbol.')'?></th>
				<th><?php echo __('Percentage')?></th>
				<th><?php echo __('Time')?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($acts_values['act'] as $act_designation => $act_value_percentage):?>
				<tr>
					<td class="important"><?php echo $act_designation?></td>
					
					<?php if($act_value_percentage['value'] == $acts_values['max']):?>
					
						<td class="centered max"><strong><?php echo $act_value_percentage['value']?></strong></td>
						<td class="centered max"><strong><?php echo $act_value_percentage['percentage'].' %'?></strong></td>
						
					<?php elseif($act_value_percentage['value'] == $acts_values['min']):?>
						
						<td class="centered min"><strong><?php echo $act_value_percentage['value']?></strong></td>
						<td class="centered min"><strong><?php echo $act_value_percentage['percentage'].' %'?></strong></td>
						
					<?php else:?>
					
						<td class="centered"><?php echo $act_value_percentage['value']?></td>
						<td class="centered"><?php echo $act_value_percentage['percentage'].' %'?></td>		
						
					<?php endif;?>
					
					<?php if($act_value_percentage['time'] == $acts_values['max_time']):?>
					
						<td class="centered max"><strong><?php echo gmdate('G', $act_value_percentage['time']).'h'.gmdate('i', $act_value_percentage['time'])?></strong></td>
						
					<?php elseif($act_value_percentage['time'] == $acts_values['min_time']):?>
					
						<td class="centered min"><strong><?php echo gmdate('G', $act_value_percentage['time']).'h'.gmdate('i', $act_value_percentage['time'])?></strong></td>
						
					<?php else:?>
					
						<td class="centered"><?php echo gmdate('G', $act_value_percentage['time']).'h'.gmdate('i', $act_value_percentage['time'])?></td>
						
					<?php endif;?>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<tr>
				<th><?php echo __('Total')?></th>
				<th><?php echo $acts_values['total_value']?></th>
				<th><?php echo '100 %'?></th>
				<th><?php echo gmdate('G', $acts_values['total_time']).'h'.gmdate('i', $acts_values['total_time'])?></th>
			</tr>
		</tfoot>
	</table>
	<br>
	<div style="width:100%">
		<div class="info-message-white">
	    	<span class="info-message-icon"></span>
			<em><?php echo __('Caution: The above total is not the real status of the balance. Check the dashboard to get this information.')?><br></em>
		</div>
		<div style="float:left width:auto"></div>
	</div>
	<br style="clear:left">

	<br /><br />

	<h6><?php echo __('Accounts status')." : "?></h6>
	<table class="threeColumsStat">
		<thead>
			<tr>
				<th><?php echo __('Monetary accounts')?></th>
				<th><?php echo __('Value').' ('.$currency_symbol.')'?></th>
				<th><?php echo __('Amount of accounts')?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="important"><?php echo __('Positives')?></td>
				<td class="centered"><?php echo $positive_accounts['value']?></td>
				<td class="centered"><?php echo $positive_accounts['number']?></td>
			</tr>
			
			<tr>
				<td class="important"><?php echo __('Negatives')?></td>
				<td class="centered"><?php echo $negative_accounts['value']?></td>
				<td class="centered"><?php echo $negative_accounts['number']?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th><?php echo __('Total')?></th>
				<th><?php echo $total_accounts['value']?></th>
				<th><?php echo $total_accounts['number']?></th>
			</tr>
		</tfoot>
	</table>
	
	<br /><br />
	
	<h6><?php echo __('Balance per method of payment')." : "?></h6>
	<table class="threeColumsStat">
		<thead>
			<tr>
				<th><?php echo __('Methods of payment')?></th>
				<th><?php echo __('Value').' ('.$currency_symbol.')'?></th>
				<th><?php echo __('Percentage')?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($methods_of_payments_values['mop'] as $mop_designation => $mop_value_percentage):?>
				<tr>
					<td class="important"><?php echo __($mop_designation)?></td>
					<?php if($mop_value_percentage['value'] == $methods_of_payments_values['max']):?>
					
						<td class="centered max"><strong><?php echo $mop_value_percentage['value']?></strong></td>
						<td class="centered max"><strong><?php echo $mop_value_percentage['percentage'].' %'?></strong></td>
						
					<?php elseif($mop_value_percentage['value'] == $methods_of_payments_values['min']):?>
						
						<td class="centered min"><strong><?php echo $mop_value_percentage['value']?></strong></td>
						<td class="centered min"><strong><?php echo $mop_value_percentage['percentage'].' %'?></strong></td>
						
					<?php else:?>
					
						<td class="centered"><?php echo $mop_value_percentage['value']?></td>
						<td class="centered"><?php echo $mop_value_percentage['percentage'].' %'?></td>
						
					<?php endif;?>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<tr>
				<th><?php echo __('Total')?></th>
				<th><?php echo $methods_of_payments_values['total_value']?></th>
				<th><?php echo '100 %'?></th>
			</tr>
		</tfoot>
	</table>
	<br>
	<div style="width:100%">
		<div class="info-message-white">
	    	<span class="info-message-icon"></span>
			<em><?php echo __('Caution: The above total is not the real status of the balance. Check the dashboard to get this information.')?><br></em>
		</div>
		<div style="float:left width:auto"></div>
	</div>
	<br style="clear:left"><br><br>
	
<?php if(!$xhr):?>
	</div></div>
<?php endif;?>