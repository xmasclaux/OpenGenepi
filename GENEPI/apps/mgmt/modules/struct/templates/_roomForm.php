<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Room')))?>

<?php include 'secondaryMenu.php'?>

<script type="text/javascript">
	function room_deletion(){
		$( "#dialog" ).dialog( { 
			width: 600,
			close: false,
			resizable: false,
			modal: true
		} );
	}
</script>

<form action="<?php echo url_for('struct/'.($form->getObject()->isNew() ? 'createRoom' : 'updateRoom').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
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
        <th><?php echo $form['building_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['building_id']->renderError() ?>
          <?php echo $form['building_id'] ?>
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
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('struct/index#rooms') ?>';">
          <?php if (!$form->getObject()->isNew()): ?>
          		<span class="deletion-button" onclick="room_deletion();">
          			<input type="button" value="<?php echo __('Delete')."..." ?>"></input>
          		</span>
  		  <?php endif; ?>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>
