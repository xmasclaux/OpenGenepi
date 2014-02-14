<?php slot('title', sprintf('GENEPI - '.__('Export')))?>

<?php include_partial('global/messages')?>

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
					$('#form_export').show();
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

	</script> 
</head>


<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/index') ?>')"><?php echo __('Detailed statistics')?></a></h3>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/quantitativeStatementIndex') ?>')"><?php echo __('Quantitative statement')?></a></h3>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/temporalStatement') ?>')"><?php echo __('Temporal statement')?></a></h3>
	<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/balanceIndex') ?>')"><?php echo __('Balance')?></a></h3>
	<h3 class = "selected"><?php echo __('Export')?></h3>
	<h3><a href="<?php echo url_for('stat/uploadIndex') ?>"><?php echo __('Upload/Download')?></a></h3>
<?php end_slot(); ?>


<h1><?php echo __('Statistics exportation')?></h1>

<div id="form_export">
	<form name="form_export" action="<?php echo url_for('stat/export')?>" method="post">
		<div class="panel">
			<h6><?php echo __('Select a period')." : "?></h6>
			
			<label for="from"><?php echo __('From the')?></label> 
			<input type="text" id="from" name="from" class="datepicker" value="<?php echo isset($from) ? date_format(date_create($from), __('m/d/Y')) : date(__('m/d/Y'))?>"/> 
			<label for="to"><?php echo __('to the')?></label> 
			<input type="text" id="to" name="to" class="datepicker" value="<?php echo isset($to) ? date_format(date_create($to), __('m/d/Y')) : date(__('m/d/Y'),strtotime('+1 day'))?>"/> 
			<input type="hidden" id="formattedFrom" name="formattedFrom" value="<?php echo isset($from) ? date_format(date_create($from), __('Y-m-d')) : date(__('Y-m-d'))?>"/>
			<input type="hidden" id="formattedTo" name="formattedTo" value="<?php echo isset($to) ? date_format(date_create($to), __('Y-m-d')) : date(__('Y-m-d'),strtotime('+1 day'))?>"/>
			<br />
			<br />
		</div>

		<?php echo $form->renderGlobalErrors() ?>
		<center>
		<table class="formTable">
			<tbody>
				<tr>
					<th style="text-align: center"><?php echo __('Export')?></th>
					<th style="text-align: center"><?php echo $form['format']->renderLabel() ?></th>
				</tr>
				<tr>
					<td>
						<div class="panel">
							<table class="formTable">
								<tr>
									<td style="text-align:left"><?php echo $form['ressource'] ?></td>
								</tr>
							</table>
						</div>
					</td>
					
					<td>
						<div class="panel">
							<table class="formTable">
								<tr>
									<td style="text-align:left"><?php echo $form['format']?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>

			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<div class="info-message-white" style="margin: 13px">
					    	<span class="info-message-icon"></span>
							<em><?php echo __('The PDF export is not recommended for the statements.')?><br></em>
						</div>
						<?php echo $form->renderHiddenFields() ?>
						<div class="rightAlignement"><input type="submit" value="<?php echo __('Export')?>" /></input></div>
					</td>
				</tr>
			</tfoot>
		</table>
		</center>
</form>
</div>