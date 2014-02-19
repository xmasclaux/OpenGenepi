<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Multiple service')))?>

<?php include 'secondaryMenu.php' ?>

<h1><?php echo __('New multiple service')?></h1>

<script type="text/javascript">
	$(document).ready(function() {
		
		function multiple_service_insert(){
			$( "#dialog" ).dialog( { 
				width: 700,
				close: false,
				resizable: false,
				modal: true,
				draggable : false,
				buttons: {
	            	<?php echo __('Confirm') ?>: function() {
	                	document.createMultipleService.submit(); 
	                },
	                <?php echo __('Back') ?>: function() {
	                        $(this).dialog("close");
	                }	
	        	}
			
			} );
		}

		$('form#createMultipleService input[name="save"]').click(function(){
			
	        $("span#designation").html($("input#designation").val());
	        $("span#shortened_designation").html($("input#shortened_designation").val());

	        if ($('input#monetary_account:checked').val() != null) {
	    	   $("span#monetary_account").html("<?php echo __('yes')?>");
	    	   $("span#unity_id").html("<?php echo $defaultCurrency?>");
			}
	        else
	        {
	        	$("span#monetary_account").html("<?php echo __('no')?>");
	        	$("span#unity_id").html($("select :selected").text());
	        }
	        
	        $("span#quantity").html($("input#quantity").val());
			$("span#comment").html($("textarea#comment").val());
	        multiple_service_insert();
	        return false;
	    });

		$('input#monetary_account').click(function(){
			
			if($(this).is (':checked'))
			{
				$('span[id=unity], div[id=unityMessage]').hide();
				$('span[id=defaultCurrency]').show();
				$('select').val(null);
			}
			else
			{
				$('span[id=unity], div[id=unityMessage]').show();
				$('span[id=defaultCurrency]').hide();
			}
			
		});
	});
</script>

<div id="dialog" title="<?php echo __("New predefined multiple service")?>" style="display:none">
	<p><?php echo __("Do you wish to confirm the creation of this act ?") ?></p>
	<span style="font-weight: bold;"><?php echo $form['designation']->renderLabel()." : " ?></span><span id ="designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['shortened_designation']->renderLabel()." : " ?></span><span id ="shortened_designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['monetary_account']->renderLabel()." : " ?></span><span id ="monetary_account"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['quantity']->renderLabel()." : " ?></span><span id ="quantity"></span><?php echo " "?><span id ="unity_id"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['comment']->renderLabel()." : " ?></span><span id ="comment"></span>
	<br />
	<p><?php echo __("The fields name, shortened name and initial quantity will not be editable.") ?></p>
</div>

<div class="info-message-white">
	<span class="info-message-icon"></span>
	<em>
		<?php echo __('A multiple service is an act that, once imputed to an user, leads to the creation of an account.')?>
		<?php echo __('Thereafter, an user can use this account to pay for uses.')?>
	</em>
</div>
<br /><br />

<?php echo $form->renderGlobalErrors()?>
<form name="createMultipleService" id="createMultipleService" action="<?php echo url_for('act/createMultipleService') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="panel">
  <table class="formTable">
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
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
        <th><?php echo $form['monetary_account']->renderLabel().' ?'.' *' ?></th>
        <td>
          <?php echo $form['monetary_account']->renderError() ?>
          <?php echo $form['monetary_account'] ?>
        </td>
        <td rowspan = 1>
          <div class="info-message-white">
			 <span class="info-message-icon"></span>
			  <em><?php echo __('Check this box if you want to create a monetary account.')?></em>
		  </div>
      </tr>
      <tr>
        <th><?php echo $form['quantity']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['quantity']->renderError() ?>
          <?php echo $form['quantity'] ?>
          <span id="unity">
	          <?php echo $form['unity_id']->renderError() ?>
	          <?php echo $form['unity_id'] ?>
          </span>
          <span id="defaultCurrency" style="display:none">
          	<?php echo $defaultCurrency?>
          </span>
          </td>
          <td rowspan = 1>
	          <div class="info-message-white" id="unityMessage">
				  <span class="info-message-icon"></span>
				  <em><?php echo __('To add a new unity, go to the "Manage parameters" menu.')?></em>
			  </div>
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
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index#multiple-services') ?>';">
          <div class="rightAlignement"><input type="submit" name="save" value="<?php echo __('Save')."..."?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>