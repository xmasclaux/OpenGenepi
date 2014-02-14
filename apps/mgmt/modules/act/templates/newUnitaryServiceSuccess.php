<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Unitary service')))?>

<?php include 'secondaryMenu.php' ?>

<h1><?php echo __('New unitary service')?></h1>

<script type="text/javascript">

	function show_date(){
		$('#beginning_datetime, #end_date, #recurrence_tr').show();
		$('#show_date').hide();
		$('#hide_date').show();
	}

	function hide_date(){
		$('#beginning_datetime, #end_date, #recurrence_tr').hide();
		$('#hide_date').hide();
		$('#show_date').show();
	}

	$(document).ready(function() {
		function unitary_service_insert(){
			$( "#dialog" ).dialog( { 
				width: 700,
				close: false,
				resizable: false,
				modal: true,
				draggable : false,
				buttons: {
	            	<?php echo __('Confirm') ?>: function() {
	                	document.createUnitaryService.submit(); 
	                },
	                <?php echo __('Back') ?>: function() {
	                        $(this).dialog("close");
	                }	
	        	}
			
			} );
		}

		$('form#createUnitaryService input[name="save"]').click(function(){
			var recurrence = '';
			
	        $("span#designation").html($("input#designation").val());
	        $("span#shortened_designation").html($("input#shortened_designation").val());
	        $("span#duration_temp").html($("input#duration_temp").val());

	        // For a future use
			//$("span#duration_unity").html($("#duration_unity option:selected").text());
			
			$("span#duration_unity").html($("select :selected").text());
			
			/* For a future use
			
			if($("select#beginning_datetime_day").val())
			{
	        	$("span#beginning_datetime_day").html($("select#beginning_datetime_day").val()+"/");
			}
			else
			{
				$("span#beginning_datetime_day").html(null);
			}

			if($("select#beginning_datetime_month").val())
			{
	        	$("span#beginning_datetime_month").html($("select#beginning_datetime_month").val()+"/");
			}
			else
			{
				$("span#beginning_datetime_month").html(null);
			}
			
			if($("select#beginning_datetime_year").val())
			{
				$("span#beginning_datetime_year").html($("select#beginning_datetime_year").val()+" - ");
			}
			else
			{
				$("span#beginning_datetime_year").html(null);
			}
			
			if($("select#beginning_datetime_hour").val())
			{
				$("span#beginning_datetime_hour").html($("select#beginning_datetime_hour").val()+":");
			}
			else
			{
				$("span#beginning_datetime_hour").html(null);
			}

			if($("select#beginning_datetime_minute").val())
			{
				$("span#beginning_datetime_minute").html($("select#beginning_datetime_minute").val());
			}
			else
			{
				$("span#beginning_datetime_minute").html(null);
			}

			if($("select#end_date_day").val())
			{
				$("span#end_date_day").html($("select#end_date_day").val()+"/");
			}
			else
			{
				$("span#end_date_day").html(null);
			}
			
			if($("select#end_date_month").val())
			{
				$("span#end_date_month").html($("select#end_date_month").val()+"/");
			}
			else
			{
				$("span#end_date_month").html(null);
			}
			
	        $("span#end_date_year").html($("select#end_date_year").val());*/

	        $("span#comment").html($("textarea#comment").val());

	        /*$("div#recurrence input[type=checkbox]:checked").each(function(){  
				recurrence += " " + $(this).next("label").html();
		    });
	        $("span#recurrence").html(recurrence);*/
	        
	        unitary_service_insert();
	        return false;
	    });
	});
</script>

<div id="dialog" title="<?php echo __("New predefined unitary service")?>" style="display:none">
	<p><?php echo __("Do you wish to confirm the creation of this act ?") ?></p>
	<span style="font-weight: bold;"><?php echo $form['designation']->renderLabel()." : " ?></span><span id ="designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['shortened_designation']->renderLabel()." : " ?></span><span id ="shortened_designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo __('Duration')." : " ?></span><span id ="duration_temp"></span><?php echo " "?><span id ="duration_unity"></span>
	<br />
	<!--  For a future use
	<span style="font-weight: bold;"><?php //echo $form['beginning_datetime']->renderLabel()." : " ?></span>
		<span id ="beginning_datetime_day"></span>
		<span id ="beginning_datetime_month"></span>
		<span id ="beginning_datetime_year"></span>
		<span id ="beginning_datetime_hour"></span>
		<span id ="beginning_datetime_minute"></span>
	<br />
	<span style="font-weight: bold;"><?php //echo $form['end_date']->renderLabel()." : " ?></span>
		<span id ="end_date_day"></span>
		<span id ="end_date_month"></span>
		<span id ="end_date_year"></span>
	<br />
	<span style="font-weight: bold;"><?php //echo $form['recurrence']->renderLabel()." :" ?></span>
		<span id ="recurrence"></span>
	<br />
	-->
	<span style="font-weight: bold;"><?php echo $form['comment']->renderLabel()." : " ?></span><span id ="comment"></span>
	<br />
	<p><?php echo __("The fields name, shortened name and duration will not be editable.") ?></p>
