<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Purchase')))?>

<?php include 'secondaryMenu.php' ?>

<h1><?php echo __('New purchase')?></h1>

<script type="text/javascript">
	$(document).ready(function() {
		
		function purchase_insert(){
			$( "#dialog" ).dialog( { 
				width: 700,
				close: false,
				resizable: false,
				modal: true,
				draggable : false,
				buttons: {
	            	<?php echo __('Confirm') ?>: function() {
	                	document.createPurchase.submit(); 
	                },
	                <?php echo __('Back') ?>: function() {
	                        $(this).dialog("close");
	                }	
	        	}
			
			} );
		}
	
		$('form#createPurchase input[name="save"]').click(function(){
	        $("span#designation").html($("input#designation").val());
	        $("span#shortened_designation").html($("input#shortened_designation").val());
	        $("span#comment").html($("textarea#comment").val());
			purchase_insert();
	        return false;
	    });
	    
	});
</script>

<div id="dialog" title="<?php echo __("New predefined purchase")?>" style="display:none">
	<p><?php echo __("Do you wish to confirm the creation of this act ?") ?></p>
	<span style="font-weight: bold;"><?php echo $form['designation']->renderLabel()." : " ?></span><span id ="designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['shortened_designation']->renderLabel()." : " ?></span><span id ="shortened_designation"></span>
	<br />
	<span style="font-weight: bold;"><?php echo $form['comment']->renderLabel()." : " ?></span><span id ="comment"></span>
	
	<p><?php echo __("The fields name and shortened name will not be editable.") ?></p>
</div>

<?php echo $form->renderGlobalErrors()?>
<form name="createPurchase" id="createPurchase" action="<?php echo url_for('act/createPurchase') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index#purchases') ?>';">
          <div class="rightAlignement">
	          	<input type="button" name="save" value="<?php echo __('Save')."..."?>"></input>
          </div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>