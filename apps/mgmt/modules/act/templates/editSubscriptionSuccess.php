<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Subscription')))?>

<?php include 'secondaryMenu.php' ?>

<h1><?php echo __('Edit predefined subscription')?></h1>

<script type="text/javascript">
	function subscription_deletion(){
		$( "#dialog" ).dialog( { 
			width: 600,
			close: false,
			resizable: false,
			modal: true,
			draggable: false
		} );
	}
	$(document).ready(function() {
		$("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
	});
</script>

<div id="dialog" title="<?php echo __("Predefined subscription deletion")?>" style="display:none">
	<p><?php echo __("Caution, this act will be deleted and won't be imputable anymore.") ?></p>
	<p><?php echo __("However, the imputations of this act will be still stored.") ?></p>
	
	<input type="button" id="back-button" value=<?php echo __('Back')?>></input>
	
	<span class="deletion-button" style="float:right; margin-top: 18px;">
		<?php echo link_to(__('Confirm'), 'act/deleteSubscription?id='.$subscriptionId, array('method' => 'delete')) ?>
	</span>
</div>

<?php echo $form->renderGlobalErrors()?>
<form action="<?php echo url_for('act/updateSubscription?id='.$subscriptionId)?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<input type="hidden" name="sf_method" value="put" />
<div class="panel">
  <table class="formTable">
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['designation']->renderLabel() ?></th>
        <td>
          <?php echo $form['designation']->renderError() ?>
          <?php echo $form['designation'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['shortened_designation']->renderLabel() ?></th>
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
		  <?php echo __($unity) ?>
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
          &nbsp;
          <?php if($index):?>
            <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index') ?>';">
          <?php else: ?>
          	<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index#subscriptions') ?>';">
          <?php endif;?>
          <span class="deletion-button" onclick="subscription_deletion();">
          	<input type="button" value="<?php echo __('Delete')."..."?>"></input>
          </span>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>