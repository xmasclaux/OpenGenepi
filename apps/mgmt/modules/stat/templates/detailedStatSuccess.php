<?php if(!$xhr):?>
	<?php slot('title', sprintf('GENEPI - '.__('Statistics')))?>

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
	
					$("#detailedStat").load('<?php echo url_for('stat/AjaxDetailedStat') ?>', { from: $("#formattedFrom").val(), to: $("#formattedTo").val() },
						function(data) {
							$("#dialog").dialog("close");
					} );
				});	

			});
		</script> 
	</head>
	
	<?php slot('secondaryMenu') ?>
		<h2><?php echo __('Functionalities')?></h2>
		<h3 class = "selected"><?php echo __('Detailed statistics')?></h3>
		<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/quantitativeStatementIndex')?>')"><?php echo __('Quantitative statement')?></a></h3>
		<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/temporalStatementIndex')?>')"><?php echo __('Temporal statement')?></a></h3>
		<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/balanceIndex')?>')"><?php echo __('Balance')?></a></h3>
		<h3><a href="javascript:urlForAnotherStatPage('<?php echo url_for('stat/exportIndex') ?>')"><?php echo __('Export')?></a></h3>
		<h3><a href="<?php echo url_for('stat/uploadIndex') ?>"><?php echo __('Upload/Download')?></a></h3>
	<?php end_slot(); ?>
	
	<h1><?php echo __('Detailed statistics')?></h1>
	
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

<script type="text/javascript"> 
	$(function(){
		$('#country_city tbody tr.group').click(function() {
			$(this).siblings().toggle();
			$(this).children('td').toggleClass("expand_group");
   			return false;
		});

		$('#daysTable tbody tr.group, #timeslotsTable tbody tr.second_group, #buildingsTable tbody tr.group, #roomsTable tbody tr.second_group').click(function() {
			$(this).next('tr').toggle();
			$(this).children('td').toggleClass("expand_group");
		});
	});

	function resizeTables()
	{
		$("td[id='tableInclude']").each(function(index) {
			var sizeOfTdInclude = this.clientWidth;

			$(this).children("table").each(function(index) {
				var sizeOfIncludedTable = this.clientWidth;
				var difference = (sizeOfTdInclude-sizeOfIncludedTable);
				this.style.width = (sizeOfIncludedTable+difference+1)+"px";
			});
		});

		$("td[id='tableInclude2']").each(function(index) {
			var sizeOfTdInclude = this.clientWidth;

			$(this).children("table").each(function(index) {
				var sizeOfIncludedTable = this.clientWidth;
				var difference = (sizeOfTdInclude-sizeOfIncludedTable);
				this.style.width = (sizeOfIncludedTable+difference+1)+"px";
			});
		});
	}

	function createButtons(){ 
	$('a[href*=#]').not('a[href=#]').bind('click', function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		    var $target = $(this.hash);
		    $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
		    if ($target.length) {
			    var targetOffset = $target.offset().top;
			    $('html,body').animate({scrollTop: targetOffset}, "normal");
			    return false;
	    	}
		}
	});
	
	$("a[id=top]").each(function(){
		
		$(this).css('font-size', '11px');
		$(this).button({
			icons: {
				primary: "ui-icon-triangle-1-n"
			}	
		});
	});};
	
	$(document).ready(function() {
		resizeTables();

		createButtons();
		
		$('#timeslotsTable tbody tr.second_group').next('tr').toggle();
		$('#timeslotsTable tbody tr.second_group').children('td').toggleClass("expand_group");

		$('#roomsTable tbody tr.second_group').next('tr').toggle();
		$('#roomsTable tbody tr.second_group').children('td').toggleClass("expand_group");
	});
</script>

