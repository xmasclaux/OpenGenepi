<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Unitary service')))?>

<?php include 'secondaryMenu.php' ?>

<h1><?php echo __('Edit predefined unitary service')?></h1>

<script type="text/javascript">
	function unitary_service_deletion(){
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

<div id="dialog" title="<?php echo __("Predefined unitary service deletion")?>" style="display:none">
	<p><?php echo __("Caution, this act will be deleted and won't be imputable anymore.") ?></p>
	<p><?php echo __("However, the imputations of this act will be still stored.") ?></p>
	
	<input type="button" id="back-button" value=<?php echo __('Back')?>></input>
	
	<span class="deletion-button" style="float:right; margin-top: 18px;">
		<?php echo link_to(__('Confirm'), 'act/deleteUnitaryService?id='.$unitaryServiceId, array('method' => 'delete')) ?>
	</span>
</div>

<?php echo $form->renderGlobalErrors()?>
<form action="<?php echo url_for('act/updateUnitaryService?id='.$unitaryServiceId) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
        <th><?php echo __('Duration')?></th>
        <td>
          <?php echo $form['duration_temp']->renderError() ?>
          <?php echo $form['duration_temp'] ?>
		  <?php echo __($unity) ?>
        </td>
      </tr>
      <!-- 
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
	  <tr>
        <th><?php echo $form['beginning_datetime']->renderLabel() ?></th>
        <td>
          <?php echo $form['beginning_datetime']->renderError() ?>
          <?php echo $form['beginning_datetime'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('Recurrence')?></th>
        <td>
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
        </td>
      </tr>
      <tr>
        <th><?php echo $form['end_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['end_date']->renderError() ?>
          <?php echo $form['end_date'] ?>
        </td>
      </tr>
      -->
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
          	<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('act/index#unitary-services') ?>';">
          <?php endif;?>
          <span class="deletion-button" onclick="unitary_service_deletion();">
          	<input type="button" value="<?php echo __('Delete')."..."?>"></input>
          </span>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>