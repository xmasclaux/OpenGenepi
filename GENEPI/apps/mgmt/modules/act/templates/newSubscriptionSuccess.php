<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Subscription')))?>

<?php include 'secondaryMenu.php' ?>

<h1><?php echo __('New subscription')?></h1>

<script type="text/javascript">
	$(document).ready(function() {
		
		function subscription_insert(){
			$( "#dialog" ).dialog( { 
				width: 700,
				close: false,
				resizable: false,
				modal: true,
				draggable : false,
				buttons: {
	            	<?php echo __('Confirm') ?>: function() {
	                	document.createSubscription.submit(); 
	                },
	                <?php echo __('Back') ?>: function() {
	                        $(this).dialog("close");
	                }	
	        	}
			
			} );
		}

		$('form#createSubscription input[name="save"]').click(function(){
	        $("span#designation").html($("input#designation").val());
	        $("span#shortened_designation").html($("input#shortened_designation").val());
	        $("span#duration_temp").html($("input#duration_temp").val());
			$("span#duration_unity").html($("select :selected").text());
	        $("span#max_members").html($("input#max_members").val());

	        if($("input#extra_cost").val())
	        {
	        	$("span#extra_cost").html($("input#extra_cost").val());
	        }
	        else
	        {
	        	$("span#extra_cost").html("0");
	        }
	        
		    $("span#comment").html($("textarea#comment").val());
			subscription_insert();
	        return false;
	    });


	});
</script>



<div id="dialog" title="<?php echo __("New predefined subscription")?>" style="display:none">
	<p><?php echo __("Do you wish to confirm the creation of this act ?") ?></p>
	<span style="font-weight: bold;"><?php echo $form['designation']->renderLabel()." : " ?></span><span id ="designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['shortened_designation']->renderLabel()." : " ?></span><span id ="shortened_designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo __('Period of validity')." : " ?></span><span id ="duration_temp"></span> <?php echo " "?><span id ="duration_unity"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['comment']->renderLabel()." : " ?></span><span id ="comment"></span>
	
	<p><?php echo __("The fields name, shortened name and period of validity will not be editable.") ?></p>
</div>

<div class="info-message-white">
	<span class="info-message-icon"></span>
	<em>
		<?php echo __('A subscription is an act that allows an user to have preferential prices on the proposed acts.')?>
		<?php echo __('The imputation of a subscription to an user does not update his category : you have to do it manually.')?>
	</em>
</div>
<br /><br />

<?php echo $form->renderGlobalErrors()?>
<form name="createSubscription" id="createSubscription" action="<?php echo url_for('act/createSubscription') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
        <th><?php echo __('Period of validity') ?></th>
        <td>
          <?php echo $form['duration_temp']->renderError() ?>
          <?php echo $form['duration_temp'] ?>
          <?php echo $form['duration_unity']->renderError() ?>
          <?php echo $form['duration_unity'] ?>
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
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index#subscriptions') ?>';">
          <div class="rightAlignement"><input type="button" name="save" value="<?php echo __('Save')."..."?>"></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>