<?php if($numberImputations !=0):?>

	<div class="panel">
		<h6>
			<?php echo __('By gender')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Gender') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td class="important"><?php echo __('Male') ?></td>
		      <?php if($genderStats["male"][0] == $genderStats["maxUses"]):?>
			  	  <td class="centered max"><?php echo $genderStats["male"][0]?></td>
			  	  <td class="centered max"><?php echo $genderStats["male"][1]."%"?></td>
			  <?php else:?>
			  	  <td class="centered min"><?php echo $genderStats["male"][0]?></td>
			  	  <td class="centered min"><?php echo $genderStats["male"][1]."%"?></td>
			  <?php endif;?>	  
		      <?php if($genderStats["male"][2] == $genderStats["maxTime"]):?>
			  	  <td class="centered max"><?php echo gmdate('G', $genderStats["male"][2]).'h'.gmdate('i', $genderStats["male"][2])?></td>
			  <?php else:?>
			  	  <td class="centered min"><?php echo gmdate('G', $genderStats["male"][2]).'h'.gmdate('i', $genderStats["male"][2])?></td>
			  <?php endif;?>
		    </tr>
		    <tr>
		      <td class="important"><?php echo __('Female') ?></td>
		      <?php if($genderStats["female"][0] == $genderStats["maxUses"]):?>
			  	  <td class="centered max"><?php echo $genderStats["female"][0]?></td>
			  	  <td class="centered max"><?php echo $genderStats["female"][1]."%"?></td>
			  <?php else:?>
			  	  <td class="centered min"><?php echo $genderStats["female"][0]?></td>
			  	  <td class="centered min"><?php echo $genderStats["female"][1]."%"?></td>
			  <?php endif;?>	  
		      <?php if($genderStats["female"][2] == $genderStats["maxTime"]):?>
			  	  <td class="centered max"><?php echo gmdate('G', $genderStats["female"][2]).'h'.gmdate('i', $genderStats["female"][2])?></td>
			  <?php else:?>
			  	  <td class="centered min"><?php echo gmdate('G', $genderStats["female"][2]).'h'.gmdate('i', $genderStats["female"][2])?></td>
			  <?php endif;?>
		    </tr>
		  </tbody>
		  <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
		
		<br />
		
		<h6>
			<?php echo __('By age range')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Age range') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		    <?php foreach($ageRangeStats as $ageRangeStat):?>
			    <tr>
			      <td class="important"><?php echo $ageRangeStat[0]?></td>
			      <?php if($ageRangeStat[1] == $ageRangeStats[0]['maxUses']): ?>
				  	  <td class="centered max"><?php echo $ageRangeStat[1]?></td>
				  	  <td class="centered max"><?php echo $ageRangeStat[2]."%"?></td>
			      <?php elseif($ageRangeStat[1] == $ageRangeStats[0]['minUses']): ?>
				  	  <td class="centered min"><?php echo $ageRangeStat[1]?></td>
				  	  <td class="centered min"><?php echo $ageRangeStat[2]."%"?></td>
			      <?php else: ?>
				  	  <td class="centered"><?php echo $ageRangeStat[1]?></td>
				  	  <td class="centered"><?php echo $ageRangeStat[2]."%"?></td>
				  <?php endif;?>
				  <?php if($ageRangeStat[3] == $ageRangeStats[0]['maxTime']): ?>
				  	  <td class="centered max"><?php echo gmdate('G', $ageRangeStat[3]).'h'.gmdate('i', $ageRangeStat[3])?></td>
				  <?php elseif($ageRangeStat[3] == $ageRangeStats[0]['minTime']): ?>
				  	  <td class="centered min"><?php echo gmdate('G', $ageRangeStat[3]).'h'.gmdate('i', $ageRangeStat[3])?></td>
				  <?php else:?>
					  <td class="centered"><?php echo gmdate('G', $ageRangeStat[3]).'h'.gmdate('i', $ageRangeStat[3])?></td>
				  <?php endif;?>
			    </tr>
		    <?php endforeach;?>
		  </tbody>
		  <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		      </tr>
		  </tfoot>
		</table>
		
		<br />
		
		<h6>
			<?php echo __('By countries/cities')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat" id="country_city">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Country/city') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <?php foreach($countries as $country):?>
		  	<tbody>
			  	<tr class="group">
			  		<td class="importantLeft">
			  			<span>
			  				<?php echo __($country)?>
			  			</span>
			  		</td>
					<td class="important"><?php echo $countryCityStats[$country][0]?></td>
					<td class="important"><?php echo $countryCityStats[$country][1]."%"?></td>
					<td class="important"><?php echo gmdate('G', $countryCityStats[$country][2]).'h'.gmdate('i', $countryCityStats[$country][2])?></td>
			  	</tr>
			  	<?php foreach($cities[$country] as $city):?>
				  	<tr>
					  	<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $city?></td>
					  	<?php if($countryCityStats[$country][$city][0] == $countryCityStats[$country]['maxUses']): ?>
					  		<td class="centered max"><?php echo $countryCityStats[$country][$city][0]?></td>
							<td class="centered max"><?php echo $countryCityStats[$country][$city][1]."%"?></td>
						<?php elseif($countryCityStats[$country][$city][0] == $countryCityStats[$country]['minUses']): ?>
							<td class="centered min"><?php echo $countryCityStats[$country][$city][0]?></td>
							<td class="centered min"><?php echo $countryCityStats[$country][$city][1]."%"?></td>
						<?php else:?>	
							<td class="centered"><?php echo $countryCityStats[$country][$city][0]?></td>
							<td class="centered"><?php echo $countryCityStats[$country][$city][1]."%"?></td>
						<?php endif;?>
						<?php if($countryCityStats[$country][$city][2] == $countryCityStats[$country]['maxTime']):?>
							<td class="centered max"><?php echo gmdate('G', $countryCityStats[$country][$city][2]).'h'.gmdate('i', $countryCityStats[$country][$city][2])?></td>
						<?php elseif($countryCityStats[$country][$city][2] == $countryCityStats[$country]['minTime']):?>	
							<td class="centered min"><?php echo gmdate('G', $countryCityStats[$country][$city][2]).'h'.gmdate('i', $countryCityStats[$country][$city][2])?></td>
				  		<?php else:?>
				  			<td class="centered"><?php echo gmdate('G', $countryCityStats[$country][$city][2]).'h'.gmdate('i', $countryCityStats[$country][$city][2])?></td>
				  		<?php endif;?>
				  	</tr>
				<?php endforeach;?>
			 </tbody>
		  <?php endforeach;?>
		    <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
		
		<br />