</div>

<div class="info-message-white">
	<span class="info-message-icon"></span>
	<em>
		<?php echo __('An unitary service is the only act of which duration is recorded.')?>
		<?php echo __('The keyed duration at the time of the imputation of this act will permit to realize calculated statistics.')?>
	</em>
</div>
<br /><br />

<?php echo $form->renderGlobalErrors()?>
<form name="createUnitaryService" id="createUnitaryService" action="<?php echo url_for('act/createUnitaryService') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="panel">
  <table class="formTable">
    <tbody>
      <tr>
        <th><?php echo $form['designation']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['designation']->renderError() ?>
          <?php echo $form['designation'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['shortened_designation']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['shortened_designation']->renderError() ?>
          <?php echo $form['shortened_designation'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['duration_temp']->renderLabel().' *'?></th>
        <td>
          <?php echo $form['duration_temp']->renderError() ?>
          <?php echo $form['duration_temp'] ?>
          <?php echo $form['duration_unity']->renderError() ?>
          <?php echo $form['duration_unity'] ?>
        </td>
        <td rowspan = 1>
          <div class="info-message-white">
			 <span class="info-message-icon"></span>
			  <em><?php echo __('Default value, it can be adjusted at the time of the imputation.')?></em>
		  </div>
		</td>
      </tr>
      <!--  For a future use -->
      <!--
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      
      <tr id="show_date">
        <td colspan = 2 style="text-align:center;">
      		<input type="button" onclick="show_date();" value="<?php //echo __('Date this act')?>"></input>
      	</td>
      </tr>
      <tr id="hide_date" style="display:none;">
        <td colspan = 2 style="text-align:center;">
      		<input type="button" onclick="hide_date();" value="<?php //echo __('Hide')?>"></input>
      	</td>
      </tr>-->
	  <tr style="display:none;" id="beginning_datetime">
        <th><?php echo $form['beginning_datetime']->renderLabel() ?></th>
        <td>
          <?php echo $form['beginning_datetime']->renderError() ?>
          <?php echo $form['beginning_datetime'] ?>
        </td>
      </tr>
      <tr style="display:none;" id="recurrence_tr">
        <th><?php echo __('Recurrence')?></th>
        <td>
        	<div id="recurrence">
	          <?php echo $form['recurrence_monday']->renderError() ?>
	          <?php echo $form['recurrence_monday'] ?>
	          <?php echo $form['recurrence_monday']->renderLabel() ?>
	          <br />
	          <?php echo $form['recurrence_tuesday']->renderError() ?>
	          <?php echo $form['recurrence_tuesday'] ?>
	          <?php echo $form['recurrence_tuesday']->renderLabel() ?>
	          <br />
	          <?php echo $form['recurrence_wednesday']->renderError() ?>
	          <?php echo $form['recurrence_wednesday'] ?>
	          <?php echo $form['recurrence_wednesday']->renderLabel() ?>
	          <br />
	          <?php echo $form['recurrence_thursday']->renderError() ?>
	          <?php echo $form['recurrence_thursday'] ?>
	          <?php echo $form['recurrence_thursday']->renderLabel() ?>
	          <br />
	          <?php echo $form['recurrence_friday']->renderError() ?>
	          <?php echo $form['recurrence_friday'] ?>
	          <?php echo $form['recurrence_friday']->renderLabel() ?>
	          <br />
	          <?php echo $form['recurrence_saturday']->renderError() ?>
	          <?php echo $form['recurrence_saturday'] ?>
	          <?php echo $form['recurrence_saturday']->renderLabel() ?>
	          <br />
	          <?php echo $form['recurrence_sunday']->renderError() ?>
	          <?php echo $form['recurrence_sunday'] ?>
	          <?php echo $form['recurrence_sunday']->renderLabel() ?>
	        </div>
        </td>
      </tr>
      <tr style="display:none;" id="end_date">
        <th><?php echo $form['end_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['end_date']->renderError() ?>
          <?php echo $form['end_date'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['comment']->renderLabel() ?></th>
        <td>
          <?php echo $form['comment']->renderError() ?>
          <?php echo $form['comment'] ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index#unitary-services') ?>';">
          <div class="rightAlignement"><input type="button" name="save" value="<?php echo __('Save')."..."?>"></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>