<?php		
    // -----------------------------------------------------------------------------------------------------------
    // KYXAR 0010 - 30/10/2012
    // Tableau par jour
?>

		<h6>
			<?php echo __('By day')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat" id="daysTable">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Day') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <?php foreach($days as $day):?>
			<tbody>
			    <tr>
			  		<td class="important">
			  			<span>
			  				<?php echo __($day)?>
			  			</span>
			  		</td>
			  		
			  		<?php if(isset($dayStats[$day])):?>
			  			<?php if($dayStats[$day][0] == $dayStats['maxUses']):?>
			  				<td class="centered max">
				  				<?php echo $dayStats[$day][0]?>
			  				</td>
			  				<td class="centered max">
				  				<?php echo $dayStats[$day][1]."%"?>
			  				</td>
			  				
			  			<?php elseif($dayStats[$day][0] == $dayStats['minUses']):?>	
			  				<td class="centered min">
				  				<?php echo $dayStats[$day][0]?>
			  				</td>
			  				<td class="centered min">
				  				<?php echo $dayStats[$day][1]."%"?>
			  				</td>
			  				
			  			<?php else:?>
			  				<td class="centered">
				  				<?php echo $dayStats[$day][0]?>
			  				</td>
			  				<td class="centered min">
				  				<?php echo $dayStats[$day][1]."%"?>
			  				</td>
			  			<?php endif;?>
			  			
			  			<?php if(isset($dayStats[$day])):?>
				  			<?php if($dayStats[$day][2] == $dayStats['maxTime']):?>
				  				<td class="centered max">
					  				<?php echo gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2])?>
				  				</td>
				  			<?php elseif($dayStats[$day][2] == $dayStats['minTime']):?>	
				  				<td class="centered min">
					  				<?php echo gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2])?>
				  				</td>
				  			<?php else:?>
				  				<td class="centered">
					  				<?php echo gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2])?>
				  				</td>
				  			<?php endif;?>
						<?php endif;?>
					<?php else :?>
						<td class="centered">
				  				<?php echo "0"?>
			  			</td>
			  			<td class="centered">
				  				<?php echo "0%"?>
			  			</td>
			  			<td class="centered">
				  				<?php echo "0h00"?>
			  			</td>
					<?php endif;?>
			  	</tr>
		   </tbody>
		   <?php endforeach;?>
		  <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
		
		<br />
		
<?php
	// FIN KYXAR
    // -----------------------------------------------------------------------------------------------------------
?>


<?php		
    // -----------------------------------------------------------------------------------------------------------
    // KYXAR 0010 - 30/10/2012
    // Tableau par tranche horaire
?>

		<h6>
			<?php echo __('By time slot')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat" id="daysTable">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Time slot') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  
		  <tbody>
          <?php foreach ($timeslots as $timeslot):?>
  		    <tr>
	  		  <td class="important">
	  			 <span>
	  				<?php echo $timeslot?>
  			     </span>
  		     </td>
  		     
  		     	    <?php
  		     	    if ($TimeSlotStats[$timeslot][0] == $TimeSlotStats['maxUses']) echo "<td class=\"centered max\">\n";
  		     	    else if ($TimeSlotStats[$timeslot][0] == $TimeSlotStats['minUses']) echo "<td class=\"centered min\">\n";
  		     	    else echo "<td class=\"centered\">\n";
  		     	    if ( isset($TimeSlotStats[$timeslot][0]) )
  		     	    	echo $TimeSlotStats[$timeslot][0];
  		     	    else
  		     	   		echo 0;
  		     	    ?>
  		     </td>

  		     	   <?php
  		     	   if ($TimeSlotStats[$timeslot][0] == $TimeSlotStats['maxUses']) echo "<td class=\"centered max\">\n";
  		     	   else if ($TimeSlotStats[$timeslot][0] == $TimeSlotStats['minUses']) echo "<td class=\"centered min\">\n";
  		     	   else echo "<td class=\"centered\">\n";
  		     	   echo $TimeSlotStats[$timeslot][1]."%";
  		     	   ?>
  		     </td>

  		           <?php
  		           if ($TimeSlotStats[$timeslot][0] == $TimeSlotStats['maxUses']) echo "<td class=\"centered max\">\n";
  		           else if ($TimeSlotStats[$timeslot][0] == $TimeSlotStats['minUses']) echo "<td class=\"centered min\">\n";
  		           else echo "<td class=\"centered\">\n";
  		           echo gmdate('G', $TimeSlotStats[$timeslot][2]).'h'.gmdate('i', $TimeSlotStats[$timeslot][2]);
  		           ?>
  		     </td>
  		    </tr>
          <?php endforeach;?>
		  <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
          </tbody>
        </table>
        
        <br />
<?php
	// FIN KYXAR
    // -----------------------------------------------------------------------------------------------------------
?>


		<h6>
			<?php echo __('By day/time slot')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat" id="daysTable">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Day/time slot') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <?php foreach($days as $day):?>
			<tbody>
			    <tr class="group">
			  		<td class="importantLeft">
			  			<span>
			  				<?php echo __($day)?>
			  			</span>
			  		</td>
			  		
			  		<?php if(isset($dayStats[$day])):?>
			  			<?php if($dayStats[$day][0] == $dayStats['maxUses']):?>
			  				<td class="important max">
				  				<?php echo $dayStats[$day][0]?>
			  				</td>
			  				<td class="important max">
				  				<?php echo $dayStats[$day][1]."%"?>
			  				</td>
			  				
			  			<?php elseif($dayStats[$day][0] == $dayStats['minUses']):?>	
			  				<td class="important min">
				  				<?php echo $dayStats[$day][0]?>
			  				</td>
			  				<td class="important min">
				  				<?php echo $dayStats[$day][1]."%"?>
			  				</td>
			  				
			  			<?php else:?>
			  				<td class="important">
				  				<?php echo $dayStats[$day][0]?>
			  				</td>
			  				<td class="important min">
				  				<?php echo $dayStats[$day][1]."%"?>
			  				</td>
			  			<?php endif;?>
			  			
			  			<?php if(isset($dayStats[$day])):?>
				  			<?php if($dayStats[$day][2] == $dayStats['maxTime']):?>
				  				<td class="important max">
					  				<?php echo gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2])?>
				  				</td>
				  			<?php elseif($dayStats[$day][2] == $dayStats['minTime']):?>	
				  				<td class="important min">
					  				<?php echo gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2])?>
				  				</td>
				  			<?php else:?>
				  				<td class="important">
					  				<?php echo gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2])?>
				  				</td>
				  			<?php endif;?>
						<?php endif;?>
					<?php else :?>
						<td class="important">
				  				<?php echo "0"?>
			  			</td>
			  			<td class="important">
				  				<?php echo "0%"?>
			  			</td>
			  			<td class="important">
				  				<?php echo "0h00"?>
			  			</td>
					<?php endif;?>
			  	</tr>
			  	<tr>
			  	    <td colspan="4" id="tableInclude">
			  	      <table class="threeColumsStat nobordertable" id="timeslotsTable">
				  		<?php foreach ($timeslots as $timeslot):?>
				  			<tbody>
						  		<tr class="second_group">
							  		<td>
							  			<span>
							  				<?php echo $timeslot?>
							  			</span>
							  		</td>
							  		<?php if(isset($dayAndTimeSlotStats[$day])):?>
								  		<?php if(isset($dayAndTimeSlotStats[$day][$timeslot])): ?>
								  			<?php if($dayAndTimeSlotStats[$day][$timeslot][0] == $dayAndTimeSlotStats[$day]['maxUses']):?>
												<td class="centered max">
													<?php echo $dayAndTimeSlotStats[$day][$timeslot][0]?>
												</td>
												<td class="centered max">
													<?php echo $dayAndTimeSlotStats[$day][$timeslot][1]."%"?>
												</td>
											<?php elseif($dayAndTimeSlotStats[$day][$timeslot][0] == $dayAndTimeSlotStats[$day]['minUses']):?>
												<td class="centered min">
													<?php echo $dayAndTimeSlotStats[$day][$timeslot][0]?>
												</td>
												<td class="centered min">
													<?php echo $dayAndTimeSlotStats[$day][$timeslot][1]."%"?>
												</td>
											<?php else:?>
												<td class="centered">
													<?php echo $dayAndTimeSlotStats[$day][$timeslot][0]?>
												</td>
												<td class="centered">
													<?php echo $dayAndTimeSlotStats[$day][$timeslot][1]."%"?>
												</td>
											<?php endif;?>
											<?php if($dayAndTimeSlotStats[$day][$timeslot][2] == $dayAndTimeSlotStats[$day]['maxTime']):?>
												<td class="centered max">
													<?php echo gmdate('G', $dayAndTimeSlotStats[$day][$timeslot][2]).'h'.gmdate('i', $dayAndTimeSlotStats[$day][$timeslot][2])?>
												</td>
											<?php elseif($dayAndTimeSlotStats[$day][$timeslot][2] == $dayAndTimeSlotStats[$day]['minTime']):?>
												<td class="centered min">
													<?php echo gmdate('G', $dayAndTimeSlotStats[$day][$timeslot][2]).'h'.gmdate('i', $dayAndTimeSlotStats[$day][$timeslot][2])?>
												</td>
											<?php else:?>
												<td class="centered">
													<?php echo gmdate('G', $dayAndTimeSlotStats[$day][$timeslot][2]).'h'.gmdate('i', $dayAndTimeSlotStats[$day][$timeslot][2])?>
												</td>
											<?php endif;?>
										<?php else:?>
											<td class="centered">
												<?php echo "0"?>
											</td>
											<td class="centered">
												<?php echo "0%"?>
											</td>
											<td class="centered">
												<?php echo "0h00"?>
											</td>
										<?php endif;?>
									<?php else:?>
										<td class="centered">
											<?php echo "0"?>
										</td>
										<td class="centered">
											<?php echo "0%"?>
										</td>
										<td class="centered">
											<?php echo "0h00"?>
										</td>
									<?php endif;?>
						  		</tr>
						  		<tr>
							  	    <td colspan="4" id="tableInclude2">
							  	      <table class="threeColumsStat nobordertable" id="hoursTable">
							  	        <tbody>
								  			<?php foreach ($hours[$timeslot] as $hour):?>
										  		<tr class="third_group">
											  		<td>
											  			<span>
											  				<?php echo $hour?>
											  			</span>
											  		</td>
											  		<?php if(isset($hourStats[$day])):?>
														<td class="centered">
														  <?php if(isset($hourStats[$day][$hour])):?>
																<?php echo $hourStats[$day][$hour][0]?>
															<?php else:?>
																<?php echo "0";?>
															<?php endif;?>
														</td>
														<td class="centered">
															<?php if(isset($hourStats[$day][$hour])):?>
																<?php echo $hourStats[$day][$hour][1]."%"?>
														    <?php else:?>
																<?php echo "0%"?>
														    <?php endif;?>
														</td>
														<td class="centered">
															<?php if(isset($hourStats[$day][$hour])):?>
																<?php echo gmdate('G', $hourStats[$day][$hour][2]).'h'.gmdate('i', $hourStats[$day][$hour][2])?>
														    <?php else:?>
																<?php echo "0h00"?>
														    <?php endif;?>
														</td>
													<?php else:?>
														<td class="centered">
															<?php echo "0";?>
														</td>
														<td class="centered">
															<?php echo "0%"?>
														</td>
														<td class="centered">
															<?php echo "0h00"?>
														</td>
													<?php endif;?>
										  		</tr>
										  	<?php endforeach;?>
						  				</tbody>
						  			  </table>
						  			</td>
						  		</tr>
						  	</tbody>
				  		<?php endforeach;?>
			  			
			  		</table>
			  	  </td>
			  	</tr>
		  	</tbody>
		  <?php endforeach;?>
		  <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
		
		<br />
		
		<h6>
			<?php echo __('By public category')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Public category') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		    <?php foreach($publicCategoryStats['cat'] as $category => $publicCategoryStat):?>
		    	<tr>
			      	<td class="important">
			      		<?php echo __($category) ?>
			      	</td>
			      	<?php if(isset($publicCategoryStat)):?>
				      	<?php if($publicCategoryStat[0] == $publicCategoryStats['maxUses']):?>
					      	<td class="centered max">
					      		<?php echo $publicCategoryStat[0]?>
					      	</td>
				      		<td class="centered max">
				      			<?php echo $publicCategoryStat[1]."%"?>
				      		</td>
				      	<?php elseif($publicCategoryStat[0] == $publicCategoryStats['minUses']):?>
				      		<td class="centered min">
					      		<?php echo $publicCategoryStat[0]?>
					      	</td>
				      		<td class="centered min">
				      			<?php echo $publicCategoryStat[1]."%"?>
				      		</td>
				      	<?php else:?>
				      		<td class="centered">
					      		<?php echo $publicCategoryStat[0]?>
					      	</td>
				      		<td class="centered">
				      			<?php echo $publicCategoryStat[1]."%"?>
				      		</td>
				      	<?php endif;?>
				      	<?php if($publicCategoryStat[2] == $publicCategoryStats['maxTime']):?>
			      			<td class="centered max">
			      				<?php echo gmdate('G', $publicCategoryStat[2]).'h'.gmdate('i', $publicCategoryStat[2])?>
			      			</td>
			      		<?php elseif($publicCategoryStat[2] == $publicCategoryStats['minTime']):?>
			      			<td class="centered min">
			      				<?php echo gmdate('G', $publicCategoryStat[2]).'h'.gmdate('i', $publicCategoryStat[2])?>
			      			</td>
			      		<?php else:?>
			      			<td class="centered">
			      				<?php echo gmdate('G', $publicCategoryStat[2]).'h'.gmdate('i', $publicCategoryStat[2])?>
			      			</td>
			      		<?php endif;?>
			      	<?php else:?>
			      			<td class="centered">
					      		<?php echo "0"?>
					      	</td>
				      		<td class="centered">
				      			<?php echo "0%"?>
				      		</td>
				      		<td class="centered">
								<?php echo "0h00"?>
							</td>
			      	<?php endif;?>
		    	</tr>
		    <?php endforeach;?>
		  </tbody>
		  <tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
	
		<br />
		
		<h6>
			<?php echo __('By act')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Act') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		  <?php foreach($actStats['act'] as $actDesignation => $actStat):?>
		  	<tr>
		      	<td class="important">
		      		<?php echo $actDesignation ?>
		      	</td>
		      	<?php if($actStat[0] == $actStats['maxUses']):?>
		      		<td class="centered max">
		      			<?php echo $actStat[0]?>
		      		</td>
		      		<td class="centered max">
		      			<?php echo $actStat[1]."%"?>
		      		</td>
		      	<?php elseif($actStat[0] == $actStats['minUses']):?>
		      		<td class="centered min">
		      			<?php echo $actStat[0]?>
		      		</td>
		      		<td class="centered min">
		      			<?php echo $actStat[1]."%"?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo $actStat[0]?>
		      		</td>
		      		<td class="centered">
		      			<?php echo $actStat[1]."%"?>
		      		</td>
		      	<?php endif;?>
		      	<?php if($actStat[2] == $actStats['maxTime']):?>
		      		<td class="centered max">
		      			<?php echo gmdate('G', $actStat[2]).'h'.gmdate('i', $actStat[2])?>
		      		</td>
		      	<?php elseif($actStat[2] == $actStats['minTime']):?>
		      		<td class="centered min">
		      			<?php echo gmdate('G', $actStat[2]).'h'.gmdate('i', $actStat[2])?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo gmdate('G', $actStat[2]).'h'.gmdate('i', $actStat[2])?>
		      		</td>
		      	<?php endif;?>
			</tr>
	
		  <?php endforeach;?>
		</tbody>
		<tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
	
		<br />
	
		<h6>
			<?php echo __('By socio-economic group')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('SEG') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		  <?php foreach($segStats['seg'] as $segDesignation => $segStat):?>
		  	<tr>
		      	<td class="important">
		      		<?php echo __($segDesignation) ?>
		      	</td>
		      	<?php if($segStat[0] == $segStats['maxUses']):?>
		      		<td class="centered max">
		      			<?php echo $segStat[0]?>
		      		</td>
		      		<td class="centered max">
		      			<?php echo $segStat[1]."%"?>
		      		</td>
		      	<?php elseif($segStat[0] == $segStats['minUses']):?>
		      		<td class="centered min">
		      			<?php echo $segStat[0]?>
		      		</td>
		      		<td class="centered min">
		      			<?php echo $segStat[1]."%"?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo $segStat[0]?>
		      		</td>
		      		<td class="centered">
		      			<?php echo $segStat[1]."%"?>
		      		</td>
		      	<?php endif;?>
		      	<?php if($segStat[2] == $segStats['maxTime']):?>
		      		<td class="centered max">
		      			<?php echo gmdate('G', $segStat[2]).'h'.gmdate('i', $segStat[2])?>
		      		</td>
		      	<?php elseif($segStat[2] == $segStats['minTime']):?>
		      		<td class="centered min">
		      			<?php echo gmdate('G', $segStat[2]).'h'.gmdate('i', $segStat[2])?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo gmdate('G', $segStat[2]).'h'.gmdate('i', $segStat[2])?>
		      		</td>
		      	<?php endif;?>
			</tr>
	
		  <?php endforeach;?>
		</tbody>
		<tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
	
		<br />
	
		<h6>
			<?php echo __('By building/room/computer')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
	
		<table class="threeColumsStat" id="buildingsTable">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Building/room/computer') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		  <?php foreach($buildingStats['building'] as $building => $buildingStat):?>
			<tr class="group">
		      	<td class="importantLeft">
		      		<span>
		      			<?php echo $building ?>
		      		</span>
		      	</td>
		      	<?php if($buildingStat[0] == $buildingStats['maxUses']):?>
		      		<td class="important max">
		      			<?php echo $buildingStat[0]?>
		      		</td>
		      		<td class="important max">
		      			<?php echo $buildingStat[1]."%"?>
		      		</td>
		      	<?php elseif($buildingStat[0] == $buildingStats['minUses']):?>
		      		<td class="important min">
		      			<?php echo $buildingStat[0]?>
		      		</td>
		      		<td class="important min">
		      			<?php echo $buildingStat[1]."%"?>
		      		</td>
		      	<?php else:?>
		      		<td class="important">
		      			<?php echo $buildingStat[0]?>
		      		</td>
		      		<td class="important">
		      			<?php echo $buildingStat[1]."%"?>
		      		</td>
		      	<?php endif;?>
		      	<?php if($buildingStat[2] == $buildingStats['maxTime']):?>
		      		<td class="important max">
		      			<?php echo gmdate('G', $buildingStat[2]).'h'.gmdate('i', $buildingStat[2])?>
		      		</td>
		      	<?php elseif($buildingStat[2] == $buildingStats['minTime']):?>
		      		<td class="important min">
		      			<?php echo gmdate('G', $buildingStat[2]).'h'.gmdate('i', $buildingStat[2])?>
		      		</td>
		      	<?php else:?>
		      		<td class="important">
		      			<?php echo gmdate('G', $buildingStat[2]).'h'.gmdate('i', $buildingStat[2])?>
		      		</td>
		      	<?php endif;?>
			</tr>
			<tr>
		  	    <td colspan="4" id="tableInclude">
		  	      <table class="threeColumsStat nobordertable" id="roomsTable">
		  	        <?php if(isset($roomStats['room'][$building])):?>
			  		<?php foreach($roomStats['room'][$building] as $room => $roomStat):?>
			  			<tbody>
					  		<tr class="second_group">
						  		<td>
						  			<span>
						  				<?php echo $room?>
						  			</span>
						  		</td>
						  		<?php if($roomStat[0] == $roomStats[$building]['maxUses']):?>
						      		<td class="centered max">
						      			<?php echo $roomStat[0]?>
						      		</td>
						      		<td class="centered max">
						      			<?php echo $roomStat[1]."%"?>
						      		</td>
						      	<?php elseif($roomStat[0] == $roomStats[$building]['minUses']):?>
						      		<td class="centered min">
						      			<?php echo $roomStat[0]?>
						      		</td>
						      		<td class="centered min">
						      			<?php echo $roomStat[1]."%"?>
						      		</td>
						      	<?php else:?>
						      		<td class="centered">
						      			<?php echo $roomStat[0]?>
						      		</td>
						      		<td class="centered">
						      			<?php echo $roomStat[1]."%"?>
						      		</td>
						      	<?php endif;?>
						      	<?php if($roomStat[2] == $roomStats[$building]['maxTime']):?>
						      		<td class="centered max">
						      			<?php echo gmdate('G', $roomStat[2]).'h'.gmdate('i', $roomStat[2])?>
						      		</td>
						      	<?php elseif($roomStat[2] == $roomStats[$building]['minTime']):?>
						      		<td class="centered min">
						      			<?php echo gmdate('G', $roomStat[2]).'h'.gmdate('i', $roomStat[2])?>
						      		</td>
						      	<?php else:?>
						      		<td class="centered">
						      			<?php echo gmdate('G', $roomStat[2]).'h'.gmdate('i', $roomStat[2])?>
						      		</td>
						      	<?php endif;?>
						  	</tr>
						  	<tr>
						  	    <td colspan="4" id="tableInclude">
						  	      <table class="threeColumsStat nobordertable" id="computersTable">
							  		<?php foreach($computerStats['computer'][$building][$room] as $computer => $computerStat):?>
							  			<tbody>
									  		<tr class="third_group">
										  		<td>
										  			<span>
										  				<?php echo __($computer)?>
										  			</span>
										  		</td>
										      	<td class="centered">
										      		<?php echo $computerStat[0]?>
										      	</td>
										      	<td class="centered">
										      		<?php echo $computerStat[1]."%"?>
										      	</td>
									      		<td class="centered">
									      			<?php echo gmdate('G', $computerStat[2]).'h'.gmdate('i', $computerStat[2])?>
									      		</td>
										  	</tr>
										  </tbody>
									<?php endforeach;?>
								</table>
								</td>
							</tr>
						  </tbody>
					<?php endforeach;?>
					<?php endif;?>
				  </table>
				</td>
			</tr>
		  <?php endforeach;?>
		</tbody>
		<tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
	
		<br />
		
		<h6>
			<?php echo __('By type of connection')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<div class="info-message-white">
			 <span class="info-message-icon"></span>
			 <em><?php echo __('Calculated only for the uses that need a computer.')?></em>
		</div>
		
		<br /><br />
		
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Type of connection') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		  <?php foreach($typeOfConnectionStats['type'] as $typeOfConnection => $typeOfConnectionStat):?>
		  	<tr>
		      	<td class="important">
		      		<?php echo $typeOfConnection ?>
		      	</td>
		      	<?php if($typeOfConnectionStat[0] == $typeOfConnectionStats['maxUses']):?>
		      		<td class="centered max">
		      			<?php echo $typeOfConnectionStat[0]?>
		      		</td>
		      		<td class="centered max">
		      			<?php echo $typeOfConnectionStat[1]."%"?>
		      		</td>
		      	<?php elseif($typeOfConnectionStat[0] == $typeOfConnectionStats['minUses']):?>
		      		<td class="centered min">
		      			<?php echo $typeOfConnectionStat[0]?>
		      		</td>
		      		<td class="centered min">
		      			<?php echo $typeOfConnectionStat[1]."%"?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo $typeOfConnectionStat[0]?>
		      		</td>
		      		<td class="centered">
		      			<?php echo $typeOfConnectionStat[1]."%"?>
		      		</td>
		      	<?php endif;?>
		      	<?php if($typeOfConnectionStat[2] == $typeOfConnectionStats['maxTime']):?>
		      		<td class="centered max">
		      			<?php echo gmdate('G', $typeOfConnectionStat[2]).'h'.gmdate('i', $typeOfConnectionStat[2])?>
		      		</td>
		      	<?php elseif($typeOfConnectionStat[2] == $typeOfConnectionStats['minTime']):?>
		      		<td class="centered min">
		      			<?php echo gmdate('G', $typeOfConnectionStat[2]).'h'.gmdate('i', $typeOfConnectionStat[2])?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo gmdate('G', $typeOfConnectionStat[2]).'h'.gmdate('i', $typeOfConnectionStat[2])?>
		      		</td>
		      	<?php endif;?>
			</tr>
	
		  <?php endforeach;?>
		</tbody>
		<tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $typeOfConnectionStats['totalUses'] ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $typeOfConnectionStats['totalTime']).'h'.gmdate('i', $typeOfConnectionStats['totalTime'])?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
		
		<br />
		
		<h6>
			<?php echo __('By way of awareness')." : "?>
			<span class="rightAlignement" style="margin-right: 0">
				<a href="#detailedStat" id="top"><?php echo __('Top')?></a>
			</span>
		</h6>
		
		<table class="threeColumsStat">
		  <thead>
		 	 <tr>
		        <th><?php echo __('Way of awareness') ?></th>
		        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
		        <th><?php echo __('Percentage') ?></th>
		        <th><?php echo __('Time') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		  <?php foreach($awarenessStats['awareness'] as $wayOfAwareness => $awarenessStat):?>
		  	<tr>
		      	<td class="important">
		      		<?php echo __($wayOfAwareness) ?>
		      	</td>
		      	<?php if($awarenessStat[0] == $awarenessStats['maxUses']):?>
		      		<td class="centered max">
		      			<?php echo $awarenessStat[0]?>
		      		</td>
		      		<td class="centered max">
		      			<?php echo $awarenessStat[1]."%"?>
		      		</td>
		      	<?php elseif($awarenessStat[0] == $awarenessStats['minUses']):?>
		      		<td class="centered min">
		      			<?php echo $awarenessStat[0]?>
		      		</td>
		      		<td class="centered min">
		      			<?php echo $awarenessStat[1]."%"?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo $awarenessStat[0]?>
		      		</td>
		      		<td class="centered">
		      			<?php echo $awarenessStat[1]."%"?>
		      		</td>
		      	<?php endif;?>
		      	<?php if($awarenessStat[2] == $awarenessStats['maxTime']):?>
		      		<td class="centered max">
		      			<?php echo gmdate('G', $awarenessStat[2]).'h'.gmdate('i', $awarenessStat[2])?>
		      		</td>
		      	<?php elseif($awarenessStat[2] == $awarenessStats['minTime']):?>
		      		<td class="centered min">
		      			<?php echo gmdate('G', $awarenessStat[2]).'h'.gmdate('i', $awarenessStat[2])?>
		      		</td>
		      	<?php else:?>
		      		<td class="centered">
		      			<?php echo gmdate('G', $awarenessStat[2]).'h'.gmdate('i', $awarenessStat[2])?>
		      		</td>
		      	<?php endif;?>
			</tr>
	
		  <?php endforeach;?>
		</tbody>
		<tfoot>
		  	<tr>
		        <th><?php echo __('Total')?></th>
		        <th>
		        	<?php echo $numberImputations ?>
		        </th>
		        <th>
		        	<?php echo "100%"?>
		        </th>
		        <th>
		        	<?php echo gmdate('G', $totalTime).'h'.gmdate('i', $totalTime)?>
		        </th>
		    </tr>
		  </tfoot>
		</table>
	</div>
<?php else:?>
	<script type="text/javascript">
		document.getElementById('feedbackFrame').style.display = 'inherit';
		var message = "<?php echo __('No uses found between these two dates.'); ?>";
		document.getElementById('feedbackFrame').innerHTML = '<div class="feedback-info-message"><span class="info-message-icon"></span>'+message+'</div>';
	</script>
<?php endif; ?>

<?php if(!$xhr):?>
	</div></div>
<?php endif;